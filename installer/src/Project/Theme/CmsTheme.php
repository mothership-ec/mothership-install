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
		return 'https://github.com/mothership-ec/mothership-skeleton-theme.git';
	}
}