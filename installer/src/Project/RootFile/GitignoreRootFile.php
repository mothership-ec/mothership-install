<?php

namespace Message\Mothership\Install\Project\RootFile;

class GitignoreRootFile implements RootFileInterface
{
	public function getFilename()
	{
		return '.gitignore';
	}

	public function getContents()
	{
		return <<<'EOD'
.DS_Store
/namespaces.php
/vendor
/config/local/*/
.idea
/data/*
/bin/*
/public/assets/*
/public/files/*
/public/resize/*
/public/cogules/*
/public/barcodes/*
/logs/*
/tmp/*
EOD;

	}
}