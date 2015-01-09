<?php

namespace Message\Mothership\Install\Project\Theme;

use Message\Mothership\Install\Output\InfoOutput;
use Message\Mothership\Install\FileSystem\DirectoryResolver;
use Message\Mothership\Install\Command\ShellCommand;

/**
 * Class Downloader
 * @package Message\Mothership\Install\Project\Theme
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for downloading a git repo into the installation, and removing it from the git archive.
 */
class Downloader
{
	/**
	 * @var \Message\Mothership\Install\FileSystem\DirectoryResolver
	 */
	private $_dirResolver;

	/**
	 * @var \Message\Mothership\Install\Output\InfoOutput
	 */
	private $_info;

	public function __construct()
	{
		$this->_dirResolver = new DirectoryResolver;
		$this->_info        = new InfoOutput;
	}

	/**
	 * Download the Git repo for a theme
	 *
	 * @param ThemeInterface $theme
	 * @param $path
	 */
	public function download(ThemeInterface $theme, $path)
	{
		$path = $this->_dirResolver->getAbsolute($path);

		if (!$this->_dirResolver->exists($path)) {
			$this->_info->info('`' . $path . '` does not exist, creating directory');
			$this->_dirResolver->create($path);
		}

		$this->_info->info('Downloading theme, this may take a while');
		ShellCommand::run('git clone -b ' . $theme->getBranch() . ' --single-branch '  . $theme->getGitRepo() . ' ' . $path);
		$this->_dirResolver->delete($path . '/.git');
		$this->_dirResolver->delete($path . '/.gitignore');
	}
}