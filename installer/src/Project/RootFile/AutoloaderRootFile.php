<?php

namespace Message\Mothership\Install\Project\RootFile;

/**
 * Class AutoloaderRootFile
 * @package Message\Mothership\Install\Project\RootFile
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * The autoloader, which loads Composer's autoloader as well as the namespace overrides
 */
class AutoloaderRootFile implements RootFileInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getFilename()
	{
		return 'autoloader.php';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getContents()
	{
		return <<<'EOD'
<?php

$namespaceOverrides = __DIR__ . '/namespaces.php';
$autoloader         = require_once (file_exists($namespaceOverrides))
	? $namespaceOverrides
	: __DIR__ . '/vendor/autoload.php';

return $autoloader;
EOD;

	}
}