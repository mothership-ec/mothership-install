<?php

namespace Message\Mothership\Install\Output;

/**
 * Class QuestionOutput
 * @package Message\Mothership\Install\Output
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for handling the output of questions for user input
 */
class QuestionOutput extends AbstractOutput
{
	/**
	 * Output text that asks the user a question
	 *
	 * @param $text
	 * @throws \InvalidArgumentException
	 */
	public function ask($text)
	{
		if (!is_string($text)) {
			throw new \InvalidArgumentException('Text expected to be a string, ' . gettype($text) . ' given');
		}

		$this->_outputLine($text, 'black', 'green');
	}

	/**
	 * Output text that gives a field that the user needs to fill out
	 *
	 * @param $text
	 * @throws \InvalidArgumentException
	 */
	public function option($text)
	{
		if (!is_string($text)) {
			throw new \InvalidArgumentException('Text expected to be a string, ' . gettype($text) . ' given');
		}

		$this->_outputLine($text, 'cyan');
	}
}