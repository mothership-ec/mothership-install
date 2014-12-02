<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

/**
 * Class ResizeGitignoreFile
 * @package Message\Mothership\Install\Project\PostInstall\File
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */
class ResizeGitignoreFile extends AbstractGitignoreFile
{
	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'public/resize';
	}
}