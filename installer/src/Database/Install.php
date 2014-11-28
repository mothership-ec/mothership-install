<?php

namespace Message\Mothership\Install\Database;

use Message\Mothership\Install\Bin\Runner;

class Install
{

	public function __construct()
	{
		$this->_runner = new Runner;
	}

	public function install($path)
	{
		$this->_runner->run($path, 'migrate:install');
		$this->_runner->run($path, 'migrate:run');
	}
}