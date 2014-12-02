<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

/**]
 * Class CogulesGitignoreFile
 * @package Message\Mothership\Install\Project\PostInstall\File
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */
class CogulesGitignoreFile extends AbstractGitignoreFile
{
	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'public/cogules';
	}
}