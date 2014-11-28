<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

class HtaccessFile implements FileInterface
{
	public function getFilename()
	{
		return '.htaccess';
	}

	public function getPath()
	{
		return 'public';
	}

	public function getContents()
	{
		return <<<'EOD'
Options -Indexes

RewriteEngine on
RewriteBase /

# Direct all requests to Mothership system
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [L,QSA]
EOD;

	}
}