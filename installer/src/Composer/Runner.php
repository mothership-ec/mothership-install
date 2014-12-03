<?php

namespace Message\Mothership\Install\Composer;

use Message\Mothership\Install\Command\ShellCommand;
use Message\Mothership\Install\Output\InfoOutput;

/**
 * Class Runner
 * @package Message\Mothership\Install\Composer
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for running Composer commands
 */
class Runner
{
	/**
	 * @var \Message\Mothership\Install\Output\InfoOutput
	 */
	private $_info;

	/**
	 * @var bool
	 */
	private $_debugMode = false;

	/**
	 * List of allowed Composer commands from the `__call()` method
	 *
	 * @var array
	 */
	private $_commands = [
		'up',
		'install',
		'dumpautoload',
	];

	/**
	 * List of Composer commands that create a `vendor` directory
	 *
	 * @var array
	 */
	private $_createVendor = [
		'up',
		'install',
	];

	public function __construct()
	{
		$this->_info = new InfoOutput;
	}

	/**
	 * Run a Composer command from the list above.
	 * If debug mode is enabled and an install fails, it will run Composer's diagnostics.
	 *
	 * Composer is automatically updated before any commands are run.
	 *
	 * @param string $command                           Composer command to run
	 * @param array $args                               Arguments passed to method call. The first argument is the
	 *                                                  only one that is used, and is the path to Composer if not
	 *                                                  globally installed.
	 * @throws Exception\InvalidComposerException
	 * @throws Exception\ComposerException
	 */
	public function __call($command, $args)
	{
		if (!in_array($command, $this->_commands)) {
			throw new Exception\InvalidComposerException('`' . $command . '` is not a supported command');
		}

		$composer = 'composer';
		$path = rtrim(array_shift($args), '/');

		if (!is_dir($path)) {
			throw new Exception\InvalidComposerException('Could not change directory to `' . $path . '` as it does not exist!');
		}
		if (!file_exists($path . '/composer.json')) {
			throw new Exception\InvalidComposerException('composer.json file missing in `' . $path . '`');
		}

		if ($composerPath = array_shift($args)) {
			$composer = $this->_getComposerCommand($composerPath);
		}

		$this->selfUpdate($composer);

		chdir($path);
		$shCommand = $composer . ' ' . $command . ($this->_debugMode === true ? ' --verbose' : '');

		$this->_info->info('Running `' . $shCommand . '`, this may take a while');
		if (in_array($command, $this->_createVendor)) {
			$this->_info->info('Please note that Composer will show warnings until `message\cog` has been installed. Do not worry about these messages');
		}
		ShellCommand::run($shCommand);

		if (in_array($command, $this->_createVendor) && !is_dir($path . '/vendor')) {
			throw new Exception\ComposerException('Composer could not create vendor directory', $this->_diagnose($path, $composer));
		}
	}

	/**
	 * Enable debug mode
	 *
	 * @param bool $debugMode
	 *
	 * @return Runner
	 */
	public function debug($debugMode = true)
	{
		$this->_debugMode = (bool) $debugMode;

		return $this;
	}

	/**
	 * Update the Composer installation
	 *
	 * @param $composer
	 *
	 * @return Runner
	 */
	public function selfUpdate($composer)
	{
		$this->_info->info('Checking Composer for updates');
		ShellCommand::run($composer . ' self-update');

		return $this;
	}

	/**
	 * Run Composer's diagnostics to debug any problems
	 *
	 * @param string $path           Path of installation
	 * @param string $composer       Composer command
	 *
	 * @return mixed
	 */
	private function _diagnose($path, $composer)
	{
		chdir($path);
		ShellCommand::exec($composer . ' diagnose', $output);

		return $output;
	}

	/**
	 * Get PHP command to run Composer, if Composer is not globally installed
	 *
	 * @param string $composerPath      Absolute path to Composer installation (or bin/composer if run from source)
	 * @throws \LogicException
	 *
	 * @return string
	 */
	private function _getComposerCommand($composerPath)
	{
		if (!preg_match('/\/.*\/(bin\/composer|composer\.phar)?$/', $composerPath)) {
			throw new Exception\InvalidComposerException('`' . $composerPath . '` is not a valid Composer installation');
		} elseif (!file_exists($composerPath)) {
			throw new Exception\InvalidComposerException('`' . $composerPath . '` does not exist!');
		}

		return 'php ' . $composerPath;
	}
}