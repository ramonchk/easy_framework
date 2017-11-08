<?php 
Route::get( "/" ,function(){
	load_view("Welcome");
	$teste = load_model("Teste");
	$data['test'] = $teste->test();
	$data['test2'] = (object) array("zero" => "HUE", "um" => array("zero" => "HUEum", "um" => "HUE2"));
	$data['test3'] = array("0" => "HUE", "1" => array("0" => "HUE1", "1" => "12e12"));
	load_view("Test", $data);
});

Route::get( "/teste" , function(){
	load_controller("teste");
});

Route::get( "/teste2", function(){
	$db = load_helper("database");
	$db->set_driver("ASDA");
});