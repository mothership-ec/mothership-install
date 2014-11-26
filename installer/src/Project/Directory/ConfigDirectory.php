<?php

namespace Message\Mothership\Install\Project\Directory;

class ConfigDirectory implements DirectoryInterface
{
	public function getPath()
	{
		return 'config';
	}

	public function getPermission()
	{
		return 0777;
	}
}