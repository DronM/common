<?php
class BBCode {
	public static function getHTML($str_input){
		$str = htmlspecialchars($str_input);
		$str = chop($str);
		/*
		$pattern_span = array(0 => '/\[bgcolor\=(.+?)\](.+?)\[\/bgcolor\]/s',
								1 => '/\[center\](.+?)\[\/center\]/s',
								2 => '/\[left\](.+?)\[\/left\]/s',
								3 => '/\[right\](.+?)\[\/right\]/s');
		
		$replacement_span = array(0 => 'background-color:',
								1 => 'text-align:center;',
								2 => 'text-align:left;',
								3 => 'text-align:right;');
		
		*/
		//Arrays for the bbCode replacements
		$pattern = array(0 => '/\[b\](.+?)\[\/b\]/s',
								1 => '/\[i\](.+?)\[\/i\]/s',
								2 => '/\[u\](.+?)\[\/u\]/s',
								5 => '/\[url\](.+?)\[\/url\]/s',
								6 => '/\[url\=(.+?)\](.+?)\[\/url\]/s',
								7 => '/\[img\](.+?)\[\/img\]/s',
								8 => '/\[color\=(.+?)\](.+?)\[\/color\]/s',
								9 => '/\[size\=(.+?)\](.+?)\[\/size\]/s',								
								10 => '/\[s\](.+?)\[\/s\]/s',
								11 => '/\[list\](.+?)\[\/list\]/s',
								12 => '/\[li\](.+?)\[\/li\]/s',
								13 => '/\[table\](.+?)\[\/table\]/s',
								14 => '/\[tr\](.+?)\[\/tr\]/s',
								15 => '/\[td\](.+?)\[\/td\]/s',
								16 => '/\[bgcolor\=(.+?)\](.+?)\[\/bgcolor\]/s',
								17 => '/\[center\](.+?)\[\/center\]/s',
								18 => '/\[left\](.+?)\[\/left\]/s',
								19 => '/\[right\](.+?)\[\/right\]/s',
								20 => '/\[pre\](.+?)\[\/pre\]/s',
								21 => '/\[hr\]/s',
								22 => '/\[font\=(.+?)\](.+?)\[\/font\]/s');

		$replacement = array(0 => '<b>$1</b>',
								1 => '<i>$1</i>',
								2 => '<u>$1</u>',
								5 => '<a href="$1">$1</a>',
								6 => '<a href="$1">$2</a>',
								7 => '<img src="$1" alt="User submitted image" title="User submitted image"/>',
								8 => '<font color="$1">$2</font>',
								9 => '<font size="$1">$2</font>',
								10 => '<s>$1</s>',
								11 => '<ul>$1</ul>',
								12 => '<li>$1</li>',
								13 => '<table>$1</table>',
								14 => '<tr>$1</tr>',
								15 => '<td>$1</td>',
								16 => '<span style="background-color:$1">$2</span>',
								17 => '<div class="text_align_center">$1</div>',
								18 => '<div class="text_align_left">$1</div>',
								19 => '<div class="text_align_right">$1</div>',
								20 => '<pre>$1</pre>',
								21 => '<hr></hr>',
								22 => '<font face="$1">$2</font>');

		ksort($pattern);
		ksort($replacement);				
		$str_span = '';
		$res = preg_replace($pattern, $replacement, $str);
		/*
		$i=0;
		foreach ($pattern_span as &$value) {
			if (preg_match($value,$str, $matches)){
				if (strlen($str_span)==0){
					$str_span = '<div style="';
				}
				$str_span = $str_span . $replacement_span[$i];
				//echo '   0='.$matches[0].'1='.;
				$s = substr($replacement_span[$i],strlen($replacement_span[$i])-1,1);
				if ($s<>';'){
					$str_span = $str_span . $matches[1].';';
				}
			}
			$i++;
		}
		
		if (strlen($str_span)>0){
			$res = $str_span. '">'.$res.'</div>';
			//echo 'TEXT='.$str_span;
		}
		*/
		return $res;
	}
}
?>