<?php 
class Route{
	public static $routes;
	public static $params;

	public function url($url){
		if( $url == "/" ):
			$url = "/index";
		endif;

		$path = explode("/", $url);
		unset($path[0]);

		$url_base = $path[1];
		unset($path[1]);
		$params = $path;

		$routeToGet = "/".$url_base;

		$args = "";

		foreach ($params as $key => $value):
			if( is_numeric($value) ):
				$routeToGet = $routeToGet.'/<int>';
			elseif( is_string($value) ):
				$routeToGet = $routeToGet."/<string>";
			endif;
			$args .= "\$params[".$key."],";
		endforeach;

		$code = "\$exec = Route::\$routes['$routeToGet']; \$exec(";
		$args = substr($args, 0, -1);
		$code .= $args;
		$code .= ");";

		if( isset(Route::$routes[$routeToGet]) ):
			$execFunction = create_function('$params', $code);
			$execFunction($params);
		else:
			$data['title'] = "404";
			$data['message'] = translate_message("noroute", array("{routeName}" => $url));
			$data['class'] = "error";
			load_view("messages/message", $data);
		endif;
	}

	public static function get( $path , $callback){
		$path = $path;
		if( $path[0] !== "/" ):
			$path = "/".$path;
		endif;
		Route::$routes[$path] = $callback;

		$saveRoutes = load_helper("inifile");
		$saveRoutes->init(BASE_PATH.CORE_PATH."routes.ini");
		$routes = array();
		foreach (Route::$routes as $key => $value) {
			array_push($routes, $key);
		}
		$data = array("routes" => $routes);
		$saveRoutes->update_file($data, FALSE);
	}
}
?>