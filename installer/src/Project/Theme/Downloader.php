<?php

namespace Message\Mothership\Install\Project\Theme;

use Message\Mothership\Install\FileSystem\DirectoryResolver;
use Message\Mothership\Install\Command\ShellCommand;

class Downloader
{
	private $_dirResolver;

	public function __construct()
	{
		$this->_dirResolver = new DirectoryResolver;
	}

	public function download($repo, $path)
	{
		$path = $this->_dirResolver->getAbsolute($path);

		if (!$this->_dirResolver->exists($path)) {
			$this->_dirResolver->create($path);
		}

		ShellCommand::run('git clone ' . $repo . ' ' . $path);
		$this->_dirResolver->delete($path . '/.git');
	}
}