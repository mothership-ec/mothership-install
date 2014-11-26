<?php

namespace Message\Mothership\Install\Project\RootFile;

class AutoloaderRootFile implements RootFileInterface
{
	public function getFilename()
	{
		return 'autoloader.php';
	}

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