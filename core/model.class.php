<?php
class Model_class{
	private $childName;

	public function __construct(){
		$this->childName = get_called_class();
	}

	public function __destruct(){
		$data['message'] = "Class '".$this->childName."' started successfully!";
		$data['modelName'] = $this->childName.".php";
		create_log($data);
	}
}
?>