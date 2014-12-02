<?php

namespace Message\Mothership\Install\Project\Directory;

/**
 * Class PublicBarcodesDirectory
 * @package Message\Mothership\Install\Project\Directory
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */
class PublicBarcodesDirectory implements DirectoryInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'public/barcodes';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPermission()
	{
		return 0777;
	}
}