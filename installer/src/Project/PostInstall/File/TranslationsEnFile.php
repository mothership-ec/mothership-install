<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

/**
 * Class TranslationsEnFile
 * @package Message\Mothership\Install\Project\PostInstall\File
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for the English translation file
 */
class TranslationsEnFile implements FileInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'translations';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFilename()
	{
		return 'en.yml';
	}

	/**
	 * {@inheritDoc}
	 */
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