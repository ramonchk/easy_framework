<?php 
class App{
	private $url;

	public function url($url){
		$this->url = $url;
	}

	public function load_routes(){
		$route = $this->get_route();
	}

	private function get_route(){
		$url = $this->url;
		$url = str_replace(URL_BASE, "", $url);
		$url = str_replace("index.php", "", $url);
		$url = str_replace("//", "/", $url);
		$route = new Route();
		$route->url($url);
	}

}

 ?>