<?php
class Inifile{
	private $file;
	private $fileName;

	public function init($file){
		$this->file = parse_ini_file($file, TRUE);
		$this->fileName = $file;
	}

	public function read_file($responseType = "array"){
		$file = $this->file;
		$data = $file;
		if( $responseType == "json" ):
			$data = json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
		endif;
		return $data;
	}

	public function update_file($data, $mantainData = TRUE){
		$old_data = $this->read_file();
		$newData = $data;
		if( $mantainData == TRUE):
			$newData = array_merge_recursive($old_data, $data);
		endif;

		$content = ""; 
		
		foreach($newData as $section=>$values):
			$content .= "[".$section."]\n";
			foreach($values as $key=>$value):
				if( is_array($value) ):
					foreach ($value as $key2 => $value2) :
						$content .= $key."[]=".$value2."\n";
					endforeach;
				else:
					$content .= $key."=".$value."\n"; 
				endif;
			endforeach;
		endforeach;

		if( file_put_contents($this->fileName, $content) ):
			return true;
		else:
			return false;
		endif;
	}

	public function create_file($filePath, $data, $updateIfexists = false){
		if( !file_exists($filePath) ):
			$file = fopen($filePath, "w");
			fclose($file);

			if( !file_exists($filePath) ):
				return false;
			endif;

			$this->init($filePath);
			$this->update_file($data);

			return true;
		else:
			if( $updateIfexists ):
				$this->init($filePath);
				$this->update_file($data);

				return true;
			else:
				return false;
			endif;
		endif;
	}
}