#!/usr/bin/env php
<?php

use Message\Mothership\Install\Exception\InvalidCommandException;
use Message\Mothership\Install\Command\Commands;
use Message\Mothership\Install\Command\OptionParser;
use Message\Mothership\Install\FileSystem\DirectoryResolver;
use Message\Mothership\Install\Output;
use Message\Mothership\Install\Project\Installer\Collection as InstallCollection;
use Message\Mothership\Install\Project\Init\Initialiser;

/**
 * Main script for setting up a Mothership installation
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */

try {

	$memory = ini_get('memory_limit');

	switch (substr($memory, -1)) {
		case 'M':
		case 'm':
			$memory = (int) $memory * 1048576;
			break;
		case 'K':
		case 'k':
			$memory = (int) $memory * 1024;
			break;
		case 'G':
		case 'g':
			$memory = (int) $memory * 1073741824;
			break;
		default:
			break;
	}

	if ($memory < 536870912) {
		$iniSet = ini_set('memory_limit', 536870912);
	}

	$autoloader = require_once(__DIR__ . '/autoloader.php');

	$optionParser = new OptionParser($argv);
	$options = $optionParser->getParsedOptions();

	$dirResolver = new DirectoryResolver;
	$path = (!empty($options[OptionParser::PATH]) ? $dirResolver->getAbsolute($options[OptionParser::PATH]) : $dirResolver->current());

	switch ($options[OptionParser::COMMAND]) {
		case Commands::INSTALL :
			$installCollection = new InstallCollection;
			$installCollection->get($options[OptionParser::TYPE])->install($options);

			$initialiser = new Initialiser;
			$initialiser->init($path);

			break;
		default :
			throw new InvalidCommandException('`' . $options[OptionParser::COMMAND] . '` is not a valid command');
	}
} catch (\Exception $e) {
	$output = new Output\ExceptionOutput($e);
	$debugMode = (isset($options) && !empty($options['debug']));

	if ($debugMode) {
		$output->outputDebug();
	} else {
		$output->outputError();
	}
}
