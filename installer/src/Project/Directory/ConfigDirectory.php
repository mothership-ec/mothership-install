<?php

namespace Mothership\Install\Project\Directory;

/**
 * Class ConfigDirectory
 * @package Mothership\Install\Project\Directory
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */
class ConfigDirectory implements DirectoryInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'config';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPermission()
	{
		return 0777;
	}
}