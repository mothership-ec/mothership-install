<?php

namespace Message\Mothership\Install\Project\Theme;

/**
 * Interface ThemeInterface
 * @package Message\Mothership\Install\Project\Theme
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class representing a Mothership theme in Git
 */
interface ThemeInterface
{
	/**
	 * @return string
	 */
	public function getGitRepo();

	/**
	 * @return string
	 */
	public function getBranch();
}