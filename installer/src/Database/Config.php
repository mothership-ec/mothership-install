<?php

namespace Message\Mothership\Install\Database;

use Message\Mothership\Install\FileSystem\DirectoryResolver;
use Symfony\Component\Yaml\Yaml;

class Config
{
	const CONFIG_PATH = 'config/db.yml';

	const HOST    = 'hostname';
	const USER    = 'user';
	const PASS    = 'pass';
	const NAME    = 'name';
	const CHARSET = 'charset';

	private $_dirResolver;

	public function __construct()
	{
		$this->_dirResolver = new DirectoryResolver;
	}

	public function getConfig($path)
	{
		return Yaml::parse(file_get_contents(
			$this->_dirResolver->getAbsolute(rtrim($path, '/') . '/' . self::CONFIG_PATH)
		));
	}

	public function setConfig($path, array $dbConfig)
	{
		$this->_validateConfig($dbConfig);

		$yaml = Yaml::dump($dbConfig);
		file_put_contents($this->_dirResolver->getAbsolute(rtrim($path, '/') . '/' . self::CONFIG_PATH), $yaml);
	}

	private function _validateConfig(array $dbConfig)
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