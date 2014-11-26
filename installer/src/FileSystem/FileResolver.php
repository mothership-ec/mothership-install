<?php

namespace Message\Mothership\Install\FileSystem;

class FileResolver
{
	public function create(File $file, Directory $directory)
	{
		$path = $directory->getPath() . '/' . $file->getName();

		$handle = fopen($path, 'w');

		if (false === $handle) {
			throw new Exception\FileCreateException('Could not create file at `' . $path . '`');
		}

		$bytes = fwrite($handle, $file->getContents());

		if (false === $bytes) {
			throw new Exception\FileCreateException('Could not write contents to `' . $path . '`');
		}

		fclose($handle);
	}
}