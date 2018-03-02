<?php

namespace Installer;

use Response;
use WebController;

class Controller extends WebController
{
	public function init($f3, $params)
	{
		if(file_exists(root_path('storage/app/installed'))) {
			$f3->reroute('@getIndex');
		}

		$func = strtolower($f3->VERB);
		if(method_exists($this, $func)) {
			$this->$func($f3, $params);
		}
	}

	public function get($f3, $params)
	{
		switch($params['step']) {
			case 'config':
				view('installer::config');
				break;
			case 'db':
				view('installer::db');
				break;
			case 'finish':
				view('installer::end');
				break;
			default:
				view('installer::start');
				break;
		}
	}

	public function post($f3, $params)
	{
		switch($params['step']) {
			case 'config':
				view('installer\config');
				break;
			case 'db':
				view('installer\db');
				break;
			case 'finish':
				view('installer\end');
				break;
			default:
				view('installer\start');
				break;
		}
	}
}