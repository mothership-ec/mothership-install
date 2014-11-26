<?php

namespace Message\Mothership\Install\Project\Installer;

interface InstallerInterface
{
	public function getName();
	public function getTheme();
	public function getComposerTemplate();
	public function install(array $options);
}