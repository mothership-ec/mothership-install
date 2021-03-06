<?php

namespace Mothership\Install\Project\Init;

use Mothership\Install\Bin\Runner as BinRunner;
use Mothership\Install\Project\Config\App\Config as AppConfig;
use Mothership\Install\Project\Config\Database\Config as DbConfig;
use Mothership\Install\Project\Config\Exception\ConfigException;
use Mothership\Install\Project\Database\Install as DbInstall;
use Mothership\Install\Output\QuestionOutput;
use Mothership\Install\Project\PostInstall\File\Collection as PostInstallFiles;
use Mothership\Install\FileSystem;
use Mothership\Install\Output\InfoOutput;

/**
 * Class Initialiser
 * @package Mothership\Install\Project\Init
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class to handle post-installation setup.
 * This class handles anything that relies on the installation being complete, such as running Cog commands.
 */
class Initialiser
{
	/**
	 * @var \Mothership\Install\Project\Config\App\Config
	 */
	private $_appConfig;

	/**
	 * @var \Mothership\Install\Project\Config\Database\Config
	 */
	private $_dbConfig;

	/**
	 * @var \Mothership\Install\Project\Database\Install
	 */
	private $_dbInstall;

	/**
	 * @var \Mothership\Install\Output\QuestionOutput
	 */
	private $_question;

	/**
	 * @var \Mothership\Install\Bin\Runner
	 */
	private $_binRunner;

	/**
	 * @var \Mothership\Install\FileSystem\DirectoryResolver
	 */
	private $_dirResolver;

	/**
	 * @var \Mothership\Install\FileSystem\FileResolver
	 */
	private $_fileResolver;

	/**
	 * @var \Mothership\Install\Output\InfoOutput
	 */
	private $_info;

	private $_writableDirs = [
		'public',
		'tmp',
		'logs',
		'data',
	];

	public function __construct()
	{
		$this->_appConfig        = new AppConfig;
		$this->_dbConfig         = new DbConfig;
		$this->_dbInstall        = new DbInstall;
		$this->_question         = new QuestionOutput;
		$this->_binRunner        = new BinRunner;
		$this->_dirResolver      = new FileSystem\DirectoryResolver;
		$this->_fileResolver     = new FileSystem\FileResolver;
		$this->_info             = new InfoOutput;
	}

	/**
	 * Run post-installation tasks
	 *
	 * @param string $path
	 */
	public function init($path)
	{
		$this->_info->heading('Initialising Mothership installation');

		$this->_appConfig->askForDetails($path);

		$this->_dbConfig->askForDetails($path);
		$this->_dbInstall->install($path);

		$this->_info->info('Copying assets into project, this might take a while');

		$this->_binRunner->run($path, 'asset:dump');
		$this->_binRunner->run($path, 'asset:generate');

		foreach ($this->_writableDirs as $dir) {
			if (!$this->_dirResolver->exists(rtrim($path, '/') . '/' . $dir)) {
				$this->_dirResolver->create(rtrim($path, '/') . '/' . $dir);
			}
			$this->_dirResolver->chmodR(rtrim($path, '/') . '/' . $dir, 0777);
		}

		$this->_binRunner->run($path, 'task:run user:create_admin');

		$this->_info->heading('Initialisation complete! Navigate to `[your URL]/admin` in your browser to start adding content. Be sure to check out http://wiki.mothership.ec and http://forum.mothership.ec for more help with setting up your Mothership site!');
	}

}