<?php

namespace Message\Mothership\Install\Project\Directory;

/**
 * Class PublicDirectory
 * @package Message\Mothership\Install\Project\Directory
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */
class PublicDirectory implements DirectoryInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'public';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPermission()
	{
		return 0777;
	}
}