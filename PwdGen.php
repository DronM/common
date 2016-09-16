<?php
function gen_pwd($len,$type="ALL"){
	if ($type=="NUM"){
		$simvols = array ("0","1","2","3","4","5","6","7","8","9");
	}
	else{
		$simvols = array ("0","1","2","3","4","5","6","7","8","9",
						"a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
						"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	}	
					
	$string = '';			
	for ($key = 0; $key < $len; $key++){
		shuffle ($simvols);
		$string = $string.$simvols[1];
	}
	return $string;
}
function xor_pwd($str){
	return $str;
}
?>