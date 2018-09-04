<?php

namespace OAuth;

use Modules;

class Module extends Modules
{
	protected $name = 'oauth';

	public function init()
	{
		//$this->exclude(__DIR__.'/src/*');
		$this->loadConfigFrom(__DIR__.'/config.php', true);
		$this->loadRoutesFrom(__DIR__.'/routes.php');

		$res = __DIR__.'/resources';
		$this->loadLangFrom($res.'/lang');
		$this->loadViewsFrom($res.'/views');
		$this->loadAssetsFrom($res.'/assets');
	}
}