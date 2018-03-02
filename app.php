<?php

class App extends Prefab
{
	protected $f3;
	public function __construct()
	{
		$this->f3 = Base::instance();
	}
	public function authenticated()
	{
		return $this->f3->get('SESSION.user');
	}
	public static function user($user = null)
	{
		if($user) {
			$this->f3->set('SESSION.user', $user);
		}
		return $this->authenticated();
	}
	public function set($key, $value) {
		return $this->f3->set($key, $value);
	}
	public function get($param = null) {
		return null !== $param ? $this->f3->get($param) : $this->f3;
	}
	static public function __callStatic($method,$args) {
		$f3=f3();
		if (method_exists($f3,$method)) {
			return $f3->$method($args[0],isset($args[1])?$args[1]:NULL);
		}
	}
	public function __get($property) {
		return NULL!==$this->get($property)?$this->get($property):FALSE;
	}
	public function __set($property,$value=TRUE) {
		$this->set($property,$value);
	}
	public function __call($method,$args) {
		if (method_exists($this->f3,$method)) {
			return $this->$method($args[0],isset($args[1])?$args[1]:NULL);
		}
	}
}