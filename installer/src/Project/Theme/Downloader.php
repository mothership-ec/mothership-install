<?php

namespace Message\Mothership\Install\Project\Theme;

use Message\Mothership\Install\FileSystem\DirectoryResolver;
use Message\Mothership\Install\Command\ShellCommand;

/**
 * Class Downloader
 * @package Message\Mothership\Install\Project\Theme
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for downloading a git repo into the installation, and removing it from the git archive.
 *
 * @todo implement the ability to register multiple themes, and select which one you want to use in the install command
 * @todo Allow themes to live on a specific branch
 * @todo Create a `Theme` object to store the repo URL and branch name
 */
class Downloader
{
	/**
	 * @var \Message\Mothership\Install\FileSystem\DirectoryResolver
	 */
	private $_dirResolver;

	public function __construct()
	{
		$this->_dirResolver = new DirectoryResolver;
	}

	/**
	 * Download the Git repo for the theme
	 *
	 * @param string $repo     The Git repo's clone URL
	 * @param string $path     The path of the installation
	 */
	public function download($repo, $path)
	{
		$path = $this->_dirResolver->getAbsolute($path);

		if (!$this->_dirResolver->exists($path)) {
			$this->_dirResolver->create($path);
		}

		ShellCommand::run('git clone ' . $repo . ' ' . $path);
		$this->_dirResolver->delete($path . '/.git');
	}
}