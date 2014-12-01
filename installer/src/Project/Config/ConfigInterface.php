<?php

namespace Message\Mothership\Install\Project\Config;

interface ConfigInterface
{
	public function getConfigPath();

	public function getConfig($path);

	public function setConfig($path, array $config);

	public function askForDetails($path);

	public function validateConfig(array $config);
}