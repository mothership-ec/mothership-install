<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

/**
 * Class BarcodesGitignoreFile
 * @package Message\Mothership\Install\Project\PostInstall\File
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */
class BarcodesGitignoreFile extends AbstractGitignoreFile
{
	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'public/barcodes';
	}
}