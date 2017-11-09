<?php
	$routeList = array();
	$routesFile = fopen("app/routes.php", "r");

	while ( ($line = fgets($routesFile)) !== false ) {
		$line = preg_replace('/\s+/', '', $line);
		if( stristr($line, "Route::get") ){
			$route = str_replace("Route::get(\"", "", $line);
			$route = str_replace("\",function(){", "", $route);
			array_push($routeList, $route);
		}
	}

	fclose ($routesFile);

	foreach ( $_SERVER['argv'] as $key => $value) {
		if( $key !== 0 ){
			$separete = explode("=", $value);
			$action = $separete[0];
			$val = $separete[1];
			switch ($action) {
				case '--create_new_route':
					createRoute($val, $routeList);
					break;

				case '-create_new_route':
					createRoute($val, $routeList);
					break;

				case 'create_new_route':
					createRoute($val, $routeList);
					break;

				case '--remove_route':
					removeRoute($val);
					break;

				case '-remove_route':
					removeRoute($val);
					break;

				case 'remove_route':
					removeRoute($val);
					break;
			}
		}
	}

	function createRoute($val, $routeList){
		if( !in_array($val, $routeList) ){
			$route = "\n\nRoute::get( \"$val\" ,function(){\n	load_controller(\"".str_replace("/", '', substr($val, 1))."\"); \n});";
			$routes = file_get_contents("app/routes.php");
			$controller = '<?php $data[\'message\'] = translate_message("newroutesuccess"); $data[\'error\'] = \''.$val.'\'; $data[\'class\'] = \'success\'; message_page(\'error\', $data); ?>';

			$createRoute = fopen("app/routes.php", "w");
			fwrite($createRoute, $routes.$route);
			fclose($createRoute);

			$createController = fopen("app/controller/".str_replace("/", '', substr($val, 1)).".php", "w");
			fwrite($createController, $controller);
			fclose($createController);
		}
	}

	function removeRoute($val){
		$routesFile = fopen("app/routes.php", "r");
		$file = fread($routesFile, filesize("app/routes.php"));
		$lines = str_replace("\n", "\n<QUEBRALINHA>", $file);
		$lines = str_replace("\t", "\t<TAB>", $lines);
		$lines = preg_replace('/\s+/', '<ESPACE>', $lines);
		//$lines = preg_replace('/\s+/', '<ESPACE>', $lines);
		$lines = str_replace('});', "});\n", $lines);
		$lines = str_replace('<?php', "", $lines);
		$lines = explode("\n", $lines);

		foreach ($lines as $key => $value) {
			$unsets = array();
			if( $value == "" ): 
				unset($lines[$key]); 
			endif;

			if( stristr($value, "\"".$val."\"") ):
				$functions = str_replace("<ESPACE>", "", $value);
				$functions = str_replace("<QUEBRALINHA>", "", $functions);
				$functions = str_replace("<TAB>", "", $functions);
				$functions = str_replace("Route::get(\"".$val."\",function(){", "", $functions);
				$functions = str_replace("Route::get('".$val."',function(){", "", $functions);
				$functions = substr($functions, 0, -3);
				$functions = str_replace(";\"", "\"", $functions);
				$functions = str_replace(";", ";\n", $functions);
				$functionLines = explode("\n", $functions);
				foreach ($functionLines as $key2 => $value2):
					recursiveDelete($value2);
				endforeach;
				array_push($unsets, $key);
			endif;

			$edit = $value;
			$edit = str_replace("<ESPACE>", " ", $edit);
			$edit = str_replace("<TAB>", "\t", $edit);
			$edit = str_replace("<QUEBRALINHA>", "\n", $edit);
			$edit = str_replace("\n \n", "\n", $edit);
			$lines[$key] = $edit;

			foreach ($unsets as $key => $value):
				unset($lines[$value]);
			endforeach;
		}


		fclose ($routesFile);

		file_put_contents("app/routes.php", "<?php".implode("\n", $lines));
	}

	function recursiveDelete($val){
		if( stristr($val, "load_controller") ):
			$line = substr($val, 0, -3);
			$line = str_replace("load_controller(\"", "", $line);
			
			$controllerFile = fopen("app/controller/".$line.".php", "r");
			$controller = fread($controllerFile, filesize("app/controller/".$line.".php"));
			$controllerLinesC = preg_replace('/\s+/', '', $controller);
			$controllerLinesC = str_replace('<?php', '', $controllerLinesC);
			$controllerLinesC = str_replace('?>', '', $controllerLinesC);
			$controllerLinesC = str_replace(";", ";\n", $controllerLinesC);
			$controllerLines = explode("\n", $controllerLinesC);

			foreach ($controllerLines as $key => $value):
				recursiveDelete($value);
			endforeach;

			fclose($controllerFile);

			if( file_exists("app/controller/".$line.".php") ):
				unlink("app/controller/".$line.".php");
			endif;
		endif;
		if( stristr($val, "load_view") ):
			$line = substr($val, 0, -3);
			$line = str_replace("load_view(\"", "", $line);
			
			if( file_exists("app/views/".$line.".php") ):
				unlink("app/views/".$line.".php");
			endif;
		endif;
	}
?>