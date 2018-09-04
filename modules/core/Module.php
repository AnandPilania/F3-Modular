<?php

namespace Core;

use DB\Jig;
use DB\SQL;
use DB\Mongo;
use Session;
use Modules;
use Event;
use Mailer;
use Assets;
use Middleware;
use Falsum\Run as Falsum;

class Module extends Modules
{
	protected $name = 'index';

	public function init()
	{
		$this->loadConfigFrom(__DIR__.'/config.php');

		if($this->f3->env === 'dev') {
			$this->f3->set('DEBUG', 3);
			Falsum::handler(3);
			$this->loadConfigFrom(__DIR__.'/config/reloadr.php', true);
			$this->f3->route('GET @reloadr: /reloadr', 'Core\Controllers\ReloadrController->init');
		}else{
			$this->f3->set('ONERROR', 'Core\Controllers\ErrorController->init');
		}

		$this->configureDB();
		$this->configureSession();

		$this->loadRoutesFrom(__DIR__.'/routes.php');
		$res = __DIR__.'/resources';
		$this->loadLangFrom($res.'/lang');
		$this->loadViewsFrom($res.'/views');
		$this->loadAssetsFrom($res.'/assets');
		$this->configurePackages();
	}

	protected function configureDB()
	{
		if($type = $this->f3->db_type) {
			$db = $this->get_db_type($type);
			if('Jig' === $db) {
				$this->f3->set('DB', new Jig($this->f3->db_path, Jig::FORMAT_JSON));
			}else if('Mongo' === $db) {
				$this->f3->set('DB', new Mongo('mongodb://'.$this->f3->db_host.':'.$this->f3->db_port, $this->f3->db_name));
			}else if('SQL' === $db) {
				$this->f3->set('DB', new SQL('mysql:host='.$this->f3->db_host.';port='.$this->f3->db_port.';dbname='.$this->f3->db_name, $this->f3->db_user, $this->f3->db_pswd));
			}
		}
	}

	protected function configureSession()
	{
		$csrf = $this->f3->csrf;
		if($this->f3->db && $this->f3->session_db) {
			$_session = str_ireplace('/', '', 'DB\/'.$this->get_db_type($this->f3->db_type).'\Session');
			$session = $csrf ? new $_session($this->f3->db, 'sessions', null, 'CSRF') : new $_session($this->f3->db);
		}else{
			$session = $csrf ? new Session(null, 'CSRF') : new Session();
		}
	}

	protected function configurePackages()
	{
		if(isset($this->f3->packages)) {
			if($this->f3->packages['middlewares']) {
				$this->f3->set('middleware', Middleware::instance());
			}
			if($this->f3->packages['events']) {
				Event::instance();
			}
			if($this->f3->packages['mailer']) {
				$this->loadConfigFrom(__DIR__.'/config/mailer.php');
				Mailer::initTracking();
			}
			if($this->f3->packages['assets']) {
				$this->loadConfigFrom(__DIR__.'/config/assets.php');
				Assets::instance();
				$this->f3->set('ASSETS.onFileNotFound',function($file) use ($f3){
					echo 'file not found: '.$file;
				});
			}
		}
	}

	protected function get_db_type($type)
	{
		$type = strtolower($type);
		if('jig' === $type || 'mongo' === $type) {
			return ucfirst($type);
		}else if('sql' === $type) {
			return strtoupper($type);
		}
	}
}