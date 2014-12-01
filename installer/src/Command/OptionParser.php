<?php

namespace Message\Mothership\Install\Command;

use Message\Mothership\Install\Project\Types;

/**
 * Class OptionParser
 * @package Message\Mothership\Install\Command
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for parsing the options passed to the the install command
 */
class OptionParser
{
	const PHAR_PATH = 'phar_path';
	const COMMAND   = 'command';
	const TYPE      = 'type';
	const PATH      = 'path';
	const FORCE     = 'force';
	const COMPOSER  = 'composer';
	const DEBUG     = 'debug';

	/**
	 * @var array
	 */
	private $_args;

	/**
	 * @var array
	 */
	private $_parsedOptions = [];

	public function __construct(array $args)
	{
		$this->_args = $args;
		$this->_validateArgs();
		$this->_parseOptions();
	}

	/**
	 * @return array
	 */
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
		if (!preg_match('/.+\.ph(ar|p)$/', $this->_args[0])) {
			throw new \LogicException('Phar path `' . $this->_args[0] . '`is invalid');
		}
	}

	private function _parseOptions()
	{
		$this->_parsedOptions[self::PHAR_PATH] = $this->_args[0];
		unset($this->_args[0]);

		foreach ($this->_args as $key => $arg) {
			if (preg_match('/^\-\-[A-Za-z]+.+/', $arg)) {
				$option = explode('=', $arg);
				if (count($option) > 1) {
					list($newKey, $val) = $option;
				} else {
					$newKey = array_shift($option);
					$val = true;
				}
				$newKey = str_replace('--', '', $newKey);
				if (!$newKey) {
					continue;
				}
				$val = (is_string($val)) ? trim($val, '\'"') : $val;
				$this->_parsedOptions[$newKey] = $val;
				unset($this->_args[$key]);
			}
		}

		$this->_parsedOptions[self::COMMAND] = array_key_exists(1, $this->_args) ? $this->_args[1] : Commands::INSTALL;
		$this->_parsedOptions[self::TYPE]    = array_key_exists(2, $this->_args) ? $this->_args[2] : Types::ECOMMERCE;
	}
}