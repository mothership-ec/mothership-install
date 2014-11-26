<?php

namespace Message\Mothership\Install\Exception;

class OutputException extends \LogicException
{
	private $_output = [];

	public function __construct($message, array $output, $code = 0, \Exception $previous = null)
	{
		$this->setOutput($output);
		parent::__construct($message, $code, $previous);
	}

	public function setOutput(array $output)
	{
		$this->_output = $output;
	}

	public function getOutput()
	{
		return $this->_output;
	}
}