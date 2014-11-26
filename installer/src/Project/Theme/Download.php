<?php

namespace Message\Mothership\Install\Project\Theme;

use Message\Mothership\Install\FileSystem\DirectoryResolver;

class Download
{
	private $_dirResolver;

	public function __construct()
	{
		$this->_dirResolver = new DirectoryResolver;
	}

	public function download($repo, $path)
	{
		$path = $this->_dirResolver->getAbsolute($path);

		exec('git clone ' . $repo . ' ' . $path);
	}
}