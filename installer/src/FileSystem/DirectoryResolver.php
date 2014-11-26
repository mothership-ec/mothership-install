<?php

namespace Message\Mothership\Install\FileSystem;

use Message\Mothership\Install\System\SystemResolver;

class DirectoryResolver
{
	private $_sysResolver;

	public function __construct()
	{
		$this->_sysResolver = new SystemResolver;
		$this->_sysResolver->validateCompatability();
	}

	public function get($path, $force = false)
	{
		$force = (bool) $force;

		if ($this->exists($path)) {
			return new Directory($path, fileperms($this->getAbsolute($path) . '/.'));
		}
		if ($force) {
			return $this->create($path, 0755, true);
		}

		throw new Exception\DirectoryNotExistsException('Directory for `' . $path . '` does not exist!');
	}

	public function current()
	{
		exec('pwd', $output);

		return array_shift($output);
	}

	public function create($path, $permission = 0777, $recursive = true)
	{
		if (!is_string($path)) {
			throw new \InvalidArgumentException('Path must be a string, ' . gettype($path) . ' given');
		}

		if ($this->exists($path)) {
			throw new Exception\DirectoryExistsException('Path `' . $this->getAbsolute($path) . '` already exists!');
		}

		mkdir($this->getAbsolute($path), $permission, (bool) $recursive);

		return new Directory($path, $permission);
	}

	public function exists($path)
	{
		return is_dir($this->getAbsolute($path));
	}

	public function delete($path)
	{
		exec('rm -rf ' . $path);
	}

	public function getAbsolute($path)
	{
		if ($this->_isRelative($path)) {
			$path = rtrim($this->current(), '/') . '/' . $path;
		}

		return $path;
	}

	private function _isRelative($path)
	{
		return substr($path, 0, 1) !== '/';
	}
}