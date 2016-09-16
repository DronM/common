<?php

class PDFReport{
	//private static $cmdLine = 'D:\WWW\Apache2\fop-1.0\fop.bat -d -c D:\WWW\Apache2\fop-1.0\conf\conf.xml -xml %s -xsl %s -pdf %s';
	private static $cmdLine = '/usr/bin/fop/fop -c /usr/bin/fop/conf/conf.xml -q -xml %s -xsl %s -pdf %s';
	//private static $basePath = 'D:\\WWW\\Apache2\\htdocs\\';
	private static $basePath = '/usr/share/nginx/www/';
	public static function get_abs_path($path){
		//return PDFReport::$basePath.str_replace('/','\\',RELATIVE_PATH).str_replace('/','\\',$path);
		return PDFReport::$basePath.RELATIVE_PATH.$path;
	}
	
	public static function createFromFile($xmlFile, $xsltFile,$outputFile){
		$output = '';
		exec(sprintf(PDFReport::$cmdLine,
				PDFReport::get_abs_path($xmlFile), PDFReport::get_abs_path($xsltFile), PDFReport::get_abs_path($outputFile)
				)
			);
	}
	public static function createFromDOM($xmlDOM, $xsltFile,$outputFile){
	}
	
}

?>
