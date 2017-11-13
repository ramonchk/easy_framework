<?php 	
	require_once("core/autoload.php");

	if( DEBUG ):
		error_reporting(E_ALL);
		ini_set('display_errors', E_ALL);
	else:
		error_reporting(0);
		ini_set('display_errors', 0);
	endif;

	$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	if( strrpos($url, "?") ):
		$url = explode("?", $url);
		$url = $url[0];
	endif;

	$index = new App();
	$index->url($url);
	$index->load_routes();
?>