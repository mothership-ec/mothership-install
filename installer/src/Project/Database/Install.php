<?php

namespace Message\Mothership\Install\Project\Database;

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
	public function __construct()
	{
		$this->_runner = new Runner;
	}

	/**
	 * Run necessary database install commands
	 *
	 * @param string $path
	 */
	public function install($path)
	{
		$this->_runner->run($path, 'migrate:install');
		$this->_runner->run($path, 'migrate:run');
	}
}