<?php

namespace Message\Mothership\Install\Project\PostInstall\File;

interface FileInterface
{
	public function getPath();
	public function getFilename();
	public function getContents();
}