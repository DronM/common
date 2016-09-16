<?php
class Logger {
	const DEF_DATE_FORMAT = 'd/m/Y H:i';
	const DEF_BUILD_FILE_MODE='0664';
	
	private $file;
	private $content;
	private $dateFormat;
	//private $lineStart;
	
	/*
	private function get_line_count($file){
		$linecount = 0;
		$handle = fopen($file, "r");
		while(!feof($handle)){
		  $line = fgets($handle, 4096);
		  $linecount = $linecount + substr_count($line, PHP_EOL);
		}
		fclose($handle);	
	
		return $linecount;
	}
	*/
	public function __construct($file,$opts=NULL){
	
		$this->file = $file;
		
		if (file_exists($this->file)){
			//$this->lineStart = $this->get_line_count($this->file);
			$this->setPerm = FALSE;
		}
		else{
			$this->content = '';
			$this->setPerm = TRUE;	
			//$this->lineStart = 0;
		}
		
		$this->dateFormat = (is_array($opts) && array_key_exists('dateFormat',$opts))? $opts['dateFormat']:Logger::DEF_DATE_FORMAT;
		$this->buildGroup = (is_array($opts) && array_key_exists('buildGroup',$opts))? $opts['buildGroup']:NULL;
		$this->buildFileMode = (is_array($opts) && array_key_exists('buildFilePermission',$opts))? $opts['buildFilePermission']:Logger::DEF_BUILD_FILE_MODE;
		
	}
	public function add($str){
		$this->content.=date($this->dateFormat).' '.$str.PHP_EOL;
	}

	public function dump(){
		file_put_contents($this->file, $this->content, FILE_APPEND);
		if ($this->setPerm){
			if ($this->buildGroup){
				chgrp($this->file,$this->buildGroup);
			}			
			exec(sprintf('chmod %s %s',$this->buildFileMode,$this->file));
			$this->setPerm = FALSE;
		}
		$this->content = '';
	}
	
	public function getLineIterator(){
		$arrayobject = new ArrayObject(explode(PHP_EOL,$this->content));
		return $arrayobject->getIterator();		
	}
}
?>
