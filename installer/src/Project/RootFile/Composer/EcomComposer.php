<?php

namespace Message\Mothership\Install\Project\RootFile\Composer;

use Message\Mothership\Install\Project\Types;

class EcomComposer extends EcommerceComposer
{
	public function getName()
	{
		return Types::ECOM;
	}
}