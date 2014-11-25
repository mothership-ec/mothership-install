<?php

$source = 'installer';
$cliFile = 'cli.php';

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