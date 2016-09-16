<?php
function myutf8_substr($str,$from,$len){
	# utf8 substr
	return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
	'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
	'$1',$str);
}
function get_short_name($full_name){
	if (strlen($full_name)==0){
		return '';
	}
	$name_ar = explode(' ',$full_name);
	$n = count($name_ar);
	$f_name = ($n>=1)? $name_ar[0]:'';
	$ini1_name = ($n>=2)? myutf8_substr($name_ar[1],0,1):'';
	$ini2_name = ($n>=3)? myutf8_substr($name_ar[2],0,1):'';
	return $f_name.' '.$ini1_name.'.'.$ini2_name.'.';
}

?>