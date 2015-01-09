<?php

namespace Message\Mothership\Install\Project\RootFile\Composer;

use Message\Mothership\Install\Project\Types;

/**
 * Class CmsComposer
 * @package Message\Mothership\Install\Project\RootFile\Composer
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Dependency setup for a basic CMS site
 */
class CmsComposer extends AbstractComposer
{
	/**
	 * {@inheritDoc}
	 */
	public function getName()
	{
		return Types::ECOMMERCE;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getContents()
	{
		return <<<'EOD'
{
	"repositories": [
		{
			"type": "composer",
			"url" : "http://packages.message.co.uk"
		}
	],
	"require": {
		"message/cog" : "dev-feature/umask-on-asset-tasks as 3.5.0",
		"message/cog-mothership-user": "dev-feature/create-user-task as 3.2.0",
		"message/cog-mothership-cms"      : "~3.0",
		"message/twitter"                 : "~1.0"
	},
	"suggest": {
	},
	"config": {
		"bin-dir": "bin"
	},
	"scripts": {
		"post-package-install": [
			"Message\\Cog\\Config\\FixtureManager::postInstall"
		],
		"pre-package-update": [
			"Message\\Cog\\Config\\FixtureManager::preUpdate"
		],
		"post-package-update": [
			"Message\\Cog\\Config\\FixtureManager::postUpdate"
		]
	},
	"autoload": {
		"psr-4": {
			""                   : "app/",
			"Mothership\\Site\\" : "app/site/src"
		}
	}
}
EOD;

	}
}