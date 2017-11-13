<?php 
class WelcomeController{
	public function index($data){
		var_dump($data);
		$data['class'] = "success";
		$data['title'] = translate_message("welcometitleindex");
		$data['message'] = translate_message("welcomemessageindex");
		message_page("message", $data);
	}
}
?>