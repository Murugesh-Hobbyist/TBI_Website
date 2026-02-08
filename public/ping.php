<?php

// Temporary deployment smoke test endpoint.
// Remove once deployment is stable.
header('Content-Type: text/plain; charset=UTF-8');
echo "ok\n";
echo 'php='.PHP_VERSION."\n";
echo 'sapi='.PHP_SAPI."\n";
foreach (['openssl', 'mbstring', 'fileinfo', 'curl', 'zip', 'pdo', 'pdo_mysql', 'pdo_sqlite'] as $ext) {
    echo $ext.'='.(extension_loaded($ext) ? 'yes' : 'no')."\n";
}
echo 'composer_json='.(file_exists(__DIR__.'/../composer.json') ? 'yes' : 'no')."\n";
echo 'composer_lock='.(file_exists(__DIR__.'/../composer.lock') ? 'yes' : 'no')."\n";
echo 'vendor_dir='.(is_dir(__DIR__.'/../vendor') ? 'yes' : 'no')."\n";
echo 'vendor_autoload='.(file_exists(__DIR__.'/../vendor/autoload.php') ? 'yes' : 'no')."\n";
echo 'bootstrap_cache_packages='.(file_exists(__DIR__.'/../bootstrap/cache/packages.php') ? 'yes' : 'no')."\n";
echo 'bootstrap_cache_services='.(file_exists(__DIR__.'/../bootstrap/cache/services.php') ? 'yes' : 'no')."\n";
echo 'env_file='.(file_exists(__DIR__.'/../.env') ? 'yes' : 'no')."\n";
if (file_exists(__DIR__.'/../.env')) {
    $env = @file_get_contents(__DIR__.'/../.env') ?: '';
    $hasKey = (bool) preg_match('/^APP_KEY=.+/m', $env);
    echo 'env_app_key_set='.($hasKey ? 'yes' : 'no')."\n";
}
