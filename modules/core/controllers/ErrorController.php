<?php

namespace Core\Controllers;

use WebController;

class ErrorController extends WebController
{
	public function init()
	{
		view('core::error');
	}
}