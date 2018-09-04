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
		$f3 = f3();
		$f3->mset($data);
		$loc = template($layout, $f3);
		//$f3->set('content', hasExtension($template));
		echo Template::instance()->render($loc.'.htm');//'layouts/app.htm');
		exit();
	}

	public function json($data = [], $status = '200')
	{
		if(!is_array($key)) {
			$key = [$key => $val];
		}
		header('Content-Type: application/json; charset='.f3()->CHARSET);
		echo json_encode($key);
		exit();
	}
}