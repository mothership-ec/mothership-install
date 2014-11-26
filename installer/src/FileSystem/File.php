<?php

namespace Message\Mothership\Install\FileSystem;

/**
 * Class File
 * @package Message\Mothership\Install\FileSystem
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */
class File
{
	private $_name;
	private $_contents;

	public function __construct($name, $contents = '')
	{
		$this->setName($name);
		$this->setContents($contents);
	}

	/**
	 * @param mixed $contents
	 * @throws \InvalidArgumentException
	 *
	 * @return File         return $this for chainability
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
	 * @return mixed
	 */
	public function getContents()
	{
		return $this->_contents;
	}

	/**
	 * @param mixed $name
	 * @throws \InvalidArgumentException
	 *
	 * @return File         return $this for chainability
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
	 * @return mixed
	 */
	public function getName()
	{
		return $this->_name;
	}
}