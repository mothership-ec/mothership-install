<?php

namespace Message\Mothership\Install\Project\Installer;

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
	 * Get the path to the Git repo of the theme to check out
	 *
	 * @todo make 'Themes' a model and allow some way of varying which theme can be installed
	 *
	 * @return string
	 */
	public function getTheme();

	/**
	 * Get the contents for the `composer.json` file for this type of installation
	 *
	 * @return \Message\Mothership\Install\Project\RootFile\Composer\ComposerInterface
	 */
	public function getComposerTemplate();

	/**
	 * Run commands necessary to install the Mothership project.
	 * This includes downloading the theme, setting up the base files and directories, and running a Composer command
	 * to download any dependencies.
	 *
	 * @param array $options
	 */
	public function install(array $options);
}