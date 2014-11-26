<?php

namespace Message\Mothership\Install\Project\Installer;

use Message\Mothership\Install\FileSystem;
use Message\Mothership\Install\Command\OptionParser;
use Message\Mothership\Install\Project\Theme\Downloader as ThemeDownloader;
use Message\Mothership\Install\Project\RootFile\Collection as RootFileCollection;
use Message\Mothership\Install\Project\Directory\Collection as DirectoryCollection;
use Message\Mothership\Install\Composer\Runner as ComposerRunner;

abstract class AbstractInstaller implements InstallerInterface
{
	private $_dirResolver;
	private $_fileResolver;
	private $_themeDownloader;
	private $_rootFiles;
	private $_directories;
	private $_composer;

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

	public function install(array $options)
	{
		$this->_options = $options;

		$path = array_key_exists(OptionParser::PATH, $this->_options) ?
			$this->_options[OptionParser::PATH] : $this->_dirResolver->current();
		$path = $this->_dirResolver->getAbsolute($path);

		$this->_themeDownloader->download($this->getTheme(), $path);
		$this->_saveRootFiles($path);
		$this->_saveDirectories($path);

		if (!empty($options[OptionParser::COMPOSER])) {
			$this->_composer->up($path, $options[OptionParser::COMPOSER]);
		} else {
			$this->_composer->up($path);
		}
	}

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

	private function _saveDirectories($path)
	{
		foreach ($this->_directories as $dir) {
			$this->_dirResolver->create($path . '/' . $dir->getPath(), $dir->getPermission());
		}
	}
}