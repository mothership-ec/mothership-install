<?php

use Message\Mothership\Install\Exception\InvalidCommandException;
use Message\Mothership\Install\Command\Commands;
use Message\Mothership\Install\Command\OptionParser;
use Message\Mothership\Install\Project\Types;
use Message\Mothership\Install\Output;
use Message\Mothership\Install\Project\Installer\Collection as InstallCollection;

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
			$installCollection = new InstallCollection;
			$installCollection->get($options[OptionParser::TYPE])->install($options);

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