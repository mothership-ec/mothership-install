<?php

namespace Mothership\Install\Project\Config;

/**
 * Interface AskerInterface
 * @package Mothership\Install\Project\Config
 *
 * @author  Thomas Marchant <thomas@mothership.ec>
 *
 * Interface representing a class that asks the user to input their config details
 */
interface AskerInterface
{
	/**
	 * Ask the user to input config details, and commit them to the config file
	 *
	 * @param $path
	 */
	public function askForDetails($path);
}