<?php

namespace Message\Mothership\Install\Composer;

class Runner
{
	public function __call($command, $args)
	{
		$composer = 'composer';
		$path = rtrim(array_shift($args), '/');

		if (!is_dir($path)) {
			throw new Exception\InvalidComposerException('Could not change directory to `' . $path . '` as it does not exist!');
		}
		if (!file_exists($path . '/composer.json')) {
			throw new Exception\InvalidComposerException('composer.json file missing in `' . $path . '`');
		}

		if ($composerPath = array_shift($args)) {
			if (!preg_match('/.+\/composer\.phar$/', $composerPath)) {
				throw new \LogicException('`' . $composerPath . '` is not a valid Composer installation');
			} elseif (!file_exists($composerPath)) {
				throw new \LogicException('`' . $composerPath . '` does not exist!');
			}

			$composer = 'php ' . $composerPath;
		}

		exec('cd ' . $path . '; ' . $composer . ' ' . $command, $output);

		if (!is_dir($path . '/vendor')) {
			throw new Exception\ComposerException('Composer could not create vendor directory', $output);
		}
	}
}