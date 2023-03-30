<?php
	namespace App\Controllers;
	use eftec\bladeone\BladeOne;
	use Exception;
	
	class BaseController{
		/**
		 * @throws Exception
		 */
		protected function render($viewFile, $data = []){
			$viewDir = "./app/views";
			$storageDir = "./storage";
			$blade = new BladeOne($viewDir,$storageDir, BladeOne::MODE_DEBUG);
			echo $blade->run($viewFile, $data);
		}
	}
	
	?>