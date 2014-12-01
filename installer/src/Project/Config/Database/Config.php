<?php

namespace Message\Mothership\Install\Project\Config\Database;

use Message\Mothership\Install\Project\Config\Exception;
use Message\Mothership\Install\Project\Config\AbstractConfig;

class Config extends AbstractConfig
{
	const CONFIG_PATH = 'config/db.yml';

	const HOST    = 'hostname';
	const USER    = 'user';
	const PASS    = 'pass';
	const NAME    = 'name';
	const CHARSET = 'charset';

	public function getConfigPath()
	{
		return self::CONFIG_PATH;
	}

	public function askForDetails($path)
	{
		$asking = true;

		$dbConfig = $this->getConfig($path);

		while ($asking) {
			$this->_question->ask("Please enter your database details:");
			foreach ($dbConfig as $key => $value) {
				if ($key === self::CHARSET) {
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

		$this->setConfig($path, $dbConfig);
	}

	public function validateConfig(array $dbConfig)
	{
		$required = [
			self::HOST,
			self::USER,
			self::PASS,
			self::CHARSET,
		];

		foreach ($required as $key) {
			if (!array_key_exists($key, $dbConfig) || !$dbConfig[$key]) {
				throw new Exception\ConfigException('Database details are missing `' . $key . '` option');
			}
		}
	}
}