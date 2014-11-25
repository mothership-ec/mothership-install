<?php

use Message\Mothership\Install\Exception\InvalidCommandException;
use Message\Mothership\Install\Command\Commands;
use Message\Mothership\Install\Project\Types;
use Message\Mothership\Install\Output;

/**
 * Main script for setting up a Mothership installation
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */

try {
	require_once(__DIR__ . '/autoloader.php');

	$pharPath = $argv[0];
	$command  = array_key_exists(1, $argv) ? $argv[1] : Commands::INSTALL;
	$type     = array_key_exists(2, $argv) ? $argv[2] : Types::ECOMMERCE;

	switch ($command) {
		case Commands::INSTALL :

			break;
		default :
			throw new InvalidCommandException('`' . $command . '` is not a valid command');
	}
} catch (\Exception $e) {
	$output = new Output\ExceptionOutput($e);
	$debugMode = (array_key_exists(3, $argv) && $argv[3] === Commands::DEBUG);

	if ($debugMode) {
		$output->outputDebug();
	} else {
		$output->outputError();
	}
}