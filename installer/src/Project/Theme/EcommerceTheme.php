<?php

namespace Message\Mothership\Install\Project\Theme;

class EcommerceTheme implements ThemeInterface
{
	public function getBranch()
	{
		return 'nucleus-ecom';
	}

	public function getGitRepo()
	{
		return 'git@github.com:messagedigital/mothership-skeleton-theme.git';
	}
}