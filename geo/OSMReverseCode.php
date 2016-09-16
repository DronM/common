<?php
	require_once('BaseReverseCode.php');
	
	class OSMReverseCode extends BaseReverseCode{
		private static $urlPattern = 
			'http://nominatim.openstreetmap.org/reverse?format=xml&lat=%f&lon=%f&zoom=%d&addressdetails=%d';
	
		public $zoom = 18;
		public $addressdetails = 1;
		
		public function getAddressForCoords($lat,$lon){
			$this->URL = sprintf(OSMReverseCode::$urlPattern,
					NMEAStrToDegree($lat), NMEAStrToDegree($lon), $this->zoom, $this->addressdetails
				);
			//throw new Exception($this->URL);
			$this->open();
			if (isset($this->xmlContent->addressparts)
			){
				$address = $this->xmlContent->addressparts[0];					
				$this->house =			(string) $address->house_number;
				$this->street =			(string) $address->road;
				$this->city =			(string) $address->city;
				$this->state =			(string) $address->state;
				$this->administrative =	(string) $address->administrative;
				$this->postCode	=		(string) $address->postcode;
				$this->country =		(string) $address->country;
			}
			$this->close();
		}
		
	
	}
?>