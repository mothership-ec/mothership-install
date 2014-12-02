<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

/**
 * Class AbstractGitignoreFile
 * @package Message\Mothership\Install\Project\PostInstall\File
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Abstract class for handling multiple identical .gitignore files
 */
abstract class AbstractGitignoreFile implements FileInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getFilename()
	{
		return '.gitignore';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getContents()
	{
		return <<<'EOD'
!.gitignore
EOD;

	}
}