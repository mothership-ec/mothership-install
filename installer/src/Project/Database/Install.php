<?php

namespace Message\Mothership\Install\Project\Database;

use Message\Mothership\Install\Output\InfoOutput;
use Message\Mothership\Install\Bin\Runner;

/**
 * Class Install
 * @package Message\Mothership\Install\Project\Database
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Wrapper around the Runner class for installing the database
 */
class Install
{
	/**
	 * @var \Message\Mothership\Install\Bin\Runner
	 */
	private $_runner;

	/**
	 * @var \Message\Mothership\Install\Output\InfoOutput
	 */
	private $_info;

	public function __construct()
	{
		$this->_runner = new Runner;
		$this->_info   = new InfoOutput;
	}

	/**
	 * Run necessary database install commands
	 *
	 * @param string $path
	 */
	public function install($path)
	{
		$this->_info->info('Installing database tables, this might take a while');
		$this->_runner->run($path, 'migrate:install');
		$this->_runner->run($path, 'migrate:run');
	}
}