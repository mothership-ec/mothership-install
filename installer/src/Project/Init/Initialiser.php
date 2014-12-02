<?php

namespace Message\Mothership\Install\Project\Init;

use Message\Mothership\Install\Bin\Runner as BinRunner;
use Message\Mothership\Install\Project\Config\App\Config as AppConfig;
use Message\Mothership\Install\Project\Config\Database\Config as DbConfig;
use Message\Mothership\Install\Project\Database\Install as DbInstall;
use Message\Mothership\Install\Output\QuestionOutput;
use Message\Mothership\Install\Project\PostInstall\File\Collection as PostInstallFiles;
use Message\Mothership\Install\FileSystem;

/**
 * Class Initialiser
 * @package Message\Mothership\Install\Project\Init
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class to handle post-installation setup.
 * This class handles anything that relies on the installation being complete, such as running Cog commands.
 */
class Initialiser
{
	private $_appConfig;
	private $_dbConfig;
	private $_dbInstall;
	private $_question;
	private $_binRunner;
	private $_postInstallFiles;
	private $_dirResolver;
	private $_fileResolver;

	public function __construct()
	{
		$this->_appConfig        = new AppConfig;
		$this->_dbConfig         = new DbConfig;
		$this->_dbInstall        = new DbInstall;
		$this->_question         = new QuestionOutput;
		$this->_binRunner        = new BinRunner;
		$this->_postInstallFiles = new PostInstallFiles;
		$this->_dirResolver      = new FileSystem\DirectoryResolver;
		$this->_fileResolver     = new FileSystem\FileResolver;
	}

	/**
	 * Run post-installation tasks
	 *
	 * @param string $path
	 */
	public function init($path)
	{
		$this->_appConfig->askForDetails($path);

		$this->_dbConfig->askForDetails($path);
		$this->_dbInstall->install($path);

		$this->_binRunner->run($path, 'asset:dump');
		$this->_binRunner->run($path, 'asset:generate');

		$this->_createPostInstallFiles();

		$this->_dirResolver->chmodR('public', 0777);

		$this->_binRunner->run($path, 'task:run user:create_admin');
	}

	/**
	 * Create files that exist in directories that were created during the installation setup
	 */
	private function _createPostInstallFiles()
	{
		foreach ($this->_postInstallFiles as $file) {
			$directory = $this->_dirResolver->get($file->getPath());
			$file      = new FileSystem\File($file->getFilename(), $file->getContents());
			$this->_fileResolver->create($file, $directory);
		}
	}


}