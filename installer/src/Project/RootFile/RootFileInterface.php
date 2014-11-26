<?php

namespace Message\Mothership\Install\Project\RootFile;

interface RootFileInterface
{
	public function getFilename();
	public function getContents();
}