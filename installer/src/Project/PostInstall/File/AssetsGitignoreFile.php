<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

class AssetsGitignoreFile extends AbstractGitignoreFile
{
	public function getPath()
	{
		return 'public/assets';
	}
}