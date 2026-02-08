<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Shared Hosting Bootstrap (Hostinger)
|--------------------------------------------------------------------------
|
| Some Git-based deployments do not provision a .env file automatically.
| Laravel's "web" middleware requires APP_KEY for cookie encryption.
|
| If no .env exists, copy .env.example and generate a random APP_KEY.
| This keeps the site bootable without requiring SSH access.
|
*/

$__host = (string) ($_SERVER['HTTP_HOST'] ?? '');
$__hostBase = strtolower((string) strtok($__host, ':'));
$__isLocalHost = in_array($__hostBase, ['localhost', '127.0.0.1', '::1'], true);

$__root = dirname(__DIR__);
$__envFile = $__root.'/.env';
$__envExample = $__root.'/.env.example';

// Avoid mutating local development environments.
if (!$__isLocalHost && !file_exists($__envFile) && file_exists($__envExample)) {
    @copy($__envExample, $__envFile);
}

if (!$__isLocalHost && file_exists($__envFile)) {
    $__env = @file_get_contents($__envFile);
    if ($__env !== false) {
        $__dirty = false;

        // Ensure APP_KEY is set (required for cookies/sessions).
        if (!preg_match('/^APP_KEY=\\S+/m', $__env)) {
            $__key = 'base64:'.base64_encode(random_bytes(32));
            $__dirty = true;

            if (preg_match('/^APP_KEY=.*$/m', $__env)) {
                $__env = preg_replace('/^APP_KEY=.*$/m', 'APP_KEY='.$__key, $__env, 1) ?: $__env;
            } else {
                $__env = rtrim($__env)."\nAPP_KEY={$__key}\n";
            }
        }

        // Production-safe defaults for shared hosting (avoid leaking stack traces).
        if (preg_match('/^APP_ENV=local\\s*$/m', $__env)) {
            $__env = preg_replace('/^APP_ENV=local\\s*$/m', 'APP_ENV=production', $__env, 1) ?: $__env;
            $__dirty = true;
        }

        if (preg_match('/^APP_DEBUG=true\\s*$/m', $__env)) {
            $__env = preg_replace('/^APP_DEBUG=true\\s*$/m', 'APP_DEBUG=false', $__env, 1) ?: $__env;
            $__dirty = true;
        }

        // Prevent DB-backed session failures until DB credentials are configured.
        if (preg_match('/^SESSION_DRIVER=database\\s*$/m', $__env)) {
            $__env = preg_replace('/^SESSION_DRIVER=database\\s*$/m', 'SESSION_DRIVER=file', $__env, 1) ?: $__env;
            $__dirty = true;
        }

        // Keep queues working without needing DB tables.
        if (preg_match('/^QUEUE_CONNECTION=database\\s*$/m', $__env)) {
            $__env = preg_replace('/^QUEUE_CONNECTION=database\\s*$/m', 'QUEUE_CONNECTION=sync', $__env, 1) ?: $__env;
            $__dirty = true;
        }

        if ($__dirty) {
            @file_put_contents($__envFile, $__env);
        }
    }
}

/*
|--------------------------------------------------------------------------
| Clear Stale Laravel Cache Files (Shared Hosting)
|--------------------------------------------------------------------------
|
| Some shared-hosting deploy flows copy files but do not run artisan commands.
| If route/config cache files exist from a previous deploy, new routes/env
| values will not take effect (e.g. /install returning 404).
|
| We defensively delete stale cache files when their sources are newer.
|
*/

if (!$__isLocalHost) {
    $__cacheDir = $__root.'/bootstrap/cache';

    // Route cache: clear if routes/*.php are newer than cached routes.
    $__routesMtime = max(
        @filemtime($__root.'/routes/web.php') ?: 0,
        @filemtime($__root.'/routes/api.php') ?: 0
    );

    if (is_dir($__cacheDir) && $__routesMtime > 0) {
        foreach ((array) glob($__cacheDir.'/routes-*.php') as $__f) {
            if (is_file($__f) && @filemtime($__f) < $__routesMtime) {
                @unlink($__f);
            }
        }

        $__legacyRoutes = $__cacheDir.'/routes.php';
        if (is_file($__legacyRoutes) && @filemtime($__legacyRoutes) < $__routesMtime) {
            @unlink($__legacyRoutes);
        }
    }

    // Config cache: clear if .env is newer than cached config.
    $__configCache = $__cacheDir.'/config.php';
    if (is_file($__configCache) && is_file($__envFile) && @filemtime($__configCache) < @filemtime($__envFile)) {
        @unlink($__configCache);
    }
}

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
| 
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
