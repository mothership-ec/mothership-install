<?php

namespace Message\Mothership\Install\Project\Init;

use Message\Mothership\Install\Bin\Runner as BinRunner;
use Message\Mothership\Install\Database\Config as DbConfig;
use Message\Mothership\Install\Database\Install as DbInstall;
use Message\Mothership\Install\Output\QuestionOutput;

class Initialiser
{
	private $_dbConfig;
	private $_dbInstall;
	private $_question;
	private $_binRunner;

	public function __construct()
	{
		$this->_dbConfig  = new DbConfig;
		$this->_dbInstall = new DbInstall;
		$this->_question  = new QuestionOutput;
		$this->_binRunner = new BinRunner;
	}

	public function init($path)
	{
		$dbConfig = $this->_dbConfig->getConfig($path);
		$dbConfig = $this->_askForDetails($dbConfig);
		$this->_dbConfig->setConfig($path, $dbConfig);

		$this->_dbInstall->install($path);
		$this->_binRunner->run($path, 'asset:dump');
		$this->_binRunner->run($path, 'asset:generate');
	}

	private function _askForDetails(array $dbConfig)
	{
		$asking = true;

		while ($asking) {
			$this->_question->ask("Please enter your database details:");
			foreach ($dbConfig as $key => $value) {
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