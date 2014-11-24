<?php

$p = new \Phar('ms-install.phar', \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::KEY_AS_FILENAME, 'msinstall.phar');
$p->compress(\Phar::NONE);
