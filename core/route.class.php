<?php 
class Route{
	public static $routes;

	public function url($url){
		if( isset(Route::$routes[$url]) ):
			$exec = Route::$routes[$url];
			$exec();
		elseif( isset(Route::$routes[substr($url, 0, -1)]) ):
			$exec = Route::$routes[substr($url, 0, -1)];
			$exec();
		else:
			$data['title'] = "404";
			$data['message'] = translate_message("noroute", array("{routeName}" => $url));
			$data['class'] = "error";
			load_view("messages/message", $data);
		endif;
	}

	public static function get( $path , $callback){
		Route::$routes[$path] = $callback;
	}
}
?>