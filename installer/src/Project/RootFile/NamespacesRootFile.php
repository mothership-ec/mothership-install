<?php

namespace Message\Mothership\Install\Project\RootFile;

/**
 * Class NamespacesRootFile
 * @package Message\Mothership\Install\Project\RootFile
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * The namespace override file, for overriding namespaces that are in the vendor folder.
 */
class NamespacesRootFile implements RootFileInterface
{
	public function getFilename()
	{
		return 'namespaces.php';
	}

	public function getContents()
	{
		return <<<'EOD'
<?php

$autoloader = require_once __DIR__ . '/vendor/autoload.php';

return $autoloader;
EOD;

	}
}