<?php

namespace Message\Mothership\Install\Project\Directory;

class PublicBarcodesDirectory implements DirectoryInterface
{
	public function getPath()
	{
		return 'public/barcodes';
	}

	public function getPermission()
	{
		return 0777;
	}
}