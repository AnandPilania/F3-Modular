<?php

abstract class Controller
{
	public function validate($data = [], $rules = [])
	{
		return Validator::instance()->validate($data, $rules);
	}
}