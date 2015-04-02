<?php

namespace Mothership\Install\Output;

use Mothership\Install\Exception;

/**
 * Class ExceptionOutput
 * @package Mothership\Install\Output
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */
class ExceptionOutput extends AbstractOutput
{
	/**
	 * @var \Exception
	 */
	private $_exception;

	public function __construct(\Exception $e)
	{
		$this->_exception = $e;
	}

	/**
	 * Output basic error reporting and stack trace
	 */
	public function outputDebug()
	{
		$this->_addExceptionLines();
		$this->_addLine('Stack trace:', 'black', 'red');
		$this->_addLines($this->_getCompressedTrace(), 'red', 'dark_gray');
		$this->_output();
	}

	/**
	 * Output basic error reporting
	 */
	public function outputError()
	{
		$this->_addExceptionLines();
		$this->_output();
	}

	/**
	 * Add lines that any exception will output
	 */
	private function _addExceptionLines()
	{
		$this->_addLine(get_class($this->_exception) . ' thrown: ' . $this->_exception->getMessage(), 'white', 'red');
		$this->_addLine($this->_exception->getFile() . ' line ' . $this->_exception->getLine(), 'red');

		if ($this->_exception instanceof Exception\OutputException) {
			$this->_addLines($this->_exception->getOutput(), 'yellow', 'black');
		}
	}

	/**
	 * Flatten exception's stack trace into a one dimensional array
	 *
	 * @return array
	 */
	private function _getCompressedTrace()
	{
		$compressed = [];

		foreach ($this->_exception->getTrace() as $line) {
			$compressed[] = is_array($line) ? implode(':', $line) : $line;
		}

		return $compressed;
	}
}