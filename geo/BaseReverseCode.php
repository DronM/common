<?php
function NMEAStrToDegree($str){
	$DEGREE_DIGITS = 2;
	$deg=0;
	$min=0;
	if ($str){
		$str_source = $str;
		$ind=0;
		while ($str_source[$ind]=='0'){
			$ind++;
		}
		if ($ind>0){
			$str_source = substr($str_source,$ind);
		}
		
		$deg = doubleval(substr($str_source,0,$DEGREE_DIGITS));
		if (strlen($str_source)>$DEGREE_DIGITS){
			$str_source = substr($str_source, $DEGREE_DIGITS);
			
			$ind=0;
			while ($str_source[$ind]=='0'){
				$ind++;
			}
			if ($ind>0){
				$str_source = substr($str_source,$ind);
			}
			
			$min = doubleval($str_source);
			return $deg + $min/60.0;
		}
	}
}

	class BaseReverseCode{
		protected $URL;
		protected $xmlContent;
		
		public $house;
		public $street;
		public $city;
		public $state;
		public $administrative;
		public $country;
		public $postCode;
		
		/* 
			opens and parces the contents
		*/
		protected function open(){
			$this->postCode = '';
			$this->house='';
			$this->street='';
			$this->city='';
			$this->state='';
			$this->administrative='';
			$this->country='';
		
			$resHandle = fopen($this->URL, 'r');
			if (!$resHandle) {
				throw new Exception('Ошибка чтения ресурса '.$this->URL);
			}
			$contents = '';
			while (!feof($resHandle)) {
			  $contents .= fread($resHandle, 8192);
			}
			//echo $contents;
			$this->xmlContent = new SimpleXMLElement($contents);
			
			fclose($resHandle);
		}
		protected function close(){
			unset($this->xmlContent);
		}
		
		protected function addressToView(){
			return 
				(
					$this->state . (($this->state!='')? ', ':'').
					$this->city . (($this->city!='')? ', ':'').
					$this->street . (($this->street!='')? ', ':'').
					$this->house . (($this->house!='')? ', ':'')
				);
			/*
			($this->postCode . (($this->postCode!='')? ', ':'').
			$this->country . (($this->country!='')? ', ':'').
			$this->administrative . (($this->administrative!='')? ', ':'').
			$this->city . (($this->city!='')? ', ':'').
			$this->state . (($this->state!='')? ', ':'').
			$this->street . (($this->street!='')? ', ':'').
			$this->house . (($this->house!='')? ', ':'')
			);
			*/
		}
		
		public function getAddressForCoords($lat,$lon){
			return 'в разработке';
		}
	}
?>