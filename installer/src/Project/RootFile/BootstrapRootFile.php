<?php

namespace Message\Mothership\Install\Project\RootFile;

/**
 * Class BootstrapRootFile
 * @package Message\Mothership\Install\Project\RootFile
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * The bootstrap file which gets called by the index.php file
 */
class BootstrapRootFile implements RootFileInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getFilename()
	{
		return 'bootstrap.php';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getContents()
	{
		return <<<'EOD'
<?php

$autoloader = require_once __DIR__ . '/autoloader.php';

return new App($autoloader, __DIR__ . '/');
EOD;
	}
}