<?php

namespace Message\Mothership\Install\Project\Directory;

class Collection extends \ArrayObject
{
	public function __construct()
	{
		$dirs = [
			new ConfigDirectory,
			new DataDirectory,
			new HoldingDirectory,
			new LogsDirectory,
			new PublicDirectory,
			new PublicAssetsDirectory,
			new PublicBarcodesDirectory,
			new PublicCogulesDirectory,
			new PublicFilesDirectory,
			new PublicResizeDirectory,
			new TmpDirectory,
			new TranslationsDirectory,
		];

		parent::__construct($dirs);
	}
}