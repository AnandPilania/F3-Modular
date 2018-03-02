<?php

namespace Auth\Controllers;

use WebController;

class SigninController extends WebController
{
	public function get()
	{
		view('auth::signin');
	}

	public function post($f3)
	{}
}