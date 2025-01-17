<?php  


namespace App\Libraries;

class JsonLibrary {

	public function readFile ($file) {
		if(file_exists($file)) {
			$data = file_get_contents($file);
			return json_decode($data);  //decode a data
		}
	}

	public function readString ($data) {
		return json_decode($data); 
	}

	public function writeArray ($data) {
		return json_encode($data); 
	}

	public function writeJson (array $data) {
		return json_encode($data); 
	}

	public function objectWriteJson ($data) {
		return json_encode($data); 
	}

}









