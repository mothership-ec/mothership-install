<?php

namespace Message\Mothership\Install\Project\Installer;

class Collection extends \ArrayObject
{
	public function __construct()
	{
		$installers = [
			'ecom'      => new EcomInstaller,
			'ecommerce' => new EcommerceInstaller,
		];

		parent::__construct($installers);
	}

	public function get($name)
	{
		if (!array_key_exists($name, $this)) {
			throw new Exception\InstallerNotFoundException('Installer `' . $name . '` not found on collection!');
		}

		return $this[$name];
	}
}

