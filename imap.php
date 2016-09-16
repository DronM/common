<?php
class IMAP{
	public $imap;
	
	public function get_part($uid, $mimetype, $structure = false, $partNumber = false) {
		if (!$structure) {
			   $structure = imap_fetchstructure($this->imap, $uid, FT_UID);
		}
		if ($structure) {
			if ($mimetype == $this->get_mime_type($structure)) {
				if (!$partNumber) {
					$partNumber = 1;
				}
				$text = imap_fetchbody($this->imap, $uid, $partNumber, FT_UID);
				switch ($structure->encoding) {
					case 3: return imap_base64($text);
					case 4: return imap_qprint($text);
					default: return $text;
			   	}
		   	}
	 
			// multipart
			if ($structure->type == 1) {
				foreach ($structure->parts as $index => $subStruct) {
					$prefix = "";
					if ($partNumber) {
						$prefix = $partNumber . ".";
					}
					$data = $this->get_part($uid, $mimetype, $subStruct, $prefix . ($index + 1));
					if ($data) {
						return $data;
					}
				}
			}
		}
		return false;
	}
	 
	public function get_mime_type($structure) {
		$primaryMimetype = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");
	 
		if ($structure->subtype) {
			return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
		}
		return "TEXT/PLAIN";
	}
	
	public function open($host,$port,$login,
		$pwd,$param,$folder='INBOX'){
		$this->imap = imap_open("{"."{$host}:{$port}{$param}"."}$folder",$login,$pwd);
		if (!$this->imap){
			throw new Exception(imap_last_error());
		}
	}		
	public function getCount(){
		return imap_num_msg($this->imap);
	}
	public function getHeader($ind){
		return imap_header($this->imap,$ind);
	}
	public function delete($ind){
		return imap_delete($this->imap,$ind);
	}
	
	public function getBody($ind) {
		$uid = imap_uid($this->imap, $ind);
		$body = $this->get_part($uid, "TEXT/HTML");
		// if HTML body is empty, try getting text body
		if ($body == "") {
			$body = $this->get_part($uid, "TEXT/PLAIN");
		}
		return $body;
	}
	public function getAttachments($ind) {
		$uid = imap_uid($this->imap, $ind);
		$this->get_part($uid, 'APPLICATION/OCTET-STREAM');
	}		
	
	public function close(){
		imap_close($this->imap);
	}
}

class IMAPMail extends IMAP{
	const HOST = 'imap.mail.ru';
	const PORT = 993;
	const PARAM = '/imap/ssl/novalidate-cert';
	
	public function open($login,$pwd,$folder='INBOX'){
		parent::open(IMAPMail::HOST,
					IMAPMail::PORT,
					$login,$pwd,
					IMAPMail::PARAM,$folder
			);
	}			
}

class IMAPYandex extends IMAP{
	const HOST = 'imap.yandex.ru';
	const PORT = 993;
	const PARAM = '/imap/ssl';
	
	public function open($login,$pwd,$folder='INBOX'){
		parent::open(IMAPYandex::HOST,
					IMAPYandex::PORT,
					$login,$pwd,
					IMAPYandex::PARAM,$folder
			);
	}			
}
?>
