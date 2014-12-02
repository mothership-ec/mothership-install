<?php

namespace Message\Mothership\Install\Project\Directory;

/**
 * Class HoldingDirectory
 * @package Message\Mothership\Install\Project\Directory
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 */
class HoldingDirectory implements DirectoryInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'holding';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPermission()
	{
		return 0755;
	}
}