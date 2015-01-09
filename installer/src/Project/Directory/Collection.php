<?php

namespace Message\Mothership\Install\Project\Directory;

/**
 * Class Collection
 * @package Message\Mothership\Install\Project\Directory
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * A collection of all the necessary directories for an installation
 */
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
		];

		parent::__construct($dirs);
	}
}