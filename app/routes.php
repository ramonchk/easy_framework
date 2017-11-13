<?php
// Estrutura da rota /caminho/<int>/<string>/param/param...
Route::get( "/index" ,function(){ 
	load_controller("welcome");
});