<?php
	if( isset($_GET['lang']) ):
		DEFINE("USE_THIS_LANG", $_GET['lang']);
	endif;

	function load_view($viewname, $data = null){
		if( can_open_view($viewname) ):
			$data = $data;
			if( $data !== null ):
				foreach ($data as $key => $value):
					$$key = $value;
				endforeach;
			endif;
			require_once(BASE_PATH.VIEWS_PATH.$viewname.".php");
		else:
			$data['message'] = translate_message('viewnotfound', array("{viewName}" => $viewname));
			$data['title']   = "404";
			$data['class']   = "error";
			message_page("message", $data);
		endif;
	}

	function load_model($model, $initParam = null){
		if( is_array($model) ):
			foreach ($model as $key => $value):
				load_model($value);
			endforeach;
		else:
			if( can_open_model($model) ):
				require_once(BASE_PATH.MODEL_PATH.$model.".php");
				if( $initParam == null ):
					return New $model($initParam);
				else:
					return New $model();
				endif;
			else:
				$data['message'] = translate_message('modelnotfound', array("{modelName}" => $model));
				$data['title']   = "404";
				$data['class']   = "error";
				message_page("message", $data);
			endif;
		endif;
	}

	function load_controller($controller, $data = array()){
		$controler = null;
		$controllerFile = $controller;
		$controllerFunc = "index";
		$newdata = array();
		if( strripos ($controller, ".") ):
			$controler = explode(".", $controller);
			$controllerFile = $controler[0];
			$controllerFunc = $controler[1];
			unset($controler[0]);
			unset($controler[1]);
		endif;
		if( !empty($controler) ):
			foreach ($controler as $key => $value):
				$newdata[$value] = $data[$key];
			endforeach;
		else:
			if( is_array($data) ):
			foreach ($data as $key => $value):
				array_push($newdata, $data[$key]);
			endforeach;
			endif;
		endif;
		if( can_open_controller($controllerFile) ):
			require_once(BASE_PATH.CONTROLLER_PATH.$controllerFile.".php");
			$controller = New $controllerFile;
			if( $controllerFunc !== "" ):
				$controller->$controllerFunc($newdata);
			endif;
		else:
			$data['message'] = translate_message('controllernotfound', array("{controllName}" => $controllerFile));
			$data['title']   = "404";
			$data['class']   = "error";
			message_page("message", $data);
		endif;
	}

	function load_helper($file){
		if( is_array($file) ):
			foreach ($file as $key => $value):
				load_helper($value);
			endforeach;
		else:
			if( can_open_helper($file) ):
				require_once(BASE_PATH.HELPERS_PATH.$file.".class.php");
				return New $file();
			else:
				$data['message'] = translate_message('helpernotfound', array("{modelName}" => $file));
				$data['title']   = "404";
				$data['class']   = "error";
				message_page("message", $data);
			endif;
		endif;
	}

	function message_page($view = "message", $data = array("class" => "error", "title" => "Message Page", "message" => "Without Message!")){
		if( can_open_view("messages".DIR_SEPARATOR.$view) ):
			create_log($data);
			die( load_view("messages/".$view, $data) );
		else:
			$data['message'] = translate_message('viewnotfound');
			$data['title']   = "404";
			$data['class']   = "error";
			create_log($data);
			die(load_view("messages/message", $data));
		endif;
	}

	function translate_message($which, $var = null, $lang = "eng"){
		$lang = get_lang_to_use();
		$message = array();
		include(BASE_PATH.LANG_PATH.$lang.DIR_SEPARATOR.LANG_FILE);
		$message = $message[$which];
		if( $var !== null ):
			foreach ($var as $key => $value):
				$message = str_replace($key, $value, $message);
			endforeach;
		endif;
		return $message;
	}

	function can_open_view($file){
		return file_exists(BASE_PATH.VIEWS_PATH.$file.".php");
	}

	function can_open_model($file){
		return file_exists(BASE_PATH.MODEL_PATH.$file.".php");
	}

	function can_open_controller($file){
		return file_exists(BASE_PATH.CONTROLLER_PATH.$file.".php");
	}

	function can_open_helper($file){
		return file_exists(BASE_PATH.HELPERS_PATH.$file.".class.php");
	}

	function base_url(){
		if( USE_HTACCESS ):
			return URL_BASE;
		else:
			return URL_BASE."/index.php";
		endif;
	}

	function redirect_to($url){
		header("Location: ".base_url().$url, FALSE);
	}

	function redirect_link($to = "", $title = "", $class = "", $id = ""){
		$link = base_url().$to;
		if( $title !== "" ):
			$link = "<a title=\"".$title."\" class=\"".$class."\" id=\"".$id."\" href=\"".$link."\">".$title."</a>";
		endif;
		return $link;
	}

	function get_database_infos($db = "default"){
		include("app/database.php");
		return $database[$db];
	}

	function load_css($cssFile){
		print_r("<link rel=\"stylesheet\" href=\"".URL_BASE.PUBLIC_PATH.$cssFile."\" />");
	}

	function load_js($jsFile){
		print_r("<script src=\"".URL_BASE.PUBLIC_PATH.$jsFile."\"></script>");
	}

	function create_log($message){
		if( LOG ):
			if ( !isset($_SESSION) ):
				session_start();
			endif;

			$logId = ( ( ( rand() * rand() ) + rand() ) - rand() );
			$logFileName = BASE_PATH.LOG_PATH.date('d-m-Y H-i-s')." ".$logId.".json";
			$toJson = array(
				"logId"    => $logId,
				"date"     => date('d/m/Y H:i:s'),
				"ip"       => get_client_ip(),
				"sessions" => $_SESSION,
				"cookies"  => $_COOKIE,
				"message"  => $message
			);

			$string = json_encode( $toJson, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );

			file_put_contents($logFileName, $string);
		endif;
	}

	function get_client_ip(){
		$ipaddress = '';
		if( isset($_SERVER['HTTP_CLIENT_IP']) ):
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		elseif( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ):
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		elseif( isset($_SERVER['HTTP_X_FORWARDED']) ):
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		elseif( isset($_SERVER['HTTP_FORWARDED_FOR']) ):
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		elseif( isset($_SERVER['HTTP_FORWARDED']) ):
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		elseif( isset($_SERVER['REMOTE_ADDR']) ):
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else:
			$ipaddress = 'UNKNOWN';
		endif;

		return $ipaddress;
	}

	function get_lang_to_use(){
		$use = "eng";
		if( DEFINED("USE_THIS_LANG") && null !== USE_THIS_LANG && USE_THIS_LANG !== "" ):
			$use = USE_THIS_LANG;
		elseif( DEFINED("LANGUAGE_DEFAULT") && LANGUAGE_DEFAULT !== null ):
			$use = LANGUAGE_DEFAULT;
		endif;

		if( file_exists(BASE_PATH.LANG_PATH.$use.DIR_SEPARATOR.LANG_FILE) ):
			return $use;
		else:
			$data["class"]   = "error";
			$data["title"]   = "Language file not Found!";
			$data["message"] = "The language file is missing.<br/>Please use the --verify_files command in the cli.php file to fix this error!";
			create_log($data);
			message_page("message", $data);
		endif;
	}

	function get_difference_between($old, $new){
		$from_start = strspn($old ^ $new, "\0");        
		$from_end = strspn(strrev($old) ^ strrev($new), "\0");

		$old_end = strlen($old) - $from_end;
		$new_end = strlen($new) - $from_end;

		$start = substr($new, 0, $from_start);
		$end = substr($new, $new_end);
		$new_diff = substr($new, $from_start, $new_end - $from_start);  
		$old_diff = substr($old, $from_start, $old_end - $from_start);

		return array("old"=>$new_diff, "new"=>$old_diff);
	}

	function check_values($keyToVerify, $array){
		$newArray = array();
		foreach ($array as $key => $value):
			if( in_array($value, $keyToVerify) ):
				array_push($newArray, $array[$key]);
			endif;
		endforeach;

		if( $newArray == $array ):
			return true;
		else:
			return false;
		endif;
	}

	function delete_all_empty_values($array, $toThisValue = null){
		$array = $array;

		foreach ($array as $key => $value):
			if( $toThisValue == null ):
				if( strlen($value) == 0 ):
					unset($array[$key]);
				endif;
			else:
				if( $value == $toThisValue ):
					unset($array[$key]);
				endif;
			endif;
		endforeach;

		return $array;
	}

	function get_values_after($after, $string){
		if( is_array($string) ):
			$return = array();
			foreach ($string as $key => $value) {
				$value = strstr($value, $after);
				array_push($return, $value);
			}
			return $return;
		else:
			$value = strstr($string, $after);
			return $value;
		endif;
	}

	function get_values_before($before, $string){
		if( is_array($string) ):
			$return = array();
			foreach ($string as $key => $value) {
				$value = strstr($value, $before, true);
				array_push($return, $value);
			}
			return $return;
		else:
			$value = strstr($string, $before, true);
			return $value;
		endif;
	}

	function remove_character($remove, $string){
		if( is_array($string) ):
			$return = array();
			foreach ($string as $key => $value) {
				$value = str_replace($remove, "", $value);
				array_push($return, $value);
			}
			return $return;
		else:
			$value = str_replace($remove, "", $string);
			return $value;
		endif;
	}

	function add_values_before($before, $string){
		if( is_array($string) ):
			$return = array();
			foreach ($string as $key => $value) {
				$value = $before.$value;
				array_push($return, $value);
			}
			return $return;
		else:
			$value = $before.$string;
			return $value;
		endif;
	}

	//Dowload,Email,File,HTML,XML, Twig