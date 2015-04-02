<?php

namespace Mothership\Install\Project\Installer;

/**
 * Class Collection
 * @package Mothership\Install\Project\Installer
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Collection of registered installers
 */
class Collection extends \ArrayObject
{
	public function __construct()
	{
		$installers = [
			'ecommerce' => new EcommerceInstaller,
		];

		parent::__construct($installers);
	}

	/**
	 * Get the installer by name
	 *
	 * @param $name
	 * @throws Exception\InstallerNotFoundException
	 *
	 * @return InstallerInterface
	 */
	public function get($name)
	{
		if (!array_key_exists($name, $this)) {
			throw new Exception\InstallerNotFoundException('Installer `' . $name . '` not found on collection!');
		}

		return $this[$name];
	}
}

