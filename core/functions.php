<?php 
	function load_view($viewname, $data = null){
		if( can_open_view($viewname) ):
			$data = $data;
			require_once(BASE_PATH."app\\views\\".$viewname.".php");
		else:
			message_page("error", translate_message('viewnotfound'));
		endif;
	}

	function load_model($model, $data = null){
		if( can_open_model($model) ):
			require_once(BASE_PATH."app\\model\\".$model.".php");
			return New $model();
		else:
			message_page("error", translate_message('modelnotfound'));
		endif;
	}

	function message_page($view, $message){
		if( can_open_view("messages\\".$view) ):
			$data["message"] = $message;
			load_view("messages/".$view, $data);
			exit();
		else:
			$data['message'] = translate_message('viewnotfound');
			load_view("messages/error", $data);
			exit();
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

	function base_url(){
		if( USE_HTACCESS ):
			return URL_BASE;
		else:
			return URL_BASE."/index.php";
		endif;
	}

	function redirect_to($url){
		//header("Location: ".base_url().$url);
	}

 ?>