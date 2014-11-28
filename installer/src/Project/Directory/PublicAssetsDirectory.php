<?php

namespace Message\Mothership\Install\Project\Directory;

class PublicAssetsDirectory implements DirectoryInterface
{
	public function getPath()
	{
		return 'public/assets';
	}

	public function getPermission()
	{
		return 0777;
	}
}