<?php

use Message\Mothership\Install\Exception\InvalidCommandException;
use Message\Mothership\Install\Command\Commands;
use Message\Mothership\Install\Command\OptionParser;
use Message\Mothership\Install\Project\Types;
use Message\Mothership\Install\Output;
use Message\Mothership\Install\FileSystem\DirectoryResolver;

/**
 * Main script for setting up a Mothership installation
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */

try {

	require_once(__DIR__ . '/autoloader.php');

	$optionParser = new OptionParser($argv);
	$options = $optionParser->getParsedOptions();

	switch ($options[OptionParser::COMMAND]) {
		case Commands::INSTALL :
				$dirResolver = new DirectoryResolver;
				$dirResolver->create('../test');
				exec('git clone git@github.com:messagedigital/mothership-skeleton-theme.git ' . $dirResolver->getAbsolute('../test'));

			break;
		default :
			throw new InvalidCommandException('`' . $options[OptionParser::COMMAND] . '` is not a valid command');
	}
} catch (\Exception $e) {
	$output = new Output\ExceptionOutput($e);
	$debugMode = (isset($options) && array_key_exists('debug', $options) && $options['debug'] === 'true');

	if ($debugMode) {
		$output->outputDebug();
	} else {
		$output->outputError();
	}
}