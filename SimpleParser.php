<?php
/*
	str - string to parse
	pattern1 - pattern to search to start extracting
	pattern2 - pattern to end extracting
	from - int position to start searching 0..
	res result structure
		val - extracted string between 2 patterns
		res - offset for next search
*/
class SimpleParser{
	public static function parse($str,$pattern1,$pattern2,$from,&$res){
		$p1 = strpos($str,$pattern1,$from);
		if ($p1!==FALSE){
			if ($pattern2){
				$p2 = strpos($str,$pattern2,$p1+strlen($pattern1));
				$res['val'] = 
					substr($str,$p1+strlen($pattern1),$p2-$p1-strlen($pattern1));
				$res['from'] = $p2+strlen($pattern2);				
			}
			else{
				//to the end
				$res['val'] = substr($str,$p1+strlen($pattern1));
				$res['from'] = -1;
			}
			return TRUE;
		}
	}
}
?>
