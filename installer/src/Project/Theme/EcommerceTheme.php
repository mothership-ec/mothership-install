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
		return 'https://github.com/mothership-ec/mothership-skeleton-theme.git';
	}
}