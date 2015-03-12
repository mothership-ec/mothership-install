<?php

namespace Message\Mothership\Install\Project\Config;

use Message\Mothership\Install\Exception\InstallFailedException;
use Message\Mothership\Install\FileSystem\DirectoryResolver;
use Message\Mothership\Install\Output\QuestionOutput;
use Message\Mothership\Install\Output\InfoOutput;

use Symfony\Component\Yaml\Yaml;

/**
 * Class AbstractConfig
 * @package Message\Mothership\Install\Project\Config
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Abstract class that handles the loading and saving of config data, without handling validation or requesting config
 * settings from the user.
 */
abstract class AbstractConfig implements ConfigInterface
{
	/**
	 * @var \Message\Mothership\Install\FileSystem\DirectoryResolver
	 */
	protected $_dirResolver;

	/**
	 * @var \Message\Mothership\Install\Output\QuestionOutput
	 */
	protected $_question;

	public function __construct()
	{
		$this->_dirResolver = new DirectoryResolver;
		$this->_question    = new QuestionOutput;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getConfig($path)
	{
		$path = $this->_dirResolver->getAbsolute(rtrim($path, '/') . '/' . $this->getConfigPath());

		$config = @Yaml::parse(file_get_contents($path));

		if (!$config) {
			throw new InstallFailedException('Could not load config file from `' . $path . '`');
		}

		return $config;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setConfig($path, array $config)
	{
		$this->validateConfig($config);

		$yaml = Yaml::dump($config);
		file_put_contents($this->_dirResolver->getAbsolute(rtrim($path, '/') . '/' . $this->getConfigPath()), $yaml);
	}
}