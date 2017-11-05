<?php 
class Route{
	public static $ha;

	public function url($url){
		if( substr($url, -1) == "/" ):
			redirect_to(substr($url, 0, -1));
		endif;
		if( isset(Route::$ha[$url]) ):
			$exec = Route::$ha[$url];
			$exec();
		else:
			$data['message'] = translate_message("noroute");
			load_view("messages/error", $data);
		endif;
	}

	public static function get( $path , $callback){
		Route::$ha[$path] = $callback;
	}
}

 ?>