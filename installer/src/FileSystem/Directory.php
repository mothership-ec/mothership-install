<?php

namespace Mothership\Install\FileSystem;

/**
 * Class Directory
 * @package Mothership\Install\FileSystem
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Model representing a directory
 */
class Directory
{
	/**
	 * @var string
	 */
	private $_path;

	/**
	 * @var int
	 */
	private $_permission;

	public function __construct($path, $permission)
	{
		$this->setPath($path);
		$this->setPermission($permission);
	}

	/**
	 * @param string $path                  Path of directory
	 * @throws \InvalidArgumentException
	 *
	 * @return Directory
	 */
	public function setPath($path)
	{
		if (!is_string($path)) {
			throw new \InvalidArgumentException('Path must be a string, ' . gettype($path) . ' given');
		}

		$this->_path = rtrim($path, '/');

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->_path;
	}

	/**
	 * Permission of directory
	 *
	 * @param int $permission
	 * @return Directory
	 */
	public function setPermission($permission)
	{
		$this->_permission = $permission;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getPermission()
	{
		return $this->_permission;
	}
}