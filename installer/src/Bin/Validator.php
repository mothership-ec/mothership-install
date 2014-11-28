<?php

namespace Message\Mothership\Install\Bin;

use Message\Mothership\Install\Filesystem;

class Validator
{

	public function __construct()
	{
		$this->_dirResolver  = new Filesystem\DirectoryResolver;
		$this->_fileResolver = new Filesystem\FileResolver;
	}

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