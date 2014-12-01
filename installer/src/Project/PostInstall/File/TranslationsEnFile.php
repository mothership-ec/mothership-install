<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

class TranslationsEnFile implements FileInterface
{
	public function getPath()
	{
		return 'translations';
	}

	public function getFilename()
	{
		return 'en.yml';
	}

	public function getContents()
	{
		return <<<'EOD'
ms:
  cms:
    content:
page:
EOD;

	}
}