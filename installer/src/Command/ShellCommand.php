<?php

namespace Message\Mothership\Install\Command;

/**
 * Class ShellCommand
 * @package Message\Mothership\Install\Command
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for running commands in the shell
 */
class ShellCommand
{
	/**
	 * Run command and display output in the terminal
	 *
	 * @param $command
	 */
	public static function run($command)
	{
		$proc = popen($command, 'r');

		while (!feof($proc)) {
			echo fread($proc, 4096);
			@flush();
		}
	}

	/**
	 * Run command and store output in memory
	 *
	 * @param $command
	 * @param array $output
	 */
	public static function exec($command, &$output = [])
	{
		exec($command, $output);
	}
}