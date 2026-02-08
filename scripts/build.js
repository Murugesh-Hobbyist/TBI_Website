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

function copyDir(src, dest) {
  if (fs.existsSync(dest)) {
    fs.rmSync(dest, { recursive: true, force: true });
  }
  fs.mkdirSync(path.dirname(dest), { recursive: true });

  // Node 18+ supports cpSync.
  fs.cpSync(src, dest, { recursive: true });
}

(async () => {
  const repoRoot = process.cwd();
  const webDir = path.join(repoRoot, 'apps', 'web');
  const webOut = path.join(webDir, 'out');
  const rootOutA = path.join(repoRoot, '.next');
  const rootOutB = path.join(repoRoot, 'out');

  // Build and export Next app from apps/web.
  await run(process.platform === 'win32' ? 'npx.cmd' : 'npx', ['next', 'build'], { cwd: webDir });
  await run(process.platform === 'win32' ? 'npx.cmd' : 'npx', ['next', 'export', '-o', 'out'], { cwd: webDir });

  // Hostinger static deployments serve the configured output directory as the web root.
  // In Hostinger's Next preset this is commonly `.next`, so we publish static export into root `.next`.
  if (!fs.existsSync(webOut)) {
    throw new Error(`Expected export output at ${webOut} but it was not found.`);
  }

  copyDir(webOut, rootOutA);
  copyDir(webOut, rootOutB);
})();
