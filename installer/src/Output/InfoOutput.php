<?php

namespace Mothership\Install\Output;

class InfoOutput extends AbstractOutput
{
	public function info($info)
	{
		$this->_outputLine($info, 'light_green');
	}

	public function heading($heading)
	{
		$this->_outputLine($heading, 'black', 'light_green');
	}
}