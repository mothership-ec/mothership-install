<?php

$autoloader = require_once __DIR__ . '/vendor/autoload.php';

$autoloader->setPsr4(
	'Mothership\\Install\\',
	__DIR__ . '/src'
);

return $autoloader;