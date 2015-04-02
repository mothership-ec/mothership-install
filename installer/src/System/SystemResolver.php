<?php

namespace Mothership\Install\System;

/**
 * Class SystemResolver
 * @package Mothership\Install\System
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for checking the system of the server in which the Mothership project is being installed
 *
 * @todo allow compatibility with Windows
 */
class SystemResolver
{
	const WIN_PREFIX = 'WIN';

	/**
	 * Check if a system of the installation is Windows
	 *
	 * @return bool
	 */
	public function isWindows()
	{
		return (strtoupper(substr(PHP_OS, 0, 3)) === self::WIN_PREFIX);
	}

	/**
	 * Validate that the system supports both Mothership and the Mothership installer
	 *
	 * @throws Exception\CompatibilityException
	 */
	public function validateCompatibility()
	{
		if ($this->isWindows()) {
			throw new Exception\CompatibilityException('Mothership installer currently only supports Unix-like systems, Windows detected');
		}
	}
}