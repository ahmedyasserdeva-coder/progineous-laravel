<?php
echo "PHP Version: " . phpversion() . "\n";
echo "curl.cainfo: " . ini_get('curl.cainfo') . "\n";
echo "openssl.cafile: " . ini_get('openssl.cafile') . "\n";
echo "Loaded php.ini: " . php_ini_loaded_file() . "\n";
