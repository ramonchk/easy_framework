<?php 
	$teste = load_model("Teste");
	$data['test'] = $teste->test();
	load_view("Test", $data);
 ?>