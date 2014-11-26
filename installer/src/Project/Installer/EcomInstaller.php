<?php

namespace Message\Mothership\Install\Project\Installer;

use Message\Mothership\Install\Project\Types;
use Message\Mothership\Install\Project\Composer;

class EcomInstaller extends EcommerceInstaller
{
	public function getName()
	{
		return Types::ECOM;
	}
}