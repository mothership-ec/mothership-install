<?php

namespace Message\Mothership\Install\Project\Directory;

class TmpDirectory implements DirectoryInterface
{
	public function getPath()
	{
		return 'tmp';
	}

	public function getPermission()
	{
		return 0777;
	}
}