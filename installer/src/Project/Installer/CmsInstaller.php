<?php

namespace Message\Mothership\Install\Project\Installer;

use Message\Mothership\Install\Project\Types;
use Message\Mothership\Install\Project\RootFile\Composer\CmsComposer;
use Message\Mothership\Install\Project\Theme\CmsTheme;

/**
 * Class CmsInstaller
 * @package Message\Mothership\Install\Project\Installer
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Installer for an CMS site
 */
class CmsInstaller extends AbstractInstaller
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
	public function getTheme()
	{
		return new CmsTheme;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getComposerTemplate()
	{
		return new CmsComposer;
	}
}