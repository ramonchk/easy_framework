<?php
class Upload{
	private $file;
	private $path;
	private $extensions;
	private $returnBool;
	private $extensionFile;
	private $newName = false;
	private $toLog;

	public function init($file, $path, $extensions = "*", $returnBool = 'false'){
		$this->file       = $file;
		$this->path       = $path;
		$this->extensions = $extensions;
		$this->returnBool = $returnBool;
		$this->getExtension();
	}

	public function save_file(){
		if( $this->can_upload() ):
			$uploaddir  = BASE_PATH.$this->path;
			$uploadfile = $uploaddir.basename($this->file['name']);
			if ( move_uploaded_file($this->file['tmp_name'], $uploadfile) ):
				$this->toLog = $this->return($this->file['error'], TRUE, TRUE);
				return $this->return($this->file['error'], TRUE);
			else:
				$this->toLog = $this->return($this->file['error'], FALSE, TRUE);
				return $this->return($this->file['error'], FALSE);
			endif;
		else:
			$this->toLog = $this->return("001", FALSE, TRUE);
			return $this->return("001", FALSE);
		endif;
	}	
	
	public function getExtension(){
		$this->extensionFile = explode('.', $this->file['name']);
		$this->extensionFile = end($this->extensionFile);
		$this->extensionFile = strtolower($this->extensionFile);
		return $this->extensionFile;
	}
	
	private function can_upload(){
		$extensions  = $this->extensions;
		$extension   = $this->extensionFile;
		if( is_array($extensions) ):
			if ( in_array($extension, $extensions) ):
				return true;
			else:
				return false;
			endif;
		else:
			if ( $extension == $extensions ):
				return true;
			elseif( ".".$extension == $extensions ):
				return true;
			elseif( $extensions == "*" ):
				return true;
			else:
				return false;
			endif;
		endif;
	}

	private function uploadMessage($messageNum){
		$errorList = array(
			"001" => translate_message("uploaderror"),
			0     => translate_message("uploadsuccess"),
			1     => translate_message("uploaderror1"),
			2     => translate_message("uploaderror2"),
			3     => translate_message("uploaderror3"),
			4     => translate_message("uploaderror4"),
			6     => translate_message("uploaderror6"),
			7     => translate_message("uploaderror7"),
			8     => translate_message("uploaderror8")
		);

		return $errorList[$messageNum];
	}

	private function return($messageNum, $bool, $array = false){
		if( $array == false ):
			if( $this->returnBool == 'true' ):
				return $bool;
			elseif( $this->returnBool == 'false' ):
				return $this->uploadMessage($messageNum);
			elseif( $this->returnBool == "json" ):
				$toJson = array( "success" => $bool, "message" => $this->uploadMessage($messageNum) );
				return json_encode( $toJson , JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
			else:
				return $bool;
			endif;
		else:
			$toJson = array( "success" => $bool, "message" => $this->uploadMessage($messageNum) );
			return $toJson;
		endif;
	}

	function __destruct(){
		create_log($this->toLog);
	}
}
?>