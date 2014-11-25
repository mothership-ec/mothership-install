<?php

$autoloader = require_once __DIR__ . '/vendor/autoload.php';

$autoloader->setPsr4(
	'Message\\Mothership\\Install\\',
	__DIR__ . '/src'
);

return $autoloader;