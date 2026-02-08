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

(async () => {
  const repoRoot = process.cwd();
  const webDir = path.join(repoRoot, 'apps', 'web');
  const webOut = path.join(webDir, 'out');
  const rootNext = path.join(repoRoot, '.next');
  const rootOut = path.join(repoRoot, 'out');
  const webNext = path.join(webDir, '.next');

  // Build and export Next app from apps/web.
  await run(process.platform === 'win32' ? 'npx.cmd' : 'npx', ['next', 'build'], { cwd: webDir });
  await run(process.platform === 'win32' ? 'npx.cmd' : 'npx', ['next', 'export', '-o', 'out'], { cwd: webDir });

  // Hostinger static deployments serve the configured output directory as the web root.
  // In Hostinger's Next preset this is commonly `.next`, so we publish static export into root `.next`.
  if (!fs.existsSync(webOut)) {
    throw new Error(`Expected export output at ${webOut} but it was not found.`);
  }

  // Hostinger may publish either `.next` at repo root OR `apps/web/.next` (depending on its root dir setting).
  // We merge the static export into both locations so `/` has `index.html` and assets resolve.
  mergeDir(webOut, webNext);
  mergeDir(webOut, rootNext);

  // Also publish a clean `out/` at repo root for platforms that support `out` as output directory.
  replaceDir(webOut, rootOut);

  // Debug marker to validate which output directory is being served.
  for (const p of [webNext, rootNext, rootOut]) {
    try {
      fs.writeFileSync(path.join(p, '__export_marker.txt'), `exported:${new Date().toISOString()}\n`, 'utf8');
    } catch (_) {
      // ignore
    }
  }
})();
