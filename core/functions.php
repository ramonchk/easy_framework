<?php 
	function load_view($viewname, $data = null){
		if( can_open_view($viewname) ):
			$data = $data;
			if( $data !== null ):
				foreach ($data as $key => $value):
					$$key = $value;
				endforeach;
			endif;
			require_once(BASE_PATH."app\\views\\".$viewname.".php");
		else:
			$data['message'] = translate_message('viewnotfound');
			$data['error'] = "404";
			$data['class'] = "error";
			message_page("error", $data);
		endif;
	}

	function load_model($model){
		if( can_open_model($model) ):
			require_once(BASE_PATH."app\\model\\".$model.".php");
			return New $model();
		else:
			$data['message'] = translate_message('modelnotfound');
			$data['error'] = "404";
			$data['class'] = "error";
			message_page("error", $data);
		endif;
	}

	function load_controller($file){
		if( can_open_controller($file) ):
			require_once(BASE_PATH."app\\controller\\".$file.".php");
		else:
			$data['message'] = translate_message('controllernotfound');
			$data['error'] = "404";
			$data['class'] = "error";
			message_page("error", $data);
		endif;
	}

	function load_helper($file){
		if( can_open_helper($file) ):
			require_once(BASE_PATH."core\\helpers\\".$file.".class.php");
			return New $file();
		else:
			$data['message'] = translate_message('helpernotfound');
			$data['error'] = "404";
			$data['class'] = "error";
			message_page("error", $data);
		endif;
	}

	function message_page($view, $data){
		if( can_open_view("messages\\".$view) ):
			die(load_view("messages/".$view, $data));
		else:
			$data['message'] = translate_message('viewnotfound');
			$data['error'] = "404";
			$data['class'] = "error";
			die(load_view("messages/error", $data));
		endif;
	}

	function translate_message($which, $lang = LANGUAGE_DEFAULT){
		$message = array();
		include(BASE_PATH."lang\\".$lang."\\lang.php");
		return $message[$which];
	}

	function can_open_view($file){
		return file_exists(BASE_PATH."app\\views\\".$file.".php");
	}

	function can_open_model($file){
		return file_exists(BASE_PATH."app\\model\\".$file.".php");
	}

	function can_open_controller($file){
		return file_exists(BASE_PATH."app\\controller\\".$file.".php");
	}

	function can_open_helper($file){
		return file_exists(BASE_PATH."core\\helpers\\".$file.".class.php");
	}

	function base_url(){
		if( USE_HTACCESS ):
			return URL_BASE;
		else:
			return URL_BASE."/index.php";
		endif;
	}

	function redirect_to($url){
		header("Location: ".base_url().$url);
	}

	function redirect_link($to = ""){
		$link = USE_HTACCESS ? URL_BASE.$to : URL_BASE."/index.php".$to;
		return $link;
	}

 ?>