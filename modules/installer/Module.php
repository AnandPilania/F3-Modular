<?php

namespace Installer;

use Str;
use Route;
use Modules;

class Module extends Modules
{
	protected $name = 'installer';

	public function init()
	{
		$this->loadConfigFrom(__DIR__.'/config.php', true);
		if($this->f3->get('installer.enabled')) {
			$this->f3->route('GET|POST @installer: /install/@step', 'Installer\Controller->init');
			if(!file_exists(root_path('storage/app/installed'))) {
				$res = __DIR__.'/resources';
				$this->loadLangFrom($res.'/lang');
				$this->loadViewsFrom($res.'/views');
				$this->loadAssetsFrom($res.'/assets');
				if(!Route::instance()->is('/install')) {
					$this->f3->reroute('/install/start');
					die();
				}
			}
		}
	}
}