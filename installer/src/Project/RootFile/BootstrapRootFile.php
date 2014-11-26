<?php

namespace Message\Mothership\Install\Project\RootFile;

class BootstrapRootFile implements RootFileInterface
{
	public function getFilename()
	{
		return 'bootstrap.php';
	}

	public function getContents()
	{
		return <<<'EOD'
<?php

$autoloader = require_once __DIR__ . '/autoloader.php';

return new App($autoloader, __DIR__ . '/');
EOD;
	}
}