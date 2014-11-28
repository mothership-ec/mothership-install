<?php

namespace Message\Mothership\Install\Project\Init;

use Message\Mothership\Install\Bin\Runner as BinRunner;
use Message\Mothership\Install\Database\Config as DbConfig;
use Message\Mothership\Install\Database\Install as DbInstall;
use Message\Mothership\Install\Output\QuestionOutput;
use Message\Mothership\Install\Project\PostInstall\File\Collection as PostInstallFiles;
use Message\Mothership\Install\FileSystem;

class Initialiser
{
	private $_dbConfig;
	private $_dbInstall;
	private $_question;
	private $_binRunner;

	public function __construct()
	{
		$this->_dbConfig         = new DbConfig;
		$this->_dbInstall        = new DbInstall;
		$this->_question         = new QuestionOutput;
		$this->_binRunner        = new BinRunner;
		$this->_postInstallFiles = new PostInstallFiles;
		$this->_dirResolver      = new FileSystem\DirectoryResolver;
		$this->_fileResolver     = new FileSystem\FileResolver;
	}

	public function init($path)
	{
		$dbConfig = $this->_dbConfig->getConfig($path);
		$dbConfig = $this->_askForDetails($dbConfig);
		$this->_dbConfig->setConfig($path, $dbConfig);

		$this->_dbInstall->install($path);
		$this->_binRunner->run($path, 'asset:dump');
		$this->_binRunner->run($path, 'asset:generate');

		$this->_createPostInstallFiles();

		$this->_dirResolver->chmodR('public', 0777);
	}

	private function _createPostInstallFiles()
	{
		foreach ($this->_postInstallFiles as $file) {
			$directory = $this->_dirResolver->get($file->getPath());
			$file      = new FileSystem\File($file->getFilename(), $file->getContents());
			$this->_fileResolver->create($file, $directory);
		}
	}

	private function _askForDetails(array $dbConfig)
	{
		$asking = true;

		while ($asking) {
			$this->_question->ask("Please enter your database details:");
			foreach ($dbConfig as $key => $value) {
				if ($key === DbConfig::CHARSET) {
					continue;
				}
				$this->_question->option($key . ' (defaults to `' . $value . '`):');
				$wait = true;
				while ($wait) {
					$fh = fopen('php://stdin', 'r');
					$input = fgets($fh, 1024);
					if (null !== $input) {
						$dbConfig[$key] = (trim($input) !== '') ? trim($input) : $value;
						$wait = false;
					}
				}
			}
			$asking = false;
		}

		return $dbConfig;
	}
}