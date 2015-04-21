<?php

namespace Mothership\Install\FileSystem;

use Mothership\Install\System\SystemResolver;
use Mothership\Install\Command\ShellCommand;

/**
 * Class DirectoryResolver
 * @package Mothership\Install\FileSystem
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for handling changes to directories in the file system
 *
 * @todo allow installation on Windows machines
 */
class DirectoryResolver
{
	/**
	 * @var \Mothership\Install\System\SystemResolver
	 */
	private $_sysResolver;

	public function __construct()
	{
		$this->_sysResolver = new SystemResolver;
		$this->_sysResolver->validateCompatibility();
	}

	/**
	 * Get a Directory instance from a path
	 *
	 * @param string $path                              Path of directory
	 * @param bool $force                               Force creation of directory if not exists
	 *
	 * @throws Exception\DirectoryNotExistsException
	 *
	 * @return Directory
	 */
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

	/**
	 * Get path of current directory
	 *
	 * @return string
	 */
	public function current()
	{
		ShellCommand::exec('pwd', $output);

		return array_shift($output);
	}

	/**
	 * Create a directory and return the instance
	 *
	 * @param string $path       Path to create
	 * @param int $permission    Permission of newly created directory
	 * @param bool $recursive    Create directories recursively
	 *
	 * @throws Exception\DirectoryExistsException
	 * @throws \InvalidArgumentException
	 *
	 * @return Directory
	 */
	public function create($path, $permission = 0777, $recursive = true)
	{
		$path = $this->getAbsolute($path);

		if (!is_string($path)) {
			throw new \InvalidArgumentException('Path must be a string, ' . gettype($path) . ' given');
		}

		if ($this->exists($path)) {
			throw new Exception\DirectoryExistsException('Path `' . $this->getAbsolute($path) . '` already exists!');
		}

		$oldUmask = umask(0);
		$mkdir = mkdir($path, $permission, (bool) $recursive);
		umask($oldUmask);

		if (!$mkdir) {
			throw new Exception\DirectoryNotExistsException('Could not create directory at `' . $path);
		}

		return new Directory($path, $permission);
	}

	/**
	 * Check to see if directory exists
	 *
	 * @param string $path      Path to check
	 *
	 * @return bool
	 */
	public function exists($path)
	{
		return is_dir($this->getAbsolute($path));
	}

	/**
	 * Change the permissions of a directory
	 *
	 * @param string $path        Path of directory
	 * @param int $permission     Permission code to change to
	 */
	public function chmod($path, $permission)
	{
		$path = $this->getAbsolute($path);
		$oldUmask = umask(0);
		chmod($path, $permission);
		umask($oldUmask);
	}

	/**
	 * Change the permissions of a directory recursively
	 *
	 * @param string $path      Path of directory
	 * @param int $permission   Permission code to change to
	 */
	public function chmodR($path, $permission)
	{
		$oldUmask = umask(0);
		$path = $this->getAbsolute($path);
		$permission = sprintf("%04o", $permission);
		ShellCommand::run('chmod -R ' . $permission . ' ' . $path);
		umask($oldUmask);
	}

	/**
	 * Remove a directory
	 *
	 * @param $path      Directory to remove
	 */
	public function delete($path)
	{
		ShellCommand::run('rm -rf ' . $path);
	}

	/**
	 * Check to see if a directory is empty
	 *
	 * @param $path
	 *
	 * @return bool
	 */
	public function isEmpty($path)
	{
		$path = $this->getAbsolute($path);

		if ($this->exists($path)) {
			$handle = opendir($path);

			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Get absolute path of directory
	 *
	 * @param string $path      Path of directory
	 *
	 * @return string
	 */
	public function getAbsolute($path)
	{
		if ($this->_isRelative($path)) {
			$path = rtrim($this->current(), '/') . '/' . $path;
		}

		return $path;
	}

	/**
	 * Check to see if a path is relative.
	 * Worth noting that this method is dumb, and only checks that the first character is a slash
	 *
	 * @param string $path
	 *
	 * @return bool
	 */
	private function _isRelative($path)
	{
		return substr($path, 0, 1) !== '/';
	}
}