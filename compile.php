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

	$phar = new \Phar($build . '/' . $pharFile, \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::KEY_AS_FILENAME, $pharFile);

	$cli = file_get_contents($source . '/' . $cliFile);

	if (!$cli) {
		throw new \RuntimeException('Could not load task file');
	}

	$phar->buildFromDirectory(__DIR__ . '/' . $source);
	$phar->setStub($phar->createDefaultStub($cliFile));
} catch (\Exception $e) {
	echo $e->getMessage() . PHP_EOL;
	echo $e->getTraceAsString() . PHP_EOL;
}