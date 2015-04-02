<?php

namespace Message\Mothership\Install\Project\Installer;

use Message\Mothership\Install\Project\Types;
use Message\Mothership\Install\Composer\Package\MothershipPackage;

/**
 * Class EcommerceInstaller
 * @package Message\Mothership\Install\Project\Installer
 *
 * @author  Thomas Marchant <thomas@message.co.uk>
 *
 * Installer for an Ecommerce site
 */
class EcommerceInstaller extends AbstractInstaller
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
	public function getPackage()
	{
		return new MothershipPackage;
	}
}