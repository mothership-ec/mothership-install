<?php

namespace Message\Mothership\Install\Project\Theme;

class CmsTheme implements ThemeInterface
{
	public function getBranch()
	{
		return 'nucleus-cms';
	}

	public function getGitRepo()
	{
		return 'git@github.com:messagedigital/mothership-skeleton-theme.git';
	}
}