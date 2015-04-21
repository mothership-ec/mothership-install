<?php

namespace Mothership\Install\Composer;

use Mothership\Install\Command\ShellCommand;
use Mothership\Install\Output\InfoOutput;
use Mothership\Up\Up;

/**
 * Class Runner
 * @package Mothership\Install\Composer
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for running Composer commands
 */
class Runner
{
	/**
	 * @var \Mothership\Install\Output\InfoOutput
	 */
	private $_info;

	/**
	 * @var Up
	 */
	private $_up;

	public function __construct()
	{
		$this->_info = new InfoOutput;
		$this->_up   = new Up;
	}

	/**
	 * Run the Composer `create-project` command to download the installation from Packagist
	 * If debug mode is enabled and an install fails, it will run Composer's diagnostics.
	 *
	 * Composer is automatically updated before any commands are run.
	 *
	 * @param Package\PackageInterface $package         The package to install from Packagist
	 * @param string | null $installPath                The path in which the project will be installed. If null,
	 *                                                  defaults to current path
	 * @param string | null $composerPath               The path to the Composer installation. If null, the installer will use Up
	 *                                                  to download Mothership
	 *
	 * @throws Exception\InvalidComposerException
	 * @throws Exception\ComposerException
	 */
	public function createProject(Package\PackageInterface $package, $installPath = null, $composerPath = null)
	{
		$installPath = $this->_getInstallPath($installPath);

		$this->_info->info('Downloading Mothership, this may take a while');

		chdir($installPath);
		if (null !== $composerPath) {
			$this->_createProjectFromCustomPath($package, $installPath, $composerPath);
		} else {
			$this->_up->setBaseDir($installPath)->createProject($package->getName())->update();
		}

		if (!is_dir($installPath . '/' . 'vendor')) {
			throw new Exception\ComposerException('Composer could not create vendor directory');
		}
	}

	/**
	 * Create a project from a local Composer installation, bypassing the Up library
	 *
	 * @param Package\PackageInterface $package
	 * @param $installPath
	 * @param $composerPath
	 */
	private function _createProjectFromCustomPath(Package\PackageInterface $package, $installPath, $composerPath)
	{
		if (is_string($composerPath)) {
			$composerPath = rtrim($composerPath, '/');

			if (!file_exists($composerPath)) {
				throw new Exception\InvalidComposerException('File ' . $composerPath . ' does not exist!');
			}

			$composer = $this->_getComposerCommand($composerPath);
		} else {
			throw new Exception\InvalidComposerException('Composer path must be a string if set!');
		}

		$shCommand = $composer . ' create-project ' . $package->getName() . ' ' . $installPath . ' *';
		$upCommand = $composer . ' update';

		$this->_info->info('Running `' . $shCommand . '`, this may take a while');
		ShellCommand::run($shCommand);

		$this->_info->info('Running `' . $upCommand . '`');
		ShellCommand::run($shCommand);
	}

	/**
	 * Validate and trim the install path. If set to null, return the current path.
	 *
	 * @param string | null $installPath
	 *
	 * @return string
	 */
	private function _getInstallPath($installPath)
	{
		if ($installPath) {
			if (!is_string($installPath)) {
				throw new \InvalidArgumentException('Install path must be a string, ' . gettype($installPath) . ' given');
			}

			$installPath = rtrim($installPath, '/');
			if (!is_dir($installPath)) {
				throw new Exception\InvalidComposerException('Could not install Mothership to `' . $installPath . '` as it does not exist!`');
			}

			return $installPath;
		} else {
			return '.';
		}
	}

	/**
	 * Get command to run Composer, depending on whether it path is to source code or .phar file
	 *
	 * @param string $composerPath      Absolute path to Composer installation (or bin/composer if run from source)
	 * @throws \LogicException
	 *
	 * @return string
	 */
	private function _getComposerCommand($composerPath)
	{
		$fromSource = preg_match('/\/.*\/bin\/composer$/', $composerPath);

		if (!$fromSource && !preg_match('/\/.*\/composer\.phar$/', $composerPath)) {
			throw new Exception\InvalidComposerException('`' . $composerPath . '` is not a valid Composer installation');
		}

		if (!file_exists($composerPath)) {
			throw new Exception\InvalidComposerException('`' . $composerPath . '` does not exist!');
		}

		return ($fromSource ? '' : 'php ') . $composerPath;
	}
}