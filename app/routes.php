<?php 

	Route::get( "/" ,function(){
		load_view("Welcome");
	});

	Route::get( "/teste" ,function(){
		echo "UASHDUASHUD";
	});

 ?>