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

	public function __construct()
	{
		$this->_info = new InfoOutput;
	}

	/**
	 * Run the Composer `create-project` command to download the installation from Packagist
	 * If debug mode is enabled and an install fails, it will run Composer's diagnostics.
	 *
	 * Composer is automatically updated before any commands are run.
	 *
	 * @param array $composerPath                       The path to Composer if not globally installed.
	 * @throws Exception\InvalidComposerException
	 * @throws Exception\ComposerException
	 */
	public function createProject(Package\PackageInterface $package, $composerPath = null)
	{
		$composer = 'composer';

		if (is_string($composerPath)) {
			$composerPath = rtrim($composerPath, '/');
			if (!is_dir($composerPath)) {
				throw new Exception\InvalidComposerException('Could not change directory to `' . $composerPath . '` as it does not exist!');
			}

			if ($composerPath = array_shift($args)) {
				$composer = $this->_getComposerCommand($composerPath);
			}
		} elseif ($composerPath) {
			throw new Exception\InvalidComposerException('Composer path must be a string if set!');
		}

		$this->selfUpdate($composer);

		chdir($composerPath);
		$shCommand = $composer . ' create-project ' . $package->getName() . ($this->_debugMode === true ? ' --verbose' : '');

		$this->_info->info('Running `' . $shCommand . '`, this may take a while');
		$this->_info->info('Please note that Composer will show warnings until `mothership-ec\cog` has been installed. Do not worry about these messages, Composer has been set to create config files once Cog has been installed.');

		ShellCommand::run($shCommand);

		if (!is_dir($composerPath . '/vendor')) {
			throw new Exception\ComposerException('Composer could not create vendor directory', $this->_diagnose($composerPath, $composer));
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