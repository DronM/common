<?php
/*
 глКонтрольныйСимволEAN(ШтрКод, Тип)

 Параметры:
  ШтрКод - 12-символьный штрих-код (без контрольной цифры)
  Тип    - тип штрихкода: 13 - EAN13, 8 - EAN8

 Возвращаемое значение: 
  Контрольный символ 

 Описание: 
  Функция вычисляет контрольный символ кода EAN
*/
function EAN_check_sum($barcode, $type){
	
	$even = 0;
	$n_even = 0;
	
	if ($type == 13){
		$interl_cnt = 6;
	}
	else{
		$interl_cnt = 4;
	}
	
	for ($i=1;$i<=$interl_cnt;$i++){
		$even += $barcode[2*$i-1];
		$n_even += $barcode[2*$i-1-1];
	}
	//echo "even=$even</br>";
	//echo "n_even=$n_even</br>";
	
	if ($type == 13){
		$even *= 3;
	}
	else{
		$n_even *= 3;
	}
    
	$dig = 10 - ($even + $n_even) % 10;
	
	return ($dig == 10)? "0":$dig;
}

function Code_2of5_Ch($s) {
	if ($s == "0"){
		$res = "11331";
	}
	else if ($s == "1"){
		$res = "31113";
	}
	else if ($s == "2"){
		$res = "13113";
	}
	else if ($s == "3"){
		$res = "33111";
	}
	else if ($s == "4"){
		$res = "11313";
	}
	else if ($s == "5"){
		$res = "31311";
	}
	else if ($s == "6"){
		$res = "13311";
	}
	else if ($s == "7"){
		$res = "11133";
	}
	else if ($s == "8"){
		$res = "31131";
	}
	else if ($s == "9"){
		$res = "13131";
	}
	
	return $res;
}

 //Определение набора полос Interleaved 2 of 5 по двум символам
function Interleaved_2of5_Pair($Pair){
    $s1 = Code_2of5_Ch(substr($Pair, 0, 1));
    $s2 = Code_2of5_Ch(substr($Pair, 1, 1));
    $s = "";
    for ($i=0;$i<strlen($s1);$i++){
        $s .= substr($s1, $i, 1) . substr($s2, $i, 1);
	}
	
    return $s;
}

function Code_Char($a){
	if ($a=="211412"){
		$s = "A";
	}
	else if ($a == "211214"){
    	$s = "B";
	}
	else if ($a == "211232"){
    	$s = "C";
	}
	else if ($a == "2331112"){
    	$s = "@";
	}
	else{
        $s = "";
        for ($i=0;$i<strlen($a) / 2;$i++){
			$prom = substr($a, 2 * $i, 2);
			
            if ($prom == "11"){
                $s .= "0";
			}
			else if ($prom == "21"){
                $s .= "1";
			}
			else if ($prom == "31"){
                $s .= "2";
			}
			else if ($prom == "41"){
                $s .= "3";
			}
			else if ($prom == "12"){
                $s .= "4";
			}
			else if ($prom == "22"){
                $s .= "5";
			}
			else if ($prom == "32"){
                $s .= "6";
			}
			else if ($prom == "42"){
                $s .= "7";
			}
			else if ($prom == "13"){
                $s .= "8";
			}
			else if ($prom == "23"){
                $s .= "9";
			}
			else if ($prom == "33"){
                $s .= ":";
			}
			else if ($prom == "43"){
                $s .= ";";
			}
			else if ($prom == "14"){
                $s .= "<";
			}
			else if ($prom == "24"){
                $s .= "=";
			}
			else if ($prom == "34"){
                $s .= ">";
			}
			else if ($prom === "44"){
                $s .= "?";
            }
        }
    }
    return $s;	
}

function ean13($code){
	$res = '';
	for ($i=0;$i<strlen($code)/2-1;$i++){
		
		$p1 = substr($code, $i * 2, 2);		
		$p2 = Interleaved_2of5_Pair($p1);		
		$res .= Code_Char($p2);
		//echo "i=$i p1=$p1 p2=$p2 res=$res</br>";
	}
	return Code_Char("1111") . $res . Code_Char("3111");
}
?>