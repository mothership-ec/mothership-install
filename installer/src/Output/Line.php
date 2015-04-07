<?php

namespace Mothership\Install\Output;

use Colors\Color;
use Colors\NoStyleFoundException;

/**
 * Class Line
 * @package Mothership\Install\Output
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class representing a line of text to display in the terminal.
 */
class Line
{
	private $_text;
	private $_foreground;
	private $_background;

	public function __construct($text, $foreground = null, $background = null)
	{
		$this->setText($text);

		if (null !== $foreground) {
			$this->setForeground($foreground);
		}

		if (null !== $background) {
			$this->setBackground($background);
		}
	}

	/**
	 * Echo text in the line object, with the background and foreground colours.
	 *
	 * @return string
	 */
	public function __toString()
	{
		try {
			$c = new Color();

			$string = $c($this->_text);

			if ($this->_foreground) {
				$string->fg($this->_foreground);
			}
			if ($this->_background) {
				$string->bg($this->_background);
			}

			return (string) $c;
		} catch (NoStyleFoundException $e) {
			return $this->_text;
		} catch (\Exception $e) {
			return get_class($e) . ' thrown!: ' . $e->getMessage();
		}
	}

	/**
	 * @param mixed $text
	 * @throws Exception\OutputException
	 *
	 * @return Line         return $this for chainability
	 */
	public function setText($text)
	{
		if (!is_string($text)) {
			throw new Exception\OutputException('Text must be a string, ' . gettype($text) . ' given');
		}

		$this->_text = $text;

		return $this;
	}

	/**
	 * @param mixed $foreground
	 * @throws Exception\OutputException
	 *
	 * @return Line         return $this for chainability
	 */
	public function setForeground($foreground)
	{
		if (!is_string($foreground)) {
			throw new Exception\OutputException('Foreground must be a string, ' . gettype($foreground) . ' given');
		}

		$this->_foreground = $foreground;

		return $this;
	}

	/**
	 * @param mixed $background
	 * @throws Exception\OutputException
	 *
	 * @return Line         return $this for chainability
	 */
	public function setBackground($background)
	{
		if (!is_string($background)) {
			throw new Exception\OutputException('Background must be a string, ' . gettype($background) . ' given');
		}

		$this->_background = $background;

		return $this;
	}
}