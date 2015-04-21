<?php

namespace Mothership\Install\Project\Config;

/**
 * Interface ConfigInterface
 * @package Mothership\Install\Project\Config
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Interface for config classes. These classes handle the loading and saving of config data.
 */
interface ConfigInterface
{
	/**
	 * Get the path of the config file
	 *
	 * @return string
	 */
	public function getConfigPath();

	/**
	 * Get an array of the data in the config file
	 *
	 * @param string $path
	 *
	 * @return array
	 */
	public function getConfig($path);

	/**
	 * Replace the data in the config file
	 *
	 * @param string $path
	 * @param array $config
	 */
	public function setConfig($path, array $config);

	/**
	 * Check that all the required fields exist in the config data
	 *
	 * @param array $config
	 * @throws Exception\ConfigException
	 */
	public function validateConfig(array $config);
}