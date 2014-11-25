<?php

namespace Message\Mothership\Install\Output;

/**
 * Class Colour
 * @package Message\Mothership\Install\Output
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for getting colour codes for terminal output. The codes were taken from
 * http://www.if-not-true-then-false.com/2010/php-class-for-coloring-php-command-line-cli-scripts-output-php-output-colorizing-using-bash-shell-colors/
 */
class Colour
{
	const START = '\\033[';
	const ZERO  = '0';
	const END   = 'm';

	/**
	 * Get array of foreground colour codes.
	 *
	 * @return array
	 */
	static function getForegroundColours()
	{
		return [
			'black'        => '0;30',
			'dark_gray'    => '1;30',
			'blue'         => '0;34',
			'green'        => '0;32',
			'cyan'         => '0;36',
			'red'          => '0;31',
			'purple'       => '0;35',
			'brown'        => '0;33',
			'yellow'       => '1;33',
			'white'        => '1;37',
			'light_blue'   => '1;34',
			'light_green'  => '1;32',
			'light_cyan'   => '1;36',
			'light_red'    => '1;31',
			'light_purple' => '1;35',
			'light_gray'   => '0;37',
		];
	}

	/**
	 * Get array of background colour codes
	 *
	 * @return array
	 */
	static function getBackgroundColours()
	{
		return [
			'black'      => '40',
			'red'        => '41',
			'green'      => '42',
			'yellow'     => '43',
			'blue'       => '44',
			'magenta'    => '45',
			'cyan'       => '46',
			'light_gray' => '47',
		];
	}
}