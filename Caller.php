<?php
//Including the Asterisk Manager library
require_once "asterisk/AsteriskManager.php";

class Caller{
	public $server;
	public $port;
	public $user;
	public $pwd;
	
	public function __construct($server,$port,$user,$pwd){
		$this->server = $server;
		$this->port = $port;
		$this->user = $user;
		$this->pwd = $pwd;	
	}
	public function call($from,$to,$priority=1,$timeout=30000,$variables=NULL){
		$CORRECT_TEL_LEN = 11;
		
		$Extension = '';
		for ($i=0;$i<strlen($to);$i++){
			$ch = substr($to,$i,1);
			if (is_numeric($ch)){
				$Extension.=$ch;
			}
		}
		
		if (strlen($Extension)==($CORRECT_TEL_LEN-1)){
			$Extension = '8'.$Extension;
		}
		if (strlen($Extension)!=$CORRECT_TEL_LEN){
			throw new Exception("Не верный номер!");
		}	
		if (substr($Extension,0,1)=='7'){
			$Extension = '8'.substr($Extension,1);
		}
		$Channel = 'Local/'.$from.'@from-internal';
		$Context = 'from-internal';
		
		$ast = new Net_AsteriskManager(array(
						'server'=>$this->server,
						'port'=>$this->port,
						'auto_connect'=>true)
			);
		$ast->connect();		
		usleep(500);
		$ast->login($this->user,$this->pwd);
		/*
		throw new Exception(
			'Extension='.$Extension.
			' Channel='.$Channel.
			' Context='.$Context.
			' from='.$from.'->'.$Extension.
			' priority='.$priority.
			' timeout='.$timeout.
			' variables='.$variables
		
		);
		*/
		usleep(500);
		$ast->originateCall($Extension,
							$Channel,
							$Context,
							$from.'->'.$Extension,
							$priority,
							$timeout,
							$variables
		);
		usleep(500);
		$ast->logout();	
		usleep(500);
		$ast->close();
	}
}
?>
