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
echo 'vendor_autoload='.(file_exists(__DIR__.'/../vendor/autoload.php') ? 'yes' : 'no')."\n";
