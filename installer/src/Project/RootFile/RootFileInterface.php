<?php

namespace Message\Mothership\Install\Project\RootFile;

/**
 * Interface RootFileInterface
 * @package Message\Mothership\Install\Project\RootFile
 *
 * Interface representing a file to be created in the root directory before an install has taken place
 */
interface RootFileInterface
{
	/**
	 * Get the name of the file to be created
	 *
	 * @return string
	 */
	public function getFilename();

	/**
	 * Get the contents of the file to be created
	 *
	 * @return string
	 */
	public function getContents();
}