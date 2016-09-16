<?php
ini_set("soap.wsdl_cache_enabled", "0");
class Object1c{
	const URL_TEMPLATE = "http://%s/ws/%s.1cws?wsdl";
	
	private $method;
	private $client;
	
	protected $response;
	
	public function __construct($host,$user,$password,$service,$method){
		$this->method = $method;
		
		$this->client = new SoapClient(
			sprintf(Object1c::URL_TEMPLATE,
				$host,$service),
			array('login'=> $user,
			'password'=> $password)); 		
	}
	public function select($params){
		$meth = $this->method;
		$this->response = $this->client->$meth($params);
	}
	
}
?>