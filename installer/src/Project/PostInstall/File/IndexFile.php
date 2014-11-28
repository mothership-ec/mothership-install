<?php

namespace Message\Mothership\Install\Project\PostInstall\File;


class IndexFile implements FileInterface
{
	public function getFilename()
	{
		return 'index.php';
	}

	public function getPath()
	{
		return 'public';
	}

	public function getContents()
	{
		return <<<'EOD'
<?php

$app = require_once '../bootstrap.php';

$app->run();
EOD;

	}
}