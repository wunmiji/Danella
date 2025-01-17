<?php 

namespace App\Libraries;


/**
 * 
 */
class DateLibrary {
	
	//'Y-m-d\\TH:i:s.vp'

	public function getUtc () : string { 
		$utc = new \DateTime('now', new \DateTimeZone('UTC'));
		return $utc->format('Y-m-d\\TH:i:s.vp');
 	}

 	public static function getFormat ($utc) {
 		if (!is_null($utc)) {
			$dateTime = new \DateTime($utc);
			return $dateTime->format('l, d F Y H:i A');
 		}
 	}

 	public static function getDate ($utc) {
 		if (!is_null($utc)) {
			$dateTime = new \DateTime($utc);
			return $dateTime->format('l, d F Y');
 		}
 	}

	 public static function getDatedFY ($utc) {
		if (!is_null($utc)) {
		   $dateTime = new \DateTime($utc);
		   return $dateTime->format('d F Y');
		}
	}

	 public static function formatTimestamp($timestamp)
	 {
		 if (!is_null($timestamp)) {
			 $dateTime = new \DateTime();
			 $dateTime->setTimestamp($timestamp);
			 return $dateTime->format('l, d F Y');
		 }
	 }

}