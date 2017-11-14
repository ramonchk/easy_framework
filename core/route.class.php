<?php 
class Route{
	public static $routes;
	public static $params = array("<any>", "<int>", "<string>");

	public function url($url){
		if( $url == "/" ):
			$url = "/index";
		endif;

		if( isset(self::$routes[$url]) ):
			$routeToGet = $url;
			$args       = "";
			$params     = "";
		else:
			$routeToGet = "";
			$allRoutes = self::$routes;
			$errorLint = array("old" => 0, "new" => 0);
			$params    = array();
			$args      = "";
			$old;
			$new;
			foreach ($allRoutes as $key => $value):
				$diferences = get_difference_between($key, $url);
				$old = explode("/", $diferences['new']);
				$new = explode("/", $diferences['old']);

				if( count($old) == count($new) ):
					if( check_values(self::$params, $old)  ):
						$errorLint['old'] = $errorLint['old']+1;
						$errorLint['new'] = $errorLint['new']+1;
						foreach ($old as $key2 => $value2):
							if( $value2 == "<int>" ):
								if( !is_numeric($new[$key2]) ):
									$log['Message'] = "Error in routes";
									$log['Error'] = "Last parameter does not match the required type!";
									$log["paramRequired"] = "Int";
									$log["paramReceived"] = $new[$key2];
									$data['title']   = "404";
									$data['message'] = translate_message("noroute", array("{routeName}" => $url));
									$data['class']   = "error";
									load_view("messages/message", $data);
									exit();
								endif;
							endif;
							if( $value2 == "<string>" ):
								if( !ctype_alpha($new[$key2]) ):
									$log['Message'] = "Error in routes";
									$log['Error'] = "Last parameter does not match the required type!";
									$log["paramRequired"] = "String";
									$log["paramReceived"] = $new[$key2];
									$data['title']   = "404";
									$data['message'] = translate_message("noroute", array("{routeName}" => $url));
									$data['class']   = "error";
									load_view("messages/message", $data);
									exit();
								endif;
							endif;
							array_push($params, $new[$key2]);
							$args .= "\$params[".$key2."],";
							$routeToGet = $key;
							//var_dump($old);
							//var_dump($new);
						endforeach;
					endif;
				endif;
			endforeach;

			//var_dump($url);
			//var_dump($args);
			//var_dump($routeToGet);
			//var_dump($params);

			if( $errorLint['old'] !== 1 || $errorLint['new'] !== 1 ):
				$log['Message'] = "Error in routes";
				$log['Old'] = $old;
				$log['New'] = $new;
				$log['url'] = $url;
				$log['args'] = $args;
				$log['routeToGet'] = $routeToGet;
				$log['params'] = $params;
				create_log($log);
				$data['title']   = "404";
				$data['message'] = translate_message("noroute", array("{routeName}" => $url));
				$data['class']   = "error";
				load_view("messages/message", $data);
				exit();
			endif;
		endif;

		$code  = "\$exec = Route::\$routes['$routeToGet']; \$exec(";
		$args  = substr($args, 0, -1);
		$code .= $args;
		$code .= ");";

		if( isset(self::$routes[$routeToGet]) ):
			if( is_string(self::$routes[$routeToGet]) ):
				load_controller(self::$routes[$routeToGet], $params);
			else:
				$execFunction = create_function('$params', $code);
				$execFunction($params);
			endif;
		else:
			$data['title']   = "404";
			$data['message'] = translate_message("noroute", array("{routeName}" => $url));
			$data['class']   = "error";
			load_view("messages/message", $data);
		endif;
	}

	public static function get( $path , $callback){
		$path = $path;
		if( $path[0] !== "/" ):
			$path = "/".$path;
		endif;
		self::$routes[$path] = $callback;

		$saveRoutes = load_helper("inifile");
		$saveRoutes->init(BASE_PATH.CORE_PATH."routes.ini");
		$routes = array();
		foreach (self::$routes as $key => $value):
			array_push($routes, $key);
		endforeach;
		$data = array("routes" => $routes);
		$saveRoutes->update_file($data, FALSE);
	}
}
?>