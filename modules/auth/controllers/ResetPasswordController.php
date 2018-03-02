<?php

namespace Auth\Controllers;

use WebController;

class ResetPasswordController extends WebController
{
	public function get($f3, $params)
	{
		view('auth::reset');
	}

	public function post($f3)
	{}
}