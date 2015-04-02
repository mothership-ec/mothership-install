<?php

namespace Mothership\Install\FileSystem;

/**
 * Class File
 * @package Mothership\Install\FileSystem
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class representing a file BEFORE it has been created
 */
class File
{
	/**
	 * @var string
	 */
	private $_name;

	/**
	 * @var string
	 */
	private $_contents;

	public function __construct($name, $contents = '')
	{
		$this->setName($name);
		$this->setContents($contents);
	}

	/**
	 * Set the contents of the file
	 *
	 * @param string $contents                The contents of the file
	 * @throws \InvalidArgumentException
	 *
	 * @return File
	 */
	public function setContents($contents)
	{
		if (!is_string($contents)) {
			throw new \InvalidArgumentException('Contents must be a string, ' . gettype($contents) . ' given');
		}

		$this->_contents = $contents;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getContents()
	{
		return $this->_contents;
	}

	/**
	 * Set the name of the file
	 *
	 * @param string $name                     The name of the file
	 * @throws \InvalidArgumentException
	 *
	 * @return File
	 */
	public function setName($name)
	{
		if (!is_string($name)) {
			throw new \InvalidArgumentException('Contents must be a string, ' . gettype($name) . ' given');
		}

		$this->_name = $name;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}
}