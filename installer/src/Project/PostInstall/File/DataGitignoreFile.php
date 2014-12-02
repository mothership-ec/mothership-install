<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

/**
 * Class DataGitignoreFile
 * @package Message\Mothership\Install\Project\PostInstall\File
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */
class DataGitignoreFile extends AbstractGitignoreFile
{
	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'data';
	}
}