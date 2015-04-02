<?php

namespace Mothership\Install\Project\Config\Database;

use Mothership\Install\Exception\InstallFailedException;
use Mothership\Install\Project\Config\Exception;
use Mothership\Install\Project\Config\AbstractConfig;

/**
 * Class Config
 * @package Mothership\Install\Project\Config\Database
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for setting the database configuration for the installation
 */
class Config extends AbstractConfig
{
	const CONFIG_PATH = 'config/db.yml';

	const HOST    = 'hostname';
	const USER    = 'user';
	const PASS    = 'pass';
	const NAME    = 'name';
	const CHARSET = 'charset';

	private $_required = [
		self::HOST,
		self::USER,
		self::NAME,
		self::CHARSET,
	];

	/**
	 * {@inheritDoc}
	 */
	public function getConfigPath()
	{
		return self::CONFIG_PATH;
	}

	/**
	 * {@inheritDoc}
	 */
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

	/**
	 * {@inheritDoc}
	 */
	public function validateConfig(array $dbConfig)
	{
		foreach ($this->_required as $key) {
			if (!array_key_exists($key, $dbConfig) || !$dbConfig[$key]) {
				throw new Exception\ConfigException('Database details are missing `' . $key . '` option');
			}
		}

		$mysqlConn = 'mysql:host=' . $dbConfig[self::HOST] . ';dbname=' . $dbConfig[self::NAME];

		try {
			$pdo = @new \PDO($mysqlConn, $dbConfig[self::USER], $dbConfig[self::PASS]);
		} catch (\PDOException $e) {
			throw new Exception\ConfigException('Install aborted, could not establish database connection. Message: ' . $e->getMessage());
		} catch (\ErrorException $e) {
			throw new Exception\ConfigException('Install aborted, an error was thrown. Message: ' . $e->getMessage());
		}

		if ($pdo->query("SHOW TABLES IN " . $dbConfig[self::NAME])->rowCount() > 0) {
			throw new InstallFailedException('Database schema must be empty!');
		}
	}
}