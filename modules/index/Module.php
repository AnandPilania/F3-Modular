<?php

namespace Index;

use DB\Jig;
use DB\SQL;
use DB\Mongo;
use Session;
use Modules;
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
		}

		$this->configureDB();
		$this->configureSession();

		$this->loadRoutesFrom(__DIR__.'/routes.php');
		$res = __DIR__.'/resources';
		$this->loadLangFrom($res.'/lang');
		$this->loadViewsFrom($res.'/views');
		$this->loadAssetsFrom($res.'/assets');
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