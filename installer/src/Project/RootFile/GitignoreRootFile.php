<?php

namespace Message\Mothership\Install\Project\RootFile;

/**
 * Class GitignoreRootFile
 * @package Message\Mothership\Install\Project\RootFile
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * The base level .gitignore file
 */
class GitignoreRootFile implements RootFileInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getFilename()
	{
		return '.gitignore';
	}

	/**
	 * {@inheritDoc}
	 */
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