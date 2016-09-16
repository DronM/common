<?php
require_once('Object1c.php');

class Journal1c extends Object1c{
	const METHOD = "Get";

	public function __construct($host,$service,$user,$password){
		parent::__construct($host,$user,$password,
		$service,
		Journal1c::METHOD);
	}
	public function select($params){
		parent::select($params);
		//var_dump($this->response->return);
		if (is_array($this->response->return->Content)){
			$ar_obj = new ArrayObject($this->response->return->Content);
		}
		else{
			$v = new SoapVar($this->response->return->Content,SOAP_ENC_OBJECT);
			$ar_obj = new ArrayObject(array($v));
		}
		return $ar_obj->getIterator();
	}	
}
?>