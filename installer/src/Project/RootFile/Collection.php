<?php

namespace Message\Mothership\Install\Project\RootFile;

use Message\Mothership\Install\FileSystem\File;

/**
 * Class Collection
 * @package Message\Mothership\Install\Project\RootFile
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Collection of all the root files to be created during installation
 */
class Collection extends \ArrayObject
{
	public function __construct()
	{
		$rootFiles = [
			'autoloader' => new AutoloaderRootFile,
			'bootstrap'  => new BootstrapRootFile,
			'gitignore'  => new GitignoreRootFile,
			'namespaces' => new NamespacesRootFile,
		];

		array_walk($rootFiles, function (&$file) {
			$file = new File($file->getFilename(), $file->getContents());
		});

		parent::__construct($rootFiles);
	}
}