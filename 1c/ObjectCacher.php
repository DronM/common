<?php
class ObjectCacher{
	const CACHE_DIR = "D:/WWW/Apache2/htdocs/new_mine/client_manager/cache";

	private static function get_file_name($service,$method,$params){
		//echo "md5=".$service."_".$method.implode("_",$params);
		return md5($service."_".$method.implode("_",$params));
	}
	
	//returns array
	public static function get($service,$method,$params){
		$file_name = ObjectCacher::CACHE_DIR."/".ObjectCacher::get_file_name($service,$method,$params);
		if (file_exists($file_name)){
			$handle = fopen($file_name, "r");
			$contents = fread($handle, filesize($file_name));
			fclose($handle);			
			return unserialize($contents);
		}
	}
	//array contents
	public static function set($service,$method,$params,$contents){
		$file_name = ObjectCacher::CACHE_DIR."/".ObjectCacher::get_file_name($service,$method,$params);
		if (file_exists($file_name)){
			unlink($file_name);
		}
		$handle = fopen($file_name, 'x');
		fwrite($handle, serialize($contents));
		fclose($handle);
		//chmod($file_name, 777);   
	}
	
}
?>