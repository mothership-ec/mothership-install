<?php

namespace Message\Mothership\Install\Project\Installer;

use Message\Mothership\Install\Composer\Package\PackageInterface;

/**
 * Interface InstallerInterface
 * @package Message\Mothership\Install\Project\Installer
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Interface for classes that run the initial install of the project
 */
interface InstallerInterface
{
	/**
	 * Get name of installer. These relate to the 'type' option passed in when the command is run.
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * Get the package to download as the basis for the project installation
	 *
	 * @return PackageInterface
	 */
	public function getPackage();

	/**
	 * Run commands necessary to install the Mothership project.
	 * This includes downloading the theme, setting up the base files and directories, and running a Composer command
	 * to download any dependencies.
	 *
	 * @param array $options
	 */
	public function install(array $options);
}