<?php

namespace Message\Mothership\Install\Project\RootFile\Composer;

use Message\Mothership\Install\Project\RootFile\RootFileInterface;

/**
 * Interface ComposerInterface
 * @package Message\Mothership\Install\Project\RootFile\Composer
 *
 * Interface representing a composer.json file to be installed in the root directory
 */
interface ComposerInterface extends RootFileInterface
{
	/**
	 * Get the name of the installation type that requires this composer.json file
	 *
	 * @return string
	 */
	public function getName();
}