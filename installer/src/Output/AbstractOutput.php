<?php

namespace Message\Mothership\Install\Output;

/**
 * Class AbstractOutput
 * @package Message\Mothership\Install\Output
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Abstract class for handling the output of text in the terminal, includes functionality for adding foreground and
 * background colours.
 */
abstract class AbstractOutput
{
	/**
	 * @var array
	 */
	private $_lines = [];

	/**
	 * Add an array of strings and output them in terminal
	 *
	 * @param array $lines
	 * @param $foregroundColour
	 * @param $backgroundColour
	 */
	protected function _outputLines(array $lines, $foregroundColour, $backgroundColour)
	{
		$this->_addLines($lines, $foregroundColour, $backgroundColour);
		$this->_output();
	}

	/**
	 * Add a single line and output it in terminal
	 *
	 * @param $text
	 * @param null $foregroundColour
	 * @param null $backgroundColour
	 */
	protected function _outputLine($text, $foregroundColour = null, $backgroundColour = null)
	{
		$this->_addLine($text, $foregroundColour, $backgroundColour);
		$this->_output();
	}

	/**
	 * Queue a single line up to be output in the terminal
	 *
	 * @param $text
	 * @param null $foregroundColour
	 * @param null $backgroundColour
	 */
	protected function _addLine($text, $foregroundColour = null, $backgroundColour = null)
	{
		$text = $this->_parseLine($text, $foregroundColour, $backgroundColour);
		$this->_addParsedLine($text);
	}

	/**
	 * Queue multiple lines to be output in the terminal
	 *
	 * @param array $lines
	 * @param $foregroundColour
	 * @param $backgroundColour
	 */
	protected function _addLines(array $lines, $foregroundColour, $backgroundColour)
	{
		foreach ($lines as $line) {
			$this->_addLine($line, $foregroundColour, $backgroundColour);
		}
	}

	/**
	 * Output all registered lines in terminal
	 */
	protected function _output()
	{
		foreach ($this->_lines as $line) {
			echo $line . PHP_EOL;
		}

		$this->_lines = [];
	}

	/**
	 * Add a line to the queue without doing any parsing
	 *
	 * @param Line $line
	 */
	private function _addParsedLine(Line $line)
	{
		$this->_lines[] = $line;
	}

	/**
	 * Add colour codes to line, trim and remove any line breaks
	 *
	 * @param $text
	 * @param null $foregroundColour
	 * @param null $backgroundColour
	 * @throws Exception\OutputException
	 *
	 * @return string
	 */
	private function _parseLine($text, $foregroundColour = null, $backgroundColour = null)
	{
		if (!is_string($text)) {
			throw new Exception\OutputException('Output text must be a string, ' . gettype($text) . ' given');
		}

		$text = trim(str_replace(PHP_EOL, ' ', $text));

		return new Line($text, $foregroundColour, $backgroundColour);
	}
}