<?php

class Modules
{
	protected $f3;
	protected $module;
	private static $path;

	public function __construct($module = null)
	{
		$this->f3 = Base::instance();
		$this->module = $module?:$this->name;
	}

	public function loadConfigFrom($pathOrFile, $global = false)
	{
		if(is_dir($pathOrFile)) {
			foreach(glob($pathOrFile.'/*') as $file) {
				if(extension($file) === 'php') {
					$conf = include($file);
					$this->f3->mset($global?[$this->module => $conf]:$conf);
				}else if(extension($file) === 'ini') {
					$this->f3->config($file);
				}
			}
		}else if(is_file($pathOrFile)) {
			if(extension($pathOrFile) === 'php') {
				$conf = include($pathOrFile);
				$this->f3->mset($global?[$this->module => $conf]:$conf);
			}else if(extension($pathOrFile) === 'ini') {
				$this->f3->config($pathOrFile);
			}
		}
	}

	public function loadRoutesFrom($pathOrFile)
	{
		$app = $this->f3;
		if(is_dir($pathOrFile)) {
			foreach(glob($pathOrFile.'/*') as $file) {
				if(extension($file) === 'php') {
					include($file);
				}else if(extension($file) === 'ini') {
					$this->f3->config($file);
				}
			}
		}else if(is_file($pathOrFile)) {
			if(extension($pathOrFile) === 'php') {
				include($pathOrFile);
			}else if(extension($pathOrFile) === 'ini') {
				$this->f3->config($pathOrFile);
			}
		}
	}

	public function loadResources($path)
	{
		if(is_dir($path.'/lang')){
			$this->loadLangFrom($path.'/lang');
		}

		if(is_dir($path.'/views')){
			$this->loadViewsFrom($path.'/views');
		}

		if(is_dir($path.'/assets')){
			$this->loadAssetsFrom($path.'/assets');
		}
	}

	public function loadViewsFrom($path)
	{
		$this->f3->set('UI', $this->f3->get('UI').';'.$path.'/');
	}

	public function loadAssetsFrom($path)
	{}

	public function loadLangFrom($path)
	{
		$this->f3->set('LOCALES', $this->f3->get('LOCALES').';'.$path.'/');
	}

	public function middlewares($class)
	{
		if(is_array($class)) {

		}else{

		}
	}

	//abstract public function init();

	static public function run()
	{
		self::$path = $path = root_path('modules').'/';

		spl_autoload_register(array(
			__CLASS__,
			'autoload',
		));

		foreach(glob($path.'*') as $module) {
			$file = $module.'/Module.php';
			if(file_exists($file)) {
				require $file;
				$class = ucfirst(str_ireplace($path, '', $module)).'\Module';
				if(class_exists($class)) {
					(new $class())->init();
				}
			}
		}
	}

	static public function autoload($class)
	{
		$file = self::$path . str_replace('\\', '/', $class) . '.php';
		if(file_exists($file)) { require $file; }
	}
}