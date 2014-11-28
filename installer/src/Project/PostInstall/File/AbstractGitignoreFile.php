<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

abstract class AbstractGitignoreFile implements FileInterface
{
	public function getFilename()
	{
		return '.gitignore';
	}

	public function getContents()
	{
		return <<<'EOD'
!.gitignore
EOD;

	}
}