<?php

namespace Mothership\Install\Project\Installer;

use Mothership\Install\FileSystem;
use Mothership\Install\Command\OptionParser;
use Mothership\Install\Project\Directory\Collection as DirectoryCollection;
use Mothership\Install\Composer\Runner as ComposerRunner;
use Mothership\Install\Output\InfoOutput;

/**
 * Class AbstractInstaller
 * @package Mothership\Install\Project\Installer
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Abstract class for running the majority of the installation commands
 */
abstract class AbstractInstaller implements InstallerInterface
{
	/**
	 * @var \Mothership\Install\FileSystem\DirectoryResolver
	 */
	private $_dirResolver;

	/**
	 * @var \Mothership\Install\FileSystem\FileResolver
	 */
	private $_fileResolver;

	/**
	 * @var \Mothership\Install\Composer\Runner
	 */
	private $_composer;

	/**
	 * @var array
	 */
	private $_options;

	public function __construct()
	{
		$this->_dirResolver     = new FileSystem\DirectoryResolver;
		$this->_fileResolver    = new FileSystem\FileResolver;
		$this->_composer        = new ComposerRunner;
		$this->_info            = new InfoOutput;
	}

	/**
	 * {@inheritDoc}
	 */
	public function install(array $options)
	{
		$this->_options = $options;

		$path = array_key_exists(OptionParser::PATH, $this->_options) ?
			$this->_options[OptionParser::PATH] : $this->_dirResolver->current();
		$path = $this->_dirResolver->getAbsolute($path);

		$this->_info->heading('Installing Mothership to ' . $path);

		if (!is_dir($path)) {
			$this->_dirResolver->create($path);
		}

		// If composer path is set in options, use that, otherwise default to global installation
		$composerPath = !empty($options[OptionParser::COMPOSER]) ? $this->_dirResolver->getAbsolute($options[OptionParser::COMPOSER]) : null;
		$installPath  = !empty($options[OptionParser::PATH]) ? $this->_dirResolver->getAbsolute($options[OptionParser::PATH]) : null;
		$this->_composer->createProject($this->getPackage(), $installPath, $composerPath);

		$this->_info->heading('Mothership filesystem set up complete!');
	}
}