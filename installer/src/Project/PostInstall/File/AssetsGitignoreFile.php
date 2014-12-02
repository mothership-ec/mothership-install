<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

/**
 * Class AssetsGitignoreFile
 * @package Message\Mothership\Install\Project\PostInstall\File
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */
class AssetsGitignoreFile extends AbstractGitignoreFile
{
	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'public/assets';
	}
}