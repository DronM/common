<?php
require_once('ObjectCacher.php');
require_once('Object1c.php');
class Object1cContainer extends Object1c{
	const METHOD = 'Get';

	public function __construct($host,$user,$password,$service,$method=NULL){
		parent::__construct($host,$user,$password,$service,
			($method==NULL)? Object1cContainer::METHOD:$method);
	}
	public function select($params){
		$ar = ObjectCacher::get($this->service,$this->method,$params);
		if (is_null($ar)){
			parent::select($params);
			if (isset($this->response->return->Content)){
				if (is_array($this->response->return->Content)){
					$ar = $this->response->return->Content;
				}
				else{
					
					$ar = array($this->response->return->Content);
				}
			}
			else{
				$ar = array();
			}
			ObjectCacher::set($this->service,$this->method,$params,$ar);
		}
		else{
			//echo "FROM CACHE!!!";
		}
		$ar_obj = new ArrayObject($ar);
		return $ar_obj->getIterator();
	}
	
	
}
?>