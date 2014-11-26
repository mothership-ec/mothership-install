<?php

namespace Message\Mothership\Install\Project\Composer;

use Message\Mothership\Install\Project\Types;

class EcomComposer extends EcommerceComposer
{
	public function getName()
	{
		return Types::ECOM;
	}
}