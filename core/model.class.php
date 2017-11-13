<?php
class Model_class{
	private $baseClassChildName;

	public function __construct(){
		$this->baseClassChildName = get_called_class();
	}

	public function __destruct(){
		$data['message']   = "Class '".$this->baseClassChildName."' started successfully!";
		$data['modelName'] = $this->baseClassChildName.".php";
		create_log($data);
	}
}
?>