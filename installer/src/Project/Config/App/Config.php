<?php

namespace Message\Mothership\Install\Project\Config\App;

use Message\Mothership\Install\Project\Config\AbstractConfig;
use Message\Mothership\Install\Project\Config\Exception;

/**
 * Class Config
 * @package Message\Mothership\Install\Project\Config\App
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for setting the application configuration for the installation
 */
class Config extends AbstractConfig
{
	const CONFIG_PATH = 'config/app.yml';

	const NAME             = 'name';
	const BASEURL          = 'base-url';
	const EMAIL            = 'default-contact-email';
	const EMAIL_FROM       = 'default-email-from';
	const EMAIL_FROM_NAME  = 'name';
	const EMAIL_FROM_EMAIL = 'email';
	const CSRF             = 'csrf-secret';
	const RESIZE           = 'image-resize';
	const DEFAULT_IMAGE    = 'default-image-path';
	const SESSION          = 'session-namespace';

	const IMAGE_RESIZE_DEFAULT = 'cogules/Mothership:Site/images/default.png';

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

		$config = $this->getConfig($path);

		$ask = [
			self::NAME    => 'Website name',
			self::EMAIL   => 'Default contact email',
			self::BASEURL => 'Base URL'
		];

		while ($asking) {
			$this->_question->ask("Please enter your application details:");
			foreach ($ask as $key => $name) {
				$this->_question->option($name . ':');
				$wait = true;
				while ($wait) {
					$fh = fopen('php://stdin', 'r');
					$input = trim(fgets($fh, 1024));
					if (null !== $input) {
						$config[$key] = ($input !== '') ? $input : $config[$key];
						$wait = false;
					}
				}
			}
			$asking = false;
		}

		$config = $this->_generateDefaults($config);

		$this->setConfig($path, $config);
	}

	/**
	 * {@inheritDoc}
	 */
	public function validateConfig(array $config)
	{
		$keys = [
			self::NAME,
			self::BASEURL,
			self::EMAIL,
			self::EMAIL_FROM,
			self::CSRF,
			self::RESIZE,
			self::SESSION,
		];

		$emailFromKeys = [
			self::EMAIL_FROM_NAME,
			self::EMAIL_FROM_EMAIL,
		];

		$imgResizeKeys = [
			self::DEFAULT_IMAGE,
		];

		foreach ($keys as $key) {
			if (!array_key_exists($key, $config)) {
				throw new Exception\ConfigException('`' . $key . '` option not found in config!');
			}
		}

		foreach ($emailFromKeys as $efKey) {
			if (!array_key_exists($efKey, $config[self::EMAIL_FROM])) {
				throw new Exception\ConfigException('`' . $efKey . '` not found in `' . self::EMAIL_FROM . '` config');
			}
		}

		foreach ($imgResizeKeys as $irKey) {
			if (!array_key_exists($irKey, $config[self::RESIZE])) {
				throw new Exception\ConfigException('`' . $irKey . '` not found in `' . self::RESIZE . '` config');
			}
		}

	}

	/**
	 * Apply automatic config settings that the user does not input during installation
	 *
	 * @param array $config
	 *
	 * @return array
	 */
	private function _generateDefaults(array $config)
	{
		$rand = mt_rand(0, 1000);
		$config[self::CSRF]    = md5(serialize($config) . $rand);
		$config[self::SESSION] = strtolower(preg_replace("/[^A-Za-z0-9]/", '', $config[self::NAME]));
		$config[self::RESIZE][self::DEFAULT_IMAGE] = self::IMAGE_RESIZE_DEFAULT;
		$config[self::EMAIL_FROM][self::EMAIL_FROM_NAME]  = $config[self::NAME];
		$config[self::EMAIL_FROM][self::EMAIL_FROM_EMAIL] = $config[self::EMAIL];

		return $config;
	}
}