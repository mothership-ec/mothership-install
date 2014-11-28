<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

class DataGitignoreFile extends AbstractGitignoreFile
{
	public function getPath()
	{
		return 'data';
	}
}