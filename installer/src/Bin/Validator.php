<?php

namespace Mothership\Install\Bin;

use Mothership\Install\FileSystem;

/**
 * Class Validator
 * @package Mothership\Install\Bin
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Validate the existence of the Cog bin files
 */
class Validator
{
	public function __construct()
	{
		$this->_dirResolver  = new FileSystem\DirectoryResolver;
		$this->_fileResolver = new FileSystem\FileResolver;
	}

	/**
	 * Validate that the Cog bin files have been installed correctly
	 *
	 * @param string $path                          Path of installation
	 * @throws Exception\NotFoundException
	 */
	public function validate($path)
	{
		$path = $this->_dirResolver->getAbsolute(rtrim($path, '/'));
		if (!$this->_dirResolver->exists($path . '/' . Paths::BIN)) {
			throw new Exception\NotFoundException('`' . $path . '/' . Paths::BIN . '` path not found!');
		}
		if (!$this->_fileResolver->exists($path . '/' . Paths::BINCOG)) {
			throw new Exception\NotFoundException('`' . $path . '/' . Paths::BINCOG . '` not found!');
		}
	}
}