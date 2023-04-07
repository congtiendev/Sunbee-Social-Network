<?php
	
	namespace App\Controllers;
	
	use Exception;
	
	class ErrorController extends BaseController
	{
		/**
		 * @throws Exception
		 */
		public function render404()
		{
			$this->render('pages.404');
		}
	}
	
	
