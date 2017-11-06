<?php 

	Route::get( "/" ,function(){
		load_view("Welcome");
	});

	Route::get( "/teste" ,function(){
		$teste = load_model("Teste");
		$data['test'] = $teste->test();
		load_view("Test", $data);
	});

 ?>