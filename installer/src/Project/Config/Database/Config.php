<?php

namespace Mothership\Install\Project\Config\Database;

use Mothership\Install\Exception\InstallFailedException;
use Mothership\Install\Project\Config\Exception;
use Mothership\Install\Project\Config\AbstractConfig;
use Mothership\Install\Project\Config\AskerInterface;

/**
 * Class Config
 * @package Mothership\Install\Project\Config\Database
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for setting the database configuration for the installation
 */
class Config extends AbstractConfig implements AskerInterface
{
	const CONFIG_PATH = 'config/db.yml';

	// Constants for config names
	const HOST    = 'hostname';
	const USER    = 'user';
	const PASS    = 'pass';
	const NAME    = 'name';
	const CACHE   = 'cache';
	const CHARSET = 'charset';

	// Required options
	private $_required = [
		self::HOST,
		self::USER,
		self::NAME,
		self::CHARSET,
	];

	// Config options to bypass
	private $_blacklist = [
		self::CHARSET,
		self::CACHE,
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
				if (in_array($key, $this->_blacklist, true)) {
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

		if (preg_match('/[\/\\.;`\'"\s]/', $dbConfig[self::NAME])) {
			throw new Exception\ConfigException('Database name `' . $dbConfig[self::NAME] . '` contains invalid characters');
		}

		$mysqlConn = 'mysql:host=' . $dbConfig[self::HOST] . ';dbname=' . $dbConfig[self::NAME];

		try {
			$pdo = @new \PDO($mysqlConn, $dbConfig[self::USER], $dbConfig[self::PASS]);
		} catch (\PDOException $e) {
			throw new Exception\ConfigException('Could not establish database connection. Please revise details and try again.');
		} catch (\ErrorException $e) {
			throw new InstallFailedException('Install aborted, an error was thrown. Message: ' . $e->getMessage());
		}

		if ($pdo->query("SHOW TABLES IN `" . $dbConfig[self::NAME] . "`")->rowCount() > 0) {
			throw new InstallFailedException('Database schema must be empty!');
		}
	}
}