<?php
	require_once('BaseReverseCode.php');
	
	class YndxReverseCode extends BaseReverseCode{
		//lon lat
		private static $urlPattern = 
			'http://geocode-maps.yandex.ru/1.x/?geocode=%f,%f&key=%s';
	
		public function getAddressForCoords($lat,$lon){
			$this->URL = sprintf(YndxReverseCode::$urlPattern,
					$lon, $lat,
					YANDEX_KEY
				);
			//throw new Exception($this->URL);
			$this->open();
				
			$this->state = $this->xmlContent->GeoObjectCollection[0]->featureMember[0]->GeoObject->metaDataProperty->GeocoderMetaData->text;
				/*
				$address = $this->xmlContent->GeoObjectCollection[0]->featureMember[0]->GeoObject->metaDataProperty->GeocoderMetaData->AddressDetails;
				if (isset($address->Country->AdministrativeArea->AdministrativeAreaName)){				
					$this->state =			(string) $address->Country->AdministrativeArea->AdministrativeAreaName;
				}
				if (isset($address->Country->CountryName)){
					$this->country =			(string) $address->Country->CountryName;
				}
				
				$locality = $address->Country->AdministrativeArea->Locality;
				if (isset($locality)){
					if 	(isset($locality[0]->LocalityName)){
						$this->city =			(string) $locality[0]->LocalityName;
					}						
					if 	(isset($locality[0]->LocalityName[0]->Thoroughfare)){
						if 	(isset($locality[0]->LocalityName[0]->Thoroughfare[0]->ThoroughfareName)){
							$this->street =			(string) $locality[0]->LocalityName[0]->Thoroughfare[0]->ThoroughfareName;
						}
						if 	(
							(isset($locality[0]->LocalityName[0]->Thoroughfare[0]->Premise))
						&&	(isset($locality[0]->LocalityName[0]->Thoroughfare[0]->Premise[0]->PremiseNumber))
						){
							$this->house =			(string) $locality[0]->LocalityName[0]->Thoroughfare[0]->Premise[0]->PremiseNumber;
						}
					}
					
				}
				*/
				$this->close();
				//return $this->addressToView();				
		}
		
	
	}
?>