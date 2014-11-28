<?php

namespace Message\Mothership\Install\Project\Directory;

class TranslationsDirectory implements DirectoryInterface
{
	public function getPath()
	{
		return 'translations';
	}

	public function getPermission()
	{
		return 0755;
	}
}