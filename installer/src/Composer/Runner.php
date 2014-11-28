<?php

namespace Message\Mothership\Install\Composer;

use Message\Mothership\Install\Command\ShellCommand;

class Runner
{
	private $_debugMode = false;

	private $_commands = [
		'up',
		'install',
		'dumpautoload',
	];

	private $_createVendor = [
		'up',
		'install',
	];

	public function __call($command, $args)
	{
		if (!in_array($command, $this->_commands)) {
			throw new Exception\InvalidComposerException('`' . $command . '` is not a support command');
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

		ShellCommand::run($shCommand);

		if (in_array($command, $this->_createVendor) && !is_dir($path . '/vendor')) {
			throw new Exception\ComposerException('Composer could not create vendor directory', $this->_diagnose($path, $composer));
		}
	}

	public function debug($debugMode = true)
	{
		$this->_debugMode = (bool) $debugMode;

		return $this;
	}

	public function selfUpdate($composer)
	{
		ShellCommand::run($composer . ' self-update');

		return $this;
	}

	private function _diagnose($path, $composer)
	{
		chdir($path);
		ShellCommand::exec($composer . ' diagnose', $output);

		return $output;
	}

	private function _getComposerCommand($composerPath)
	{
		if (!preg_match('/.+\/composer\.phar$/', $composerPath)) {
			throw new \LogicException('`' . $composerPath . '` is not a valid Composer installation');
		} elseif (!file_exists($composerPath)) {
			throw new \LogicException('`' . $composerPath . '` does not exist!');
		}

		return 'php ' . $composerPath;
	}
}