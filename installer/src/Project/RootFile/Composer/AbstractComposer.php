<?php

namespace Message\Mothership\Install\Project\RootFile\Composer;

/**
 * Class AbstractComposer
 * @package Message\Mothership\Install\Project\RootFile\Composer
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Abstract class for composer.json files, as all these files will have the same filename.
 */
abstract class AbstractComposer implements ComposerInterface
{
	public function getFilename()
	{
		return 'composer.json';
	}
}