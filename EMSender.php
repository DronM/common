<?php
function get_data($smtp_conn){
    $data="";
    while($str = fgets($smtp_conn,515))
    {
        $data .= $str;
        if(substr($str,3,1) == " ") { break; }
    }
    return $data;
}
// Функция для отправки запроса серверу
function smtpCommand($socket, $msg) {
	socket_write($socket, $msg."\r\n", strlen($msg."\r\n"));
}

class EMSender{
	public static function send2($from,$pass,$to,$subject,$message,$SMTPServer,$SMTPPort){
		$domain_pos = strpos($from, '@');
		$login = substr($from,0,$domain_pos-1);
		
		$subject = "Тема письма";
		$message = "Текст письма";
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		$result = socket_connect($socket, $SMTPServer, $SMTPPort);
		if ($result === false){
			throw new Exception("Невозможно соединиться с {$SMTPServer}:{$SMTPPort}");
		}
		smtpCommand($socket, "EHLO ".$SMTPServer); // Посылаем на сервер, что будет аутентификация по логину и паролю
		smtpCommand($socket, "AUTH LOGIN"); // передаем команду ввода логина и пароля
		smtpCommand($socket, base64_encode($login)); // логин, надо кодировать в BASE64
		smtpCommand($socket, base64_encode($pass)); // пароль, надо кодировать в BASE64
		smtpCommand($socket, "MAIL FROM: <{$from}>"); // указываем значение поля "От кого"
		smtpCommand($socket, "RCPT TO: <{$to}>"); // указываем значение поля "Кому"
		smtpCommand($socket, "DATA"); // говорим серверу, что будет сообщение письма
		smtpCommand($socket, "Subject: {$subject}\r\nTo: {$to}\r\n{$message}\r\n."); // добавляем тело письма
		smtpCommand($socket, "QUIT"); // Собственно отправляем письмо и выходим
		socket_close($socket);
	}
	
	public static function send($from,$fromName,$password,$to,$subject,$text,$SMTPServer,$SMTPPort,$attachments=array()){
		$un        = strtoupper(uniqid(time()));
		$any_attachments = (isset($attachments) && is_array($attachments) && count($attachments)>0);
		
		$domain_pos = strpos($from, '@');
		$login = substr($from,0,$domain_pos);
		
		$header="Date: ".date("D, j M Y G:i:s")." +0700\r\n";
		$header.="From: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($fromName)))."?= <".$from.">\r\n"; 
		//$header.="From: =?utf-8?Q?"."?= <".$from.">\r\n";
		$header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n";
		//$header.="Reply-To: =?utf-8?Q?"."?= <".$from.">\r\n";
		$header.="Reply-To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($fromName)))."?= <".$from.">\r\n";
		$header.="X-Priority: 3 (Normal)\r\n";
		$header.="Message-ID: <172562218.".date("YmjHis")."@mail.ru>\r\n";
		$header.="To: =?utf-8?Q?"."?= <".$to.">\r\n";
		$header.="Subject: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($subject)))."?=\r\n";
		$header.="MIME-Version: 1.0\r\n";
		
		if ($any_attachments){
			$header.="Content-Type:multipart/mixed;";
			$header.="boundary=\"----------".$un."\"\n\n"; 
			$header.="------------".$un."\nContent-Type:text/plain; charset=utf-8\r\n";
			$header.="Content-Transfer-Encoding: 8bit\n\n".$text."\n\n";
			
			//attachments
			foreach ($attachments as $filename){
				$f         = fopen($filename,"rb");
				$header.= "Content-Type: application/octet-stream;";
				$header.= "name=\"".basename($filename)."\"\n";
				$header.= "Content-Transfer-Encoding:base64\n";
				$header.= "Content-Disposition:attachment;";
				$header.= "filename=\"".basename($filename)."\"\n\n";
				$header.= chunk_split(base64_encode(fread($f,filesize($filename))))."\n"; 			
				$header.="------------".$un."\n";
			}
		}

		else{
			$header.="Content-Type: text/plain; charset=utf-8\r\n";
			$header.="Content-Transfer-Encoding: 8bit\r\n";
			$header.="\r\n".$text."\r\n.\r\n";
		}
		
		$smtp_conn = fsockopen($SMTPServer, $SMTPPort, $errno, $errstr, 10);
		if(!$smtp_conn) {
			fclose($smtp_conn);
			throw new Exception("Соединение с серверов не прошло");
		}
		$data = get_data($smtp_conn);
		fputs($smtp_conn,"EHLO dron\r\n");
		$code = substr(get_data($smtp_conn),0,3);
		if($code != 250) {
			fclose($smtp_conn);
			throw new Exception("Ошибка приветсвия EHLO");
		}
		fputs($smtp_conn,"AUTH LOGIN\r\n");
		$code = substr(get_data($smtp_conn),0,3);
		if($code != 334) {
			fclose($smtp_conn);
			throw new Exception("Сервер не разрешил начать авторизацию");			
		}

		fputs($smtp_conn,base64_encode($login)."\r\n");
		$code = substr(get_data($smtp_conn),0,3);
		if($code != 334) {
			fclose($smtp_conn);
			throw new Exception("Ошибка доступа к пользователю");
		}

		fputs($smtp_conn,base64_encode($password)."\r\n");
		$code = substr(get_data($smtp_conn),0,3);
		if($code != 235) {
			fclose($smtp_conn);
			throw new Exception("Не правильный пароль");
		}

		/*$size_msg=strlen($header."\r\n".$text);
		fputs($smtp_conn,"MAIL FROM:<".$from."> SIZE=".$size_msg."\r\n");
		*/

		fputs($smtp_conn,"MAIL FROM:<".$from.">\r\n");
		$code = substr(get_data($smtp_conn),0,3);
		if($code != 250) {
			fclose($smtp_conn);
			throw new Exception("Сервер отказал в команде MAIL FROM"); 
		}

		fputs($smtp_conn,"RCPT TO:<".$to.">\r\n");
		$code = substr(get_data($smtp_conn),0,3);
		if($code != 250 AND $code != 251) {
			fclose($smtp_conn);
			throw new Exception("Сервер не принял команду RCPT TO");
		}

		fputs($smtp_conn,"DATA\r\n");
		$code = substr(get_data($smtp_conn),0,3);
		if($code != 354) {
			fclose($smtp_conn);
			throw new Exception("сервер не принял DATA");
		}

		/*fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n");*/
		fputs($smtp_conn,$header);
		
		$code = substr(get_data($smtp_conn),0,3);
		if($code != 250) {
			fclose($smtp_conn);
			throw new Exception("Ошибка отправки письма");
		}

		fputs($smtp_conn,"QUIT\r\n");
		fclose($smtp_conn);
	}
}

?>