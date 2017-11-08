<?php 
class Route{
	public static $ha;

	public function url($url){
		if( isset(Route::$ha[$url]) ):
			$exec = Route::$ha[$url];
			$exec();
		elseif( isset(Route::$ha[substr($url, 0, -1)]) ):
			$exec = Route::$ha[substr($url, 0, -1)];
			$exec();
		else:
			$data['message'] = translate_message("noroute");
			$data['error'] = "404";
			load_view("messages/error", $data);
		endif;
	}

	public static function get( $path , $callback){
		Route::$ha[$path] = $callback;
	}
}

 ?>