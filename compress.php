<?php

$source = '.';
$build = 'build';

$phar = new \Phar($build . '/ms-install.phar', \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::KEY_AS_FILENAME, 'ms-install.phar');
$phar->compress(\Phar::NONE);

$cli = file_get_contents($source . '/cli.php');

if (!$cli) {
	throw new \Exception('goddamnit');
}

$phar['cli.php'] = file_get_contents($source . '/cli.php');