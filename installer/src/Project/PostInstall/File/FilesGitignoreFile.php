<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

class FilesGitignoreFile extends AbstractGitignoreFile
{
	public function getPath()
	{
		return 'public/files';
	}
}