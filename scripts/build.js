const fs = require('fs');
const path = require('path');
const { spawn } = require('child_process');

function run(cmd, args, opts = {}) {
  return new Promise((resolve, reject) => {
    const env = { ...process.env, NEXT_TELEMETRY_DISABLED: '1' };
    const p = spawn(cmd, args, { stdio: 'inherit', shell: false, env, ...opts });
    p.on('exit', (code) => {
      if (code === 0) resolve();
      else reject(new Error(`${cmd} ${args.join(' ')} failed with code ${code}`));
    });
  });
}

function ensureDir(dir) {
  fs.mkdirSync(dir, { recursive: true });
}

function replaceDir(src, dest) {
  if (fs.existsSync(dest)) fs.rmSync(dest, { recursive: true, force: true });
  ensureDir(path.dirname(dest));
  fs.cpSync(src, dest, { recursive: true });
}

function mergeDir(src, dest) {
  ensureDir(dest);
  for (const entry of fs.readdirSync(src, { withFileTypes: true })) {
    const srcPath = path.join(src, entry.name);
    const destPath = path.join(dest, entry.name);

    if (fs.existsSync(destPath)) {
      const st = fs.lstatSync(destPath);
      const destIsDir = st.isDirectory();
      const srcIsDir = entry.isDirectory();
      if (destIsDir !== srcIsDir) fs.rmSync(destPath, { recursive: true, force: true });
    }

    fs.cpSync(srcPath, destPath, { recursive: true, force: true });
  }
}

function copyFileIfMissing(src, dest) {
  if (!fs.existsSync(src)) return;
  if (fs.existsSync(dest)) return;
  ensureDir(path.dirname(dest));
  fs.copyFileSync(src, dest);
}

function safeCopyDirIfMissing(srcDir, destDir) {
  if (!fs.existsSync(srcDir) || fs.existsSync(destDir)) return;
  ensureDir(path.dirname(destDir));
  fs.cpSync(srcDir, destDir, { recursive: true });
}

function promoteNextBuildToStatic(nextDir, publishDir) {
  // When a host publishes `.next` as a static directory (no Node server),
  // `/` becomes a directory request and returns 403 unless `index.html` exists.
  // Next build already produces pre-rendered HTML under `server/pages/*.html`;
  // we promote those into the publish root and create `/_next/static` assets.

  const serverPagesDir = path.join(nextDir, 'server', 'pages');
  const pagesManifestPath = path.join(nextDir, 'server', 'pages-manifest.json');
  const staticDir = path.join(nextDir, 'static');

  // 1) Ensure `/_next/static` exists (map from `.next/static`).
  safeCopyDirIfMissing(staticDir, path.join(publishDir, '_next', 'static'));

  // 2) Ensure `/index.html` exists.
  copyFileIfMissing(path.join(serverPagesDir, 'index.html'), path.join(publishDir, 'index.html'));

  // 3) Promote other pre-rendered `.html` routes into `/<route>/index.html`.
  if (!fs.existsSync(pagesManifestPath)) return;
  const manifest = JSON.parse(fs.readFileSync(pagesManifestPath, 'utf8'));
  for (const [route, rel] of Object.entries(manifest)) {
    if (route === '/' || route.startsWith('/api')) continue;
    if (!rel.endsWith('.html')) continue;

    // Example: route "/admin/login" => publishDir/admin/login/index.html
    const srcHtml = path.join(nextDir, 'server', rel);
    const safeRoute = route.replace(/^\//, ''); // remove leading slash
    const destHtml = path.join(publishDir, safeRoute, 'index.html');
    copyFileIfMissing(srcHtml, destHtml);
  }
}

(async () => {
  const repoRoot = process.cwd();
  const webDir = path.join(repoRoot, 'apps', 'web');
  const webOut = path.join(webDir, 'out');
  const rootNext = path.join(repoRoot, '.next');
  const rootOut = path.join(repoRoot, 'out');
  const webNext = path.join(webDir, '.next');

  // Build Next app from apps/web.
  await run(process.platform === 'win32' ? 'npx.cmd' : 'npx', ['next', 'build'], { cwd: webDir });
  try {
    await run(process.platform === 'win32' ? 'npx.cmd' : 'npx', ['next', 'export', '-o', 'out'], { cwd: webDir });
  } catch (err) {
    // Export can fail if any route requires a Node server. We'll still try to publish
    // the pre-rendered HTML from the Next build output so the site is not blank.
    console.warn('next export failed; falling back to promoting Next build output for static hosting:', err.message || err);
  }

  // Hostinger static deployments serve the configured output directory as the web root.
  // In Hostinger's Next preset this is commonly `.next`, so we publish static export into root `.next`.
  if (fs.existsSync(webOut)) {
    // Hostinger may publish either `.next` at repo root OR `apps/web/.next` (depending on its root dir setting).
    // We merge the static export into both locations so `/` has `index.html` and assets resolve.
    mergeDir(webOut, webNext);
    mergeDir(webOut, rootNext);

    // Also publish a clean `out/` at repo root for platforms that support `out` as output directory.
    replaceDir(webOut, rootOut);
  }

  // Extra safety: ensure the published `.next` directories can be served statically even if export didn't run.
  promoteNextBuildToStatic(webNext, webNext);
  promoteNextBuildToStatic(webNext, rootNext);

  // Debug marker to validate which output directory is being served.
  for (const p of [webNext, rootNext, rootOut]) {
    try {
      fs.writeFileSync(path.join(p, '__export_marker.txt'), `exported:${new Date().toISOString()}\n`, 'utf8');
    } catch (_) {
      // ignore
    }
  }
})();
