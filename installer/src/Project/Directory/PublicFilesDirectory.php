<?php

namespace Message\Mothership\Install\Project\Directory;

class PublicFilesDirectory implements DirectoryInterface
{
	public function getPath()
	{
		return 'public/files';
	}

	public function getPermission()
	{
		return 0777;
	}
}