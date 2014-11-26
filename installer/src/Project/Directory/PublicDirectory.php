<?php

namespace Message\Mothership\Install\Project\Directory;

class PublicDirectory implements DirectoryInterface
{
	public function getPath()
	{
		return 'public';
	}

	public function getPermission()
	{
		return 0777;
	}
}