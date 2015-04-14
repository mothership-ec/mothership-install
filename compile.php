<?php

try {
	$vendor = 'vendor';
	$cliFile = 'cli.php';

	$source = 'installer';
	if (!is_dir($source . '/' . $vendor)) {
		throw new \LogicException('Please run `composer install` before compiling');
	}

	$build = 'build';
	$pharFile = 'mothership.phar';

	if (file_exists($build . '/' . $pharFile)) {
		echo __DIR__ . '/' . $build . '/' . $pharFile . ' already exists, deleting to rebuild' . PHP_EOL;
		unlink($build . '/' . $pharFile);
	}

	$phar = new \Phar($build . '/' . $pharFile, 0, 'mothership.phar');
    $phar->setSignatureAlgorithm(\Phar::SHA1);
    $phar->startBuffering();
	// $phar = new \Phar($build . '/' . $pharFile, \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::KEY_AS_FILENAME, $pharFile);

	$cli = file_get_contents($source . '/' . $cliFile);

	if (!$cli) {
		throw new \RuntimeException('Could not load task file');
	}

	$stub = <<<'EOF'
#!/usr/bin/env php
<?php
/*
 * Custom stub taken from composer to prevent direcory resolution errors.
 * See: https://github.com/composer/composer/blob/master/src/Composer/Compiler.php#L206
 */

// Avoid APC causing random fatal errors in composer see: https://github.com/composer/composer/issues/264
if (extension_loaded('apc') && ini_get('apc.enable_cli') && ini_get('apc.cache_by_default')) {
    if (version_compare(phpversion('apc'), '3.0.12', '>=')) {
        ini_set('apc.cache_by_default', 0);
    } else {
        fwrite(STDERR, 'Warning: APC <= 3.0.12 may cause fatal errors when running composer commands.'.PHP_EOL);
        fwrite(STDERR, 'Update APC, or set apc.enable_cli or apc.cache_by_default to 0 in your php.ini.'.PHP_EOL);
    }
}

Phar::mapPhar('mothership.phar');

require 'phar://mothership.phar/cli.php';

__HALT_COMPILER();
EOF;
	// $phar->setStub("#!/usr/bin/env php" . PHP_EOL . $phar->createDefaultStub($cliFile));
	$phar->setStub($stub);

	$phar->buildFromDirectory(__DIR__ . '/' . $source);
	$phar->stopBuffering();

} catch (\Exception $e) {
	echo $e->getMessage() . PHP_EOL;
	echo $e->getTraceAsString() . PHP_EOL;
}