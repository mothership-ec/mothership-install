<?php

namespace Message\Mothership\Install\Project\Installer;

use Message\Mothership\Install\Project\Types;
use Message\Mothership\Install\Project\RootFile\Composer\EcommerceComposer;

class EcommerceInstaller extends AbstractInstaller
{
	public function getName()
	{
		return Types::ECOMMERCE;
	}

	public function getTheme()
	{
		return 'git@github.com:messagedigital/mothership-skeleton-theme.git';
	}

	public function getComposerTemplate()
	{
		return new \Message\Mothership\Install\Project\RootFile\Composer\EcomComposer;
	}
}