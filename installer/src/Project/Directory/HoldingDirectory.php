<?php

namespace Message\Mothership\Install\Project\Directory;

class HoldingDirectory implements DirectoryInterface
{
	public function getPath()
	{
		return 'holding';
	}

	public function getPermission()
	{
		return 0755;
	}
}