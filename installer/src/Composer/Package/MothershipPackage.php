<?php

namespace Message\Mothership\Install\Composer\Package;

/**
 * Class Mothership
 * @package Message\Mothership\Install\Composer\Package
 *
 * @author  Thomas Marchant <thomas@mothership.ec>
 */
class MothershipPackage implements PackageInterface
{
	public function getName()
	{
		return 'mothership-ec/mothership';
	}
}