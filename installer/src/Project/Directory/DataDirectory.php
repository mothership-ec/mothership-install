<?php

namespace Message\Mothership\Install\Project\Directory;

class DataDirectory implements DirectoryInterface
{
	public function getPath()
	{
		return 'data';
	}

	public function getPermission()
	{
		return 0777;
	}
}