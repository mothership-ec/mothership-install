<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

/**
 * Class TmpGitignore
 * @package Message\Mothership\Install\Project\PostInstall\File
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */
class TmpGitignoreFile extends AbstractGitignoreFile
{
	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'tmp';
	}
}