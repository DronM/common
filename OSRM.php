<?php
class OSRM{
	const SUPPORTED_VERS = '0.3';
	const ER_SERVER_DOWN = 'Сервер OSRM не доступен!';
	const CMD_GET_ROAD_COORD = 'nearest?loc=%s,%s';
	const CMD_GET_ROUTE = 'viaroute?%s';
	const PAR_POINT = 'loc=';
	const PAR_OUTPUT = 'output=';
	
	const DEF_PROTOCOLE = 'http';
	const DEF_PORT = '5000';
	
	public static $strDirections = array(
		'нет инструкций',
		'ехать прямо',
		'небольшой поворот направо',
		'поворот направо',
		'резкий поворот направо',
		'разворот',
		'небольшой поворот налево',
		'поворот налево',
		'резкий поворот налево',
		'промежуточная точка',
		'двигаться дальше прямо',
		'въехать на круг',
		'съехать с круга',
		'двигаться по кругу',
		'начать с конца улицы',
		'приехали'
	);
	
	private $protocole;
	private $host;
	private $port;
	
	public function __construct($protocole,$host,$port){
		$this->protocole = ($protocole)? $protocole:OSRM::DEF_PROTOCOLE;
		$this->host = $host;
		$this->port = ($port)? $port:OSRM::DEF_PORT;
	}	
	
	public function getURL(){
		return sprintf('%s://%s:%s/',
			$this->protocole,$this->host,$this->port);
	}
	
	public function getRoute($points,$outMethod){
		$OUT_XML = 'xml';
		$OUT_JSON = 'json';
		$OUT_GPX = 'gpx';
		
		$params = OSRM::PAR_POINT.implode('&'.OSRM::PAR_POINT,$points);
		
		if (strcmp($outMethod,$OUT_GPX)==0){
			$params.='&output=gpx';
		}
		$url = $this->getURL().sprintf(OSRM::CMD_GET_ROUTE,
				$params);
		$handle = @fopen($url,'r');
		
		if (!$handle) {
			throw new Exception(OSRM::ER_SERVER_DOWN);
		}
		
		$contents = '';
		while (!feof($handle)) {
		  $contents .= fread($handle, 8192);
		}
		fclose($handle);
		
		if (strcmp($outMethod,$OUT_XML)==0){
			//xml
			$xml = new DOMDocument('1.0', 'utf-8');
			$rout = json_decode($contents);
			$rout_node = $xml->appendChild(new DOMElement('rout'));
			//$rout_node->setAttribute('ver',$rout->version);
			$rout_node->setAttribute('status',$rout->status);
			$rout_node->setAttribute('status_message',$rout->status_message);
			foreach ($rout->route_instructions as $instr){
				$rout_instr_node = $rout_node->appendChild(new DOMElement('routInstruction'));					
				//direction
				$dir_node = $rout_instr_node->appendChild(new DOMElement('direction',OSRM::$strDirections[$instr[0]]));
				$dir_node->setAttribute('id',$instr[0]);
				//sreet
				$rout_instr_node->appendChild(new DOMElement('sreet',$instr[1]));
				//meters
				$rout_instr_node->appendChild(new DOMElement('meters',$instr[2]));
				//position
				$rout_instr_node->appendChild(new DOMElement('position',$instr[3]));
				//time
				$rout_instr_node->appendChild(new DOMElement('time',$instr[4]));
				//lenWithUnit
				$rout_instr_node->appendChild(new DOMElement('lenWithUnit',$instr[5]));
				//dirAbr
				$rout_instr_node->appendChild(new DOMElement('dirAbr',$instr[6]));
				//azimuth
				$rout_instr_node->appendChild(new DOMElement('azimuth',$instr[7]));
				
			}
			$rout_node->setAttribute('status_message',$rout->status_message);
			
			$rout_node->appendChild(new DOMElement('routGeometry',$rout->route_geometry));
			
			$summary_node = $rout_node->appendChild(new DOMElement('summary'));
			$summary_node->setAttribute('distance',$rout->route_summary->total_distance);
			$summary_node->setAttribute('time',$rout->route_summary->total_time);
			$summary_node->setAttribute('start',$rout->route_summary->start_point);
			$summary_node->setAttribute('end',$rout->route_summary->end_point);
			
			$hint_node = $rout_node->appendChild(new DOMElement('hint'));
			$hint_node->appendChild(new DOMElement('checksum',$rout->hint_data->checksum));
			
			$locations_node = $hint_node->appendChild(new DOMElement('locations'));
			foreach ($rout->hint_data->locations as $location){
				$locations_node->appendChild(new DOMElement('geom',$location));
			}
			
			$via_node = $rout_node->appendChild(new DOMElement('viaPoints'));
			foreach ($rout->via_points as $via_point){
				$point_node = $via_node->appendChild(new DOMElement('points'));
				$point_node->setAttribute('lat',$via_point[0]);
				$point_node->setAttribute('lon',$via_point[1]);
			}
			return $xml->saveXML();
		}
		else if (strcmp($outMethod,$OUT_JSON)==0){
			return $contents;
		}
		else{
			return $contents;
		}
	}
	
	public function getNearestRoadCoord($in_lat,$in_lon,
		&$out_lat,&$out_lon){
		$url = $this->getURL().sprintf(OSRM::CMD_GET_ROAD_COORD,
				$in_lat,$in_lon);		
		//throw new Exception($url);
		$handle = @fopen($url,'r');
		if (!$handle) {
			throw new Exception(OSRM::ER_SERVER_DOWN);
		}
		$contents = '';
		while (!feof($handle)) {
		  $contents .= fread($handle, 8192);
		}
		fclose($handle);
		$res = json_decode($contents);
		if ($res->status!=0){
			throw new Exception('Не найдена ближайшая дорога!');
		}
		if (is_array($res->mapped_coordinate)
		&&count($res->mapped_coordinate)>=2){
			$out_lat = $res->mapped_coordinate[0];
			$out_lon = $res->mapped_coordinate[1];
		}
	}
	public function getDistance($points){
		$params = OSRM::PAR_POINT.implode('&'.OSRM::PAR_POINT,$points);
		$params.='&output=json';
		
		$url = $this->getURL().sprintf(OSRM::CMD_GET_ROUTE,
				$params);
		$handle = @fopen($url,'r');
		if (!$handle) {
			throw new Exception(OSRM::ER_SERVER_DOWN);
		}
		$contents = '';
		while (!feof($handle)) {
		  $contents .= fread($handle, 8192);
		}
		fclose($handle);
		
		$rout = json_decode($contents);
		return $rout->route_summary->total_distance;
	}
	
}
?>