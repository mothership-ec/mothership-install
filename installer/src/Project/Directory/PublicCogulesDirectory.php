<?php

namespace Message\Mothership\Install\Project\Directory;

class PublicCogulesDirectory implements DirectoryInterface
{
	public function getPath()
	{
		return 'public/cogules';
	}

	public function getPermission()
	{
		return 0777;
	}
}