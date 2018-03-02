<?php

class Response extends Prefab
{
	protected $f3;
	public function __construct()
	{
		$this->f3 = Base::instance();
	}

	public function view($layout, $data = [])
	{
		$loc = null;
		if(Str::contains($layout, '::')) {
			$module = explode('::', $layout)[0];
			foreach(explode(';', $this->f3->UI) as $path) {
				if(Str::contains($path, 'modules/'.$module) || Str::contains($path, str_ireplace('/', '', 'modules\/'.$module))) {
					$loc = str_ireplace($module.'::', '', $path.$layout);
					break;
				}
			}
		}else{
			$loc = $layout;
		}

		$f3 = f3();
		$f3->mset($data);
		//$f3->set('content', hasExtension($template));
		echo Template::instance()->render($loc.'.htm');//'layouts/app.htm');
		exit();
	}

	public function json($data = [], $status = '200')
	{}
}