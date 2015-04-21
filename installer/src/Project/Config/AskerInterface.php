<?php

namespace Mothership\Install\Project\Config;


interface AskerInterface
{
	/**
	 * Ask the user to input config details, and commit them to the config file
	 *
	 * @param $path
	 */
	public function askForDetails($path);
}