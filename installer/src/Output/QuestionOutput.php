<?php

namespace Message\Mothership\Install\Output;

class QuestionOutput extends AbstractOutput
{
	public function ask($text)
	{
		if (!is_string($text)) {
			throw new \InvalidArgumentException('Text expected to be a string, ' . gettype($text) . ' given');
		}

		$this->_outputLine($text, 'black', 'green');
	}

	public function option($text)
	{
		if (!is_string($text)) {
			throw new \InvalidArgumentException('Text expected to be a string, ' . gettype($text) . ' given');
		}

		$this->_outputLine($text, 'cyan');
	}
}