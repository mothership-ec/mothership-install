<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

/**
 * Class IndexFile
 * @package Message\Mothership\Install\Project\PostInstall\File
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for the index.php file
 */
class IndexFile implements FileInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getFilename()
	{
		return 'index.php';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'public';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getContents()
	{
		return <<<'EOD'
<?php

$app = require_once '../bootstrap.php';

$app->run();
EOD;

	}
}