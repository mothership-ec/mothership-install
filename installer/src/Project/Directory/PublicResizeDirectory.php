<?php

namespace Message\Mothership\Install\Project\Directory;

class PublicResizeDirectory implements DirectoryInterface
{
	public function getPath()
	{
		return 'public/resize';
	}

	public function getPermission()
	{
		return 0777;
	}
}