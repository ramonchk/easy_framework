<?php 
	$db = load_helper("database");
	$teste = load_model("Teste");
	$data['test'] = $teste->test();
	$data['test2'] = (object) array("zero" => "HUE", "um" => array("zero" => "HUEum", "um" => "HUE2"));
	$data['test3'] = array("0" => "HUE", "1" => array("0" => "HUE1", "1" => "asdas"));
	load_view("Test", $data);

	$db->set_driver("ASDA");
 ?>