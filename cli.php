#!/usr/bin/php
<?php
	$routeList  = array();
	$routesFile = fopen("app/routes.php", "r");

	while ( ($line = fgets($routesFile)) !== false ):
		$line = preg_replace('/\s+/', '', $line);
		if( stristr($line, "Route::get") ):
			$route = str_replace("Route::get(\"", "", $line);
			$route = str_replace("\",function(){", "", $route);
			array_push($routeList, $route);
		endif;
	endwhile;

	fclose ($routesFile);

	$arrayCreateNewRoute = array('--create_new_route', '-create_new_route', 'create_new_route', '--cnr', '-cnr', 'cnr');
	$arrayRemoveRoute    = array('--remove_route', '-remove_route', 'remove_route', '--rr', '-rr', 'rr');
	$arrayCreateModel    = array('--create_new_model', '-create_new_model', 'create_new_model', '--cnm', '-cnm', 'cnm');
	$arrayRemoveModel    = array('--remove_model', '-remove_model', 'remove_model', '--rm', '-rm', 'rm');

	if( isset($_GET) && !is_null(@$_GET) ):
		foreach ($_GET as $key => $value) {
			if( in_array($key, $arrayCreateNewRoute) ):
				createRoute($value, $routeList);
			endif;
			if( in_array($key, $arrayRemoveRoute) ):
				removeRoute($value, $routeList);
			endif;
			if( in_array($key, $arrayCreateModel) ):
				createModel($value);
			endif;
			if( in_array($key, $arrayRemoveModel) ):
				removeModel($value);
			endif;
		}
	endif;

	if( isset($_SERVER['argv']) && !is_null(@$_SERVER['argv']) ):
		foreach ( $_SERVER['argv'] as $key => $value):
			if( $key !== 0 ):
				$separete = explode("=", $value);
				$action   = $separete[0];
				$val      = @$separete[1];
				if( $val == null ){
					$val = @$_SERVER['argv'][($key+1)];
				}
				if( in_array($action, $arrayCreateNewRoute) ):
					createRoute($val, $routeList);
				endif;
				if( in_array($action, $arrayRemoveRoute) ):
					removeRoute($val, $routeList);
				endif;
				if( in_array($action, $arrayCreateModel) ):
					createModel($val);
				endif;
				if( in_array($action, $arrayRemoveModel) ):
					removeModel($val);
				endif;
			endif;
		endforeach;
	endif;

	function createRoute($val, $routeList){
		if( $val == "" ):
			exit();
		endif;
		if( substr($val, 0, 1) !== "/" ):
			$val = "/".$val;
		endif;
		if( !in_array($val, $routeList) ):
			$route  = "\nRoute::get( \"$val\" ,function(){\n	load_controller(\"".str_replace("/", '', substr($val, 1))."\"); \n});";
			$routes = file_get_contents("app/routes.php");

			$createRoute = fopen("app/routes.php", "w");
			fwrite($createRoute, $routes.$route);
			fclose($createRoute);

			$createController = fopen("app/controller/".str_replace("/", '', substr($val, 1)).".php", "w");
			fwrite($createController, "<?php\n\t\$data[\"message\"] = translate_message(\"newroutesuccess\", array(\"{routeName}\" => \"".$val."\"));\n\t\$data[\"title\"] = \"".$val."\";\n\t\$data[\"class\"] = \"success\";\n\tmessage_page(\"message\", \$data);\n?>");
			fclose($createController);

			print_r("Route ".$val." successfully created! \n");
		else:
			print_r("Existing route! \n");
		endif;
	}

	function removeRoute($val, $routeList){
		if( $val == "" ):
			exit();
		endif;
		if( substr($val, 0, 1) !== "/" ):
			$val = "/".$val;
		endif;
		if( in_array($val, $routeList) ):
			$routesFile = fopen("app/routes.php", "r");
			$file       = fread($routesFile, filesize("app/routes.php"));
			$lines      = $file;
			$lines      = str_replace('<?php', "", $lines);
			$lines      = str_replace("\n", "\n<BREAKLINE>", $lines);
			$lines      = str_replace("\t", "\t<TAB>", $lines);
			$lines      = str_replace(' ', ' <ESPACE>', $lines);
			$lines      = preg_replace('/\s+/', '', $lines);
			$lines      = str_replace('});', "});\n", $lines);
			$lines      = explode("\n", $lines);

			foreach ($lines as $key => $value):
				$unsets = array();
				if( $value == "" ): 
					unset($lines[$key]); 
				endif;

				if( stristr($value, "\"".$val."\"") ):
					$functions     = $value;
					$functions     = str_replace("<BREAKLINE>", "", $functions);
					$functions     = str_replace("<TAB>", "", $functions);
					$functions     = str_replace("<ESPACE>", "", $functions);
					$functions     = str_replace("Route::get(\"".$val."\",function(){", "", $functions);
					$functions     = str_replace("Route::get('".$val."',function(){", "", $functions);
					$functions     = substr($functions, 0, -3);
					$functions     = str_replace(";\"", "\"", $functions);
					$functions     = str_replace(";", ";\n", $functions);
					$functionLines = explode("\n", $functions);
					foreach ($functionLines as $key2 => $value2):
						recursiveDelete($value2);
					endforeach;
					array_push($unsets, $key);
				endif;

				$edit = $value;
				do{
					$edit = str_replace("<BREAKLINE><BREAKLINE>", "<BREAKLINE>", $edit);
				}while ( stristr($edit, "<BREAKLINE><BREAKLINE>") );

				$edit        = str_replace("<BREAKLINE>", "\n", $edit);
				$edit        = str_replace("<TAB>", "\t", $edit);
				$edit        = str_replace("<ESPACE>", " ", $edit);
				$lines[$key] = $edit;

				foreach ($unsets as $key => $value):
					unset($lines[$value]);
				endforeach;
			endforeach;


			fclose ($routesFile);

			file_put_contents("app/routes.php", "<?php".implode("\n", $lines));
			
			print_r("Route ".$val." successfully removed! \n");
		else:
			print_r("Route not defined! \n");
		endif;
	}

	function recursiveDelete($val){
		if( stristr($val, "load_controller") ):
			$line             = substr($val, 0, -3);
			$line             = str_replace("load_controller(\"", "", $line);
			$controllerFile   = fopen("app/controller/".$line.".php", "r");
			$controller       = fread($controllerFile, filesize("app/controller/".$line.".php"));
			$controllerLinesC = preg_replace('/\s+/', '', $controller);
			$controllerLinesC = str_replace('<?php', '', $controllerLinesC);
			$controllerLinesC = str_replace('?>', '', $controllerLinesC);
			$controllerLinesC = str_replace(";", ";\n", $controllerLinesC);
			$controllerLines  = explode("\n", $controllerLinesC);

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

	function createModel($val){
		if( $val == "" ):
			exit();
		endif;
		$modelFile = "app/model/".strtolower($val).".php";

		if( !file_exists($modelFile) ):
			$model = "<?php\nclass ".ucfirst(strtolower($val))." extends Model_class{\n\tpublic function __construct(){\n\t\tparent::__construct();\n\t}\n\n\tpublic function init(){\n\t\t\n\t}\n\n\tpublic function __destruct(){\n\t\tparent::__destruct();\n\t}\n}";

			file_put_contents($modelFile, $model);

			print_r("Model created successfully!\n");
		else:
			print_r("Existing Model!\n");
		endif;
	}

	function removeModel($val){
		if( $val == "" ):
			exit();
		endif;
		$modelFile = "app/model/".strtolower($val).".php";

		if( file_exists($modelFile) ):
			unlink($modelFile);
			print_r("Model successfully removed!\n");
		else:
			print_r("Model does not exist!\n");
		endif;
	}

	// Fazer função para carregar sql no banco de dados; 
	// Fazer funções para mecher com banco de dados;
	// Fazer função de HELP
?>