<?php
// Estrutura da rota /caminho/<int>/<string>/<any>/param...
Route::get( "/index" ,function(){ 
	load_controller("WelcomeController");
});