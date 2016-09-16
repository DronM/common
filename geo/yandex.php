<?php
function add_offset_to_coords($lat,$lon,&$coords,$offset){
	$DEF_OFFSET = 5;
	
	$offset = (isset($offset))? $offset:$DEF_OFFSET;
	$MAJOR_AXIS = 6378137.0; //meters
	$k = (float) $offset / $MAJOR_AXIS;
	$pk = (float) (180/3.14169);
	
	$dist_lat = $pk * $k;
	$dist_lon =$pk * $k / cos($lat);
	
	$coords['lat_upper'] = $lat + $dist_lat;
	$coords['lon_upper'] = $lon + $dist_lon;
	
	$coords['lat_lower'] = $lat - $dist_lat;
	$coords['lon_lower'] = $lon - $dist_lon;
}

/*
	this function defines coords on address
	$address - array
	$address['region']
	$address['city']
	$address['street']
	$address['building']
	returns
	$res['lon_pos']
	$res['lat_pos']	
	$res['lon_upper']
	$res['lat_upper']
	$res['lon_lower']
	$res['lat_lower']
	$res['kind']
	$res['text']
*/
function get_inf_on_address($address,&$res){
	$addr = (isset($address['region'])&&strlen($address['region']))? 'область+'.$address['region'] : '';
	$addr.= (isset($address['raion'])&&strlen($address['raion']))? ',район+'.$address['raion'] : '';
	$addr.= (isset($address['naspunkt'])&&strlen($address['naspunkt']))? ',населенный пункт+'.$address['naspunkt'] : '';
	$addr.= (isset($address['city'])&&strlen($address['city']))? ',город+'.$address['city'] : '';
	$addr.= (isset($address['street']) && strlen($address['street'])>0)? ',улица+'.$address['street']:'';
	$addr.= (isset($address['building']) && strlen($address['building'])>0)? ',дом+'.$address['building']:'';
	$addr.= (isset($address['korpus']) && strlen($address['korpus'])>0)? ',корпус+'.$address['korpus']:'';	
	//throw new Exception($addr);
	if (!strlen($addr)){
		throw new Exception("Empty address!");
	}
	$URL = sprintf('http://geocode-maps.yandex.ru/1.x/?geocode=%s&key=%s',
		$addr,YANDEX_KEY);
	//throw new Exception($URL);
	$resHandle = fopen($URL,'r');
	if (!$resHandle) {
		throw new Exception('Ошибка чтения ресурса');
	}
	$contents = '';
	while (!feof($resHandle)) {
	  $contents .= fread($resHandle, 8192);
	}
	//throw new Exception($contents);
	$xmlContent = new SimpleXMLElement($contents);	
	fclose($resHandle);
	
	$resp = (int) $xmlContent->GeoObjectCollection[0]->metaDataProperty[0]->GeocoderResponseMetaData[0]->found;
	if ($resp==0){
		throw new Exception('Адрес не найден!');
	}
	
	$res['kind'] = (string) $xmlContent->GeoObjectCollection[0]->featureMember[0]->GeoObject[0]->metaDataProperty[0]->GeocoderMetaData[0]->kind;
	$res['text'] = (string) $xmlContent->GeoObjectCollection[0]->featureMember[0]->GeoObject[0]->metaDataProperty[0]->GeocoderMetaData[0]->text;
	
	$str = (string) $xmlContent->GeoObjectCollection[0]->featureMember[0]->GeoObject->Point->pos;
	$pos = strpos($str,' ');
	if ($pos>=0){
		$res['lon_pos'] = substr($str,0,$pos);
		$res['lat_pos'] = substr($str,$pos+1,strlen($str)-$pos-1);						
	}
	//
	$str = (string) $xmlContent->GeoObjectCollection[0]->featureMember[0]->GeoObject->boundedBy->Envelope->lowerCorner;
	$pos = strpos($str,' ');
	if ($pos>=0){
		$res['lon_lower'] = substr($str,0,$pos);
		$res['lat_lower'] = substr($str,$pos+1,strlen($str)-$pos-1);						
	}
	//
	$str = (string) $xmlContent->GeoObjectCollection[0]->featureMember[0]->GeoObject->boundedBy->Envelope->upperCorner;
	$pos = strpos($str,' ');
	if ($pos>=0){
		$res['lon_upper'] = substr($str,0,$pos);
		$res['lat_upper'] = substr($str,$pos+1,strlen($str)-$pos-1);						
	}
	
}

?>
