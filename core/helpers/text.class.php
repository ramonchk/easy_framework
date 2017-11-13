<?php 
class Text{
	public static function word_delimiter($data, $words = 15){
		$data = explode(" ", $data);
		$newData = array();
		for ($i=0; $i < (int)$words; $i++):
			array_push($newData, $data[$i]);
		endfor;
		return implode(" ", $newData);
	}

	public static function char_delimiter($data, $words = 300, $end = ""){
		$text  = substr($data, 0, $words);
		$text  = strrpos($text, ' ');
		$text  = substr($data, 0, $text);
		$text .= $end;
		return $text;
	}

	public static function highlight($text, $highlight, $highlightColor = "#990000", $textColor = "white"){
		$text = str_ireplace($highlight, "<span style=\"color: $textColor; background-color: $highlightColor\">$highlight</span>", $text);
		return $text;
	}
}