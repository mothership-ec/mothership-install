<?php

namespace Message\Mothership\Install\Project\RootFile\Composer;

use Message\Mothership\Install\Project\RootFile\RootFileInterface;

abstract class AbstractComposer implements ComposerInterface, RootFileInterface
{
	public function getFilename()
	{
		return 'composer.json';
	}
}