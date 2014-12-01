<?php

namespace Message\Mothership\Install\Project\Config;

use Message\Mothership\Install\FileSystem\DirectoryResolver;
use Message\Mothership\Install\Output\QuestionOutput;

use Symfony\Component\Yaml\Yaml;

abstract class AbstractConfig implements ConfigInterface
{
	protected $_dirResolver;
	protected $_question;

	public function __construct()
	{
		$this->_dirResolver = new DirectoryResolver;
		$this->_question    = new QuestionOutput;
	}

	public function getConfig($path)
	{
		return Yaml::parse(file_get_contents(
			$this->_dirResolver->getAbsolute(rtrim($path, '/') . '/' . $this->getConfigPath())
		));
	}

	public function setConfig($path, array $config)
	{
		$this->validateConfig($config);

		$yaml = Yaml::dump($config);
		file_put_contents($this->_dirResolver->getAbsolute(rtrim($path, '/') . '/' . $this->getConfigPath()), $yaml);
	}
}