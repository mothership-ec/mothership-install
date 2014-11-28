<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

class Collection extends \ArrayObject
{
	public function __construct()
	{
		$files = [
			new AssetsGitignoreFile,
			new BarcodesGitignoreFile,
			new CogulesGitignoreFile,
			new DataGitignoreFile,
			new FilesGitignoreFile,
			new HtaccessFile,
			new IndexFile,
			new ResizeGitignoreFile,
		];

		parent::__construct($files);
	}
}