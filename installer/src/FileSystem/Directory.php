<?php

namespace Message\Mothership\Install\FileSystem;

class Directory
{
	private $_path;
	private $_permission;

	public function __construct($path, $permission)
	{
		$this->setPath($path);
		$this->setPermission($permission);
	}

	public function setPath($path)
	{
		if (!is_string($path)) {
			throw new \InvalidArgumentException('Path must be a string, ' . gettype($path) . ' given');
		}

		$this->_path = rtrim($path, '/');

		return $this;
	}

	public function getPath()
	{
		return $this->_path;
	}

	public function setPermission($permission)
	{
		$this->_permission = $permission;

		return $this;
	}

	public function getPermission()
	{
		return $this->_permission;
	}
}