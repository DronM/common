<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>	
<link rel="stylesheet" href="main.css" type="text/css"/>
<html>
<style type="text/css">
	<!--
	.calendarHeader{ font-weight: bolder; color: #CC0000; background-color: #FFFFCC; }
	.calendarToday { background-color: #FFFFFF; }
	.calendar { background-color: #FFFFCC; } -->
</style> 
<head>
	<title>CMS</title>
</head>
<body>

<?php
	require_once('calendar.php');
	
	class MyCalendar extends Calendar {
		public $select_id; 
		public $select_act; 
		public $select_attr; 
		public $select_to; 
		public $select_mode; 
		public $select_obj_id; 
		function getCalendarLink($month, $year) {
			// Redisplay the current page, but with some parameters
			// to set the new month and year
			$s = getenv('SCRIPT_NAME');
			return "$s?month=$month&year=$year&select_id=$this->select_id&select_attr=$this->select_attr&select_act=$this->select_act&select_mode=$this->select_mode&select_obj_id=$this->select_obj_id&select_to=$this->select_to";
		}
		function getDateLink($day, $month, $year){
			$link = sprintf('../cmd.php?act=selected_date&select_day=%d&select_month=%d&select_year=%d&select_id=%s&select_attr=%s&select_act=%s&select_mode=%s&select_obj_id=%s&select_to=%d',
							$day, $month, $year, $this->select_id, $this->select_attr, $this->select_act, $this->select_mode, $this->select_obj_id, $this->select_to);
			return $link; 
		}
	}
	$cal = new MyCalendar;
	$months = array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
	$days = array ("В", "П", "В", "С", "Ч", "П", "С");
	$cal->setMonthNames($months);
	$cal->setDayNames($days);	
	$cal->setStartDay(1); 
	
	//all possiable args
	$params['month']='int';
	$params['year']='int';
	$params['select_id']='char';
	$params['select_attr']='char';
	$params['select_act']='char';
	$params['select_to']='int';
	$params['select_mode']='char';
	$params['select_obj_id']='char';
	foreach ($params as $key=>$value) {
		if (isset($_GET[$key])){
			if (get_magic_quotes_gpc())
				$get_val = stripslashes($_GET[$key]);
			else
				$get_val = $_GET[$key];
			if ($value=='int') 
				$$key = intval($get_val);
			else if ($params[$key]=='char') 
				$$key = $get_val;
		}
	}
	//echo 'select id='.$select_id.' attr='.$select_attr.' act='.$select_act.' to='.$select_to.' mode='.$select_mode;
	$cal->select_id		= $select_id; 
	$cal->select_act	= $select_act; 
	$cal->select_attr	= $select_attr; 
	$cal->select_mode	= $select_mode; 
	$cal->select_obj_id	= $select_obj_id; 
	$cal->select_to		= $select_to; 
	
	$d = getdate(time()); 
	$month = (isset($month))? $month : $d["mon"];
	$year = (isset($year))? $year : $d["year"];
	echo $cal->getMonthView($month, $year); 	
	
	echo '<a href="../cmd.php?act=not_selected&select_id='.$select_id.'&select_act='.$select_act.'&select_mode='.$select_mode.'&select_obj_id='.$select_obj_id.'"><img src="pic/no.gif" alt="Отмена"/></a>'; 
?>
</body>
</html>