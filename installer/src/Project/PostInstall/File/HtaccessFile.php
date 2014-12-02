<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

/**
 * Class HtaccessFile
 * @package Message\Mothership\Install\Project\PostInstall\File
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for basic .htaccess file
 */
class HtaccessFile implements FileInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getFilename()
	{
		return '.htaccess';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPath()
	{
		return 'public';
	}

	/**
	 * {@inheritDoc}
	 */
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