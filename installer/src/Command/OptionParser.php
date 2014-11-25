<?php

namespace Message\Mothership\Install\Command;

use Message\Mothership\Install\Project\Types;

class OptionParser
{
	const PHAR_PATH = 'phar_path';
	const COMMAND   = 'command';
	const TYPE      = 'type';

	private $_args;
	private $_parsedOptions = [];

	public function __construct(array $args)
	{
		$this->_args = $args;
		$this->_validateArgs();
		$this->_parseOptions();
	}

	public function getParsedOptions()
	{
		return $this->_parsedOptions;
	}

	private function _validateArgs()
	{
		foreach ($this->_args as $arg) {
			if (!is_string($arg)) {
				throw new \InvalidArgumentException('All passed arguments must be strings');
			}
		}

		if (!array_key_exists(0, $this->_args)) {
			throw new \LogicException('Option for phar path not set on args');
		}
		if (!preg_match('/.+\.phar$/', $this->_args[0])) {
			throw new \LogicException('Phar path `' . $this->_args[0] . '`is invalid');
		}
	}

	private function _parseOptions()
	{
		$this->_parsedOptions[self::PHAR_PATH] = $this->_args[0];
		unset($this->_args[0]);

		foreach ($this->_args as $key => $arg) {
			if (preg_match('/^\-\-[A-Za-z]+\=.+/', $arg)) {
				list($newKey, $val) = explode('=', $arg);
				$newKey = str_replace('--', '', $newKey);
				$this->_parsedOptions[$newKey] = $val;
				unset($this->_args[$key]);
			}
		}

		$this->_parsedOptions[self::COMMAND] = array_key_exists(1, $this->_args) ? $this->_args[1] : Commands::INSTALL;
		$this->_parsedOptions[self::TYPE]    = array_key_exists(2, $this->_args) ? $this->_args[2] : Types::ECOMMERCE;
	}
}