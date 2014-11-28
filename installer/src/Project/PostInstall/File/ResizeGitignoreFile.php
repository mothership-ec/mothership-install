<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

class ResizeGitignoreFile extends AbstractGitignoreFile
{
	public function getPath()
	{
		return 'public/resize';
	}
}