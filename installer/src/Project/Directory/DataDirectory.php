<?php

namespace Message\Mothership\Install\Project\Directory;

/**
 * Class DataDirectory
 * @package Message\Mothership\Install\Project\Directory
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */
class DataDirectory implements DirectoryInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'data';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPermission()
	{
		return 0777;
	}
}