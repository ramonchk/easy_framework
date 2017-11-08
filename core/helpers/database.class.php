<?php 
class database{
	private $driver;

	public function __construct(){
	}

	public function set_driver($driver){
		$this->driver = $driver;
	}

	public function __destruct(){
	}
}
