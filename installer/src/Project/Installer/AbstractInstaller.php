<?php

namespace Message\Mothership\Install\Project\Installer;

use Message\Mothership\Install\FileSystem;

abstract class AbstractInstaller implements InstallerInterface
{
	private $_dirResolver;
	private $_fileResolver;

	public function __construct()
	{
		$this->_dirResolver = new FileSystem\DirectoryResolver;
		$this->_fileResolver = new FileSystem\FileResolver;
	}

	public function install()
	{

	}
}