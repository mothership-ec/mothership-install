<?php

namespace Message\Mothership\Install\Project\Directory;

class LogsDirectory implements DirectoryInterface
{
	public function getPath()
	{
		return 'logs';
	}

	public function getPermission()
	{
		return 0777;
	}
}