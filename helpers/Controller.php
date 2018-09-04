<?php

abstract class Controller
{
	public function __construct()
	{
		$this->initMiddlewares();
	}
	public function initMiddlewares()
	{}
	public function validate($data = [], $rules = [])
	{
		return Validator::instance()->validate($data, $rules);
	}
}