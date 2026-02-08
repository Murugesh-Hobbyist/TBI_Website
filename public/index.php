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

$__root = dirname(__DIR__);
$__envFile = $__root.'/.env';
$__envExample = $__root.'/.env.example';

if (!file_exists($__envFile) && file_exists($__envExample)) {
    @copy($__envExample, $__envFile);
}

if (file_exists($__envFile)) {
    $__env = @file_get_contents($__envFile);
    if ($__env !== false && !preg_match('/^APP_KEY=\\S+/m', $__env)) {
        $__key = 'base64:'.base64_encode(random_bytes(32));

        if (preg_match('/^APP_KEY=.*$/m', $__env)) {
            $__env = preg_replace('/^APP_KEY=.*$/m', 'APP_KEY='.$__key, $__env, 1) ?: $__env;
        } else {
            $__env = rtrim($__env)."\nAPP_KEY={$__key}\n";
        }

        @file_put_contents($__envFile, $__env);
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
