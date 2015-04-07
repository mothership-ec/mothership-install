<?php

namespace Mothership\Install\FileSystem;

/**
 * Class FileResolver
 * @package Mothership\Install\FileSystem
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for handling files in the file system
 */
class FileResolver
{
	/**
	 * Create a file
	 *
	 * @param File $file              The file model to create
	 * @param Directory $directory    The directory model representing where to save it
	 *
	 * @throws Exception\FileCreateException
	 */
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

	/**
	 * Check to see if a file exists
	 *
	 * @param string $filePath    Path of the file
	 *
	 * @return bool
	 */
	public function exists($filePath)
	{
		$dirResolver = new DirectoryResolver;
		$filePath = $dirResolver->getAbsolute($filePath);

		return file_exists($filePath);
	}
}