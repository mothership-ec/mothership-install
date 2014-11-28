<?php

namespace Message\Mothership\Install\Command;

class ShellCommand
{
	public static function run($command)
	{
		$proc = popen($command, 'r');

		while (!feof($proc)) {
			echo fread($proc, 4096);
			@flush();
		}
	}

	public static function exec($command, &$output = [])
	{
		exec($command, $output);
	}
}