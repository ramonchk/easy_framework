#!/usr/bin/php
<?php
	require_once("core/autoload.php");

	$RoutesFile = file_get_contents("app/routes.php");
	$RoutesFile = (string) $RoutesFile;
	$RoutesFile = str_replace("\n", "<nl>", $RoutesFile);
	$RoutesFile = preg_replace('/\s+/', '', $RoutesFile);
	$RoutesFile = str_replace('<?php', '', $RoutesFile);
	$RoutesFile = str_replace('?>', '', $RoutesFile);
	$routes     = preg_split("/(Route::get)+/", $RoutesFile, -1);
	$routes2    = delete_all_empty_values($routes);
	$routes2    = delete_all_empty_values($routes, "<nl>");
	$routes     = get_values_before(",", $routes2);
	$routes     = remove_character("<nl>", $routes);
	$routes     = remove_character("\"", $routes);
	$routes     = remove_character("(/", $routes);
	$routes2    = add_values_before("Route::get", $routes2);
	$routeFunc  = $routes2;
	//var_dump($routes);
	//var_dump($routeFunc);

	$argumentos = $_SERVER['argv'];

	foreach ($argumentos as $key => $value) {
		$action = $value;
		$value = $argumentos;
		command($action, $value);
	}

	function command($action, $value){
		if( class_exists($action) ):
			$cli = new $action($value);
		endif;
	}

	// Criar e remover Rotas . Fazer função para carregar sql no banco de dados;  . Fazer funções para mecher com banco de dados; . Fazer função de HELP . Função para Verificar arquivos
?>