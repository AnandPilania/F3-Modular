<?php

namespace Installer;

class IsInstalled extends Middleware
{
	public function beforeroute()
	{
		if(!file_exists(root_path('storage/app/installed'))) {
			$this->f3->reroute('@installer');
		}
	}
}