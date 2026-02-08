<?php

// Temporary deployment smoke test endpoint.
// Remove once deployment is stable.
header('Content-Type: text/plain; charset=UTF-8');
echo "ok\n";
echo 'vendor_autoload='.(file_exists(__DIR__.'/../vendor/autoload.php') ? 'yes' : 'no')."\n";
