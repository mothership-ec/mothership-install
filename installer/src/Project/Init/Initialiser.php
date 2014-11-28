<?php

namespace Message\Mothership\Install\Project\Init;

use Composer\Script\PackageEvent;


class Initialiser
{
	public function test(PackageEvent $event)
	{
		echo 'hello';
		die();
	}

	public function bootstrap($path)
	{

	}
}