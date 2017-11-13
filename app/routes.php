<?php
// Estrutura da rota /caminho/<int>/<string>/<any>/param...
Route::get( "/index" ,function(){ 
	load_controller("WelcomeController");
});

Route::get( "/vai/vai/<int>" ,function($id){ 
	echo $id;
});
//http://localhost/framework/vai/vai/12312