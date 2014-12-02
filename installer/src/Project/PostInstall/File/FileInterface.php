<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

/**
 * Interface FileInterface
 * @package Message\Mothership\Install\Project\PostInstall\File
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Interface for files to be created after the installation has taken place
 */
interface FileInterface
{
	/**
	 * Get the path to the file's directory
	 *
	 * @return string
	 */
	public function getPath();

	/**
	 * Get the name of the file
	 *
	 * @return string
	 */
	public function getFilename();

	/**
	 * Get the contents of the file
	 *
	 * @return string
	 */
	public function getContents();
}