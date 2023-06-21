<?php

namespace App\Controllers;

use Exception;

class ErrorController extends BaseController
{
	/**
	 * @throws Exception
	 */

	public function error401()
	{
		$title = '401 - Unauthorized';
		$this->render('errors.401', compact('title'));
	}
	public function error404()
	{
		$title = '404 - Not Found';
		$this->render('errors.404', compact('title'));
	}
	public function error405()
	{
		$title = '405 - Method Not Allowed';
		$this->render('errors.405', compact('title'));
	}
}
