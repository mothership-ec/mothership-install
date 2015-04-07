<?php

namespace Mothership\Install\Bin;

use Mothership\Install\Command\ShellCommand;
use Mothership\Install\FileSystem\DirectoryResolver;

/**
 * Class Runner
 * @package Mothership\Install\Bin
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for running Cog commands. Can only be used after the installation has taken place.
 */
class Runner
{
	/**
	 * @var Validator
	 */
	private $_validator;

	/**
	 * @var \Mothership\Install\FileSystem\DirectoryResolver
	 */
	private $_dirResolver;

	public function __construct()
	{
		$this->_validator   = new Validator;
		$this->_dirResolver = new DirectoryResolver;
	}

	/**
	 * Runs Cog command
	 *
	 * @param string $path                Path of installation
	 * @param string $command             Cog command to run
	 * @throws \InvalidArgumentException
	 */
	public function run($path, $command)
	{
		if (!is_string($command)) {
			throw new \InvalidArgumentException('Command must be a string, ' . gettype($command) . ' given');
		}

		$path = $this->_parsePath($path);

		ShellCommand::Run($path . ' ' . $command);
	}

	/**
	 * Validate that the Cog bin files have been installed properly
	 *
	 * @param string $path         Path of installation
	 *
	 * @return string              Absolute path of installation
	 */
	private function _parsePath($path)
	{
		$this->_validator->validate($path);

		return rtrim($this->_dirResolver->getAbsolute($path), '/') . '/' . Paths::BINCOG;
	}
}