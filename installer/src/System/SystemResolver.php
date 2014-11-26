<?php

namespace Message\Mothership\Install\System;

class SystemResolver
{
	const WIN_PREFIX = 'WIN';

	public function isWindows()
	{
		return (strtoupper(substr(PHP_OS, 0, 3)) === self::WIN_PREFIX);
	}

	public function validateCompatability()
	{
		if ($this->isWindows()) {
			throw new Exception\CompatabilityException('Mothership installer currently only supports Unix-like systems, Windows detected');
		}
	}
}