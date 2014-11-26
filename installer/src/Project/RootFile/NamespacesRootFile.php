<?php

namespace Message\Mothership\Install\Project\RootFile;

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