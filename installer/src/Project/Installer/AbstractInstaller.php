<?php

namespace Message\Mothership\Install\Project\Installer;

use Message\Mothership\Install\FileSystem;
use Message\Mothership\Install\Command\OptionParser;
use Message\Mothership\Install\Project\Theme\Downloader as ThemeDownloader;
use Message\Mothership\Install\Project\RootFile\Collection as RootFileCollection;
use Message\Mothership\Install\Project\Directory\Collection as DirectoryCollection;
use Message\Mothership\Install\Composer\Runner as ComposerRunner;

/**
 * Class AbstractInstaller
 * @package Message\Mothership\Install\Project\Installer
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Abstract class for running the majority of the installation commands
 */
abstract class AbstractInstaller implements InstallerInterface
{
	/**
	 * @var \Message\Mothership\Install\FileSystem\DirectoryResolver
	 */
	private $_dirResolver;

	/**
	 * @var \Message\Mothership\Install\FileSystem\FileResolver
	 */
	private $_fileResolver;

	/**
	 * @var \Message\Mothership\Install\Project\Theme\Downloader
	 */
	private $_themeDownloader;

	/**
	 * @var \Message\Mothership\Install\Project\RootFile\Collection
	 */
	private $_rootFiles;

	/**
	 * @var \Message\Mothership\Install\Project\Directory\Collection
	 */
	private $_directories;

	/**
	 * @var \Message\Mothership\Install\Composer\Runner
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
		$this->_themeDownloader = new ThemeDownloader;
		$this->_rootFiles       = new RootFileCollection;
		$this->_directories     = new DirectoryCollection;
		$this->_composer        = new ComposerRunner;
	}

	/**
	 * {@inheritDoc}
	 */
	public function install(array $options)
	{
		$this->_options = $options;
		$this->_composer->debug(!empty($this->_options[OptionParser::DEBUG]));

		$path = array_key_exists(OptionParser::PATH, $this->_options) ?
			$this->_options[OptionParser::PATH] : $this->_dirResolver->current();
		$path = $this->_dirResolver->getAbsolute($path);

		$this->_themeDownloader->download($this->getTheme(), $path);
		$this->_saveRootFiles($path);
		$this->_saveDirectories($path);

		if (!empty($options[OptionParser::COMPOSER])) {
			$this->_composer->install($path, $options[OptionParser::COMPOSER]);
		} else {
			$this->_composer->install($path);
		}
	}

	/**
	 * Save the root files registered in the RootFile\Collection class
	 *
	 * @param string $path
	 */
	private function _saveRootFiles($path)
	{
		$directory = $this->_dirResolver->get($path, !empty($this->_options[OptionParser::FORCE]));

		foreach ($this->_rootFiles as $file) {
			$this->_fileResolver->create($file, $directory);
		}

		$composer = $this->getComposerTemplate();
		$composer = new FileSystem\File($composer->getFilename(), $composer->getContents());

		$this->_fileResolver->create($composer, $directory);
	}

	/**
	 * Create the directories registered in the Directory\Collection class
	 *
	 * @param string $path
	 */
	private function _saveDirectories($path)
	{
		foreach ($this->_directories as $dir) {
			$this->_dirResolver->create($path . '/' . $dir->getPath(), $dir->getPermission());
		}
	}
}