<?php
Route::get( "/" ,function(){
	load_view("Welcome");
});

Route::get( "/teste" , function(){
	load_controller("teste");
});

Route::get( "/teste2", function(){
	$db = load_helper("database");
	echo redirect_link("", true, "Inicio");

	$db->init();
	$aulas = $db->query("SHOW TABLES;");
	var_dump(json_decode($aulas));
});

Route::get( "/teste3", function(){
	$db = load_helper("database");
	echo redirect_link("", true, "Inicio");

	$db->init();
	$aulas = $db->query("SHOW TABLES;");
	var_dump(json_decode($aulas));

	$db->init("visu");
	$frases = $db->query("SHOW TABLES;");
	var_dump(json_decode($frases));
});
