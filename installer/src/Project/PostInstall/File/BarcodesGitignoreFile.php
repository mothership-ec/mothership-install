<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

class BarcodesGitignoreFile extends AbstractGitignoreFile
{
	public function getPath()
	{
		return 'public/barcodes';
	}
}