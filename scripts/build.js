const fs = require('fs');
const path = require('path');
const { spawn } = require('child_process');

function run(cmd, args, opts = {}) {
  return new Promise((resolve, reject) => {
    const p = spawn(cmd, args, { stdio: 'inherit', shell: false, ...opts });
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
  const webNext = path.join(webDir, '.next');
  const rootNext = path.join(repoRoot, '.next');

  // Build Next app in apps/web.
  await run(process.platform === 'win32' ? 'npx.cmd' : 'npx', ['next', 'build', webDir]);

  // Hostinger Next preset expects `.next` in the root output directory.
  if (!fs.existsSync(webNext)) {
    throw new Error(`Expected Next output at ${webNext} but it was not found.`);
  }

  copyDir(webNext, rootNext);
})();
