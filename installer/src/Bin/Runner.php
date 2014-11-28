<?php

namespace Message\Mothership\Install\Bin;

use Message\Mothership\Install\Command\ShellCommand;

class Runner
{
	private $_validator;

	public function __construct()
	{
		$this->_validator   = new Validator;
		$this->_dirResolver = new DirectoryResolver;
	}

	public function run($path, $command)
	{
		if (!is_string($command)) {
			throw new \InvalidArgumentException('Command must be a string, ' . gettype($command) . ' given');
		}

		$path = $this->_parsePath($path);

		ShellCommand::Run($path . ' ' . $command);
	}

	private function _parsePath($path)
	{
		$this->_validator->validate($path);

		return rtrim($this->_dirResolver->getAbsolute($path), '/') . '/' . Paths::BINCOG;
	}
}