<?php 
class Teste{

	function test(){
		return array(
			0 => "This is a model Test",
			1 => (object) array( "zero" => "Teste", "um" => array( "zero" => "Teste", "um" => "Teste" ) ),
			2 => array( "zero" => "Teste", "um" => (object) array( "zero" => "Teste", "um" => "Teste" ) ),
			3 => (object) array( "zero" => "Teste", "um" => (object) array( "zero" => "Teste", "um" => "Teste" ) ),
			4 => array( "zero" => "Teste", "um" => array( "zero" => "Teste", "um" => "Teste" ) )
		);
	}

}

 ?>