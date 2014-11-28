<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

class CogulesGitignoreFile extends AbstractGitignoreFile
{
	public function getPath()
	{
		return 'public/cogules';
	}
}