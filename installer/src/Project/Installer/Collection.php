<?php

namespace Message\Mothership\Install\Project\Installer;

use Message\Mothership\Install\Project\Exception;

class Collection extends \ArrayObject
{
	public function __construct()
	{
		$installers = [
			'ecom'      => new EcomInstaller,
			'ecommerce' => new EcommerceInstaller,
		];
	}

	public function get($name)
	{
		if (!array_key_exists($name, $this)) {
			throw new Exception\InstallerNotFoundException('Installer `' . $name . '` not found on collection!');
		}

		return $this[$name];
	}
}

