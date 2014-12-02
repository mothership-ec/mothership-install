<?php

namespace Message\Mothership\Install\Project\Directory;

class TranslationsDirectory implements DirectoryInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'translations';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPermission()
	{
		return 0755;
	}
}