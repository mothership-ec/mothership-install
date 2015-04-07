<?php

namespace Mothership\Install\Command;

use Mothership\Install\Project\Types;

/**
 * Class OptionParser
 * @package Mothership\Install\Command
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

	/**
	 * Validate the arguments given are valid
	 *
	 * @throws \LogicException
	 * @throws \InvalidArgumentException
	 */
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

	/**
	 * Parse the arguments given.
	 *
	 * This method searches for optional arguments that start with `--` and either assign values to them, for instance if
	 * the argument passed is `--foo=bar` this will be represented as an array value of `'foo' => 'bar'`. However, if
	 * there is no `=` sign, e.g. `--foo`, this will be represented as `'foo' => true`.
	 *
	 * Once it has parsed these options, it will check for the array values with keys of 1 and 2 and assign them to the
	 * command and the type of installation to run.
	 *
	 * If no arguments are passed, it will default to an ecommerce installation
	 */
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

		if (array_key_exists(1, $this->_args)) {
			$this->_parsedOptions[self::PATH] = $this->_args[1];
		}

		if (empty($this->_parsedOptions[self::TYPE])) {
			$this->_parsedOptions[self::TYPE] = Types::ECOMMERCE;
		}

		if (empty($this->_parsedOptions[self::COMMAND])) {
			$this->_parsedOptions[self::COMMAND] = Commands::INSTALL;
		}
	}
}