<?php
class MyDate{
	public static function IsLeapYear($date) {
		$date_time_array = getdate($date);
		return ($date_time_array['year']%4==0);
	}

	/*
	private $date;
	public function __construct($date){
		$this->date = $date;
	}
	*/
	public static function DateAdd($interval, $number, $date) {
		$date_time_array = getdate($date);
		$hours = $date_time_array['hours'];
		$minutes = $date_time_array['minutes'];
		$seconds = $date_time_array['seconds'];
		$month = $date_time_array['mon'];
		$day = $date_time_array['mday'];
		$year = $date_time_array['year'];

		switch ($interval) {
		
			case 'yyyy':
				$year+=$number;
				break;
			case 'q':
				$month+=($number*3);
				break;
			case 'm':
				$month+=$number;
				break;
			case 'y':
			case 'd':
			case 'w':
				$day+=$number;
				break;
			case 'ww':
				$day+=($number*7);
				break;
			case 'h':
				$hours+=$number;
				break;
			case 'n':
				$minutes+=$number;
				break;
			case 's':
				$seconds+=$number; 
				break;            
		}
		   $timestamp= mktime($hours,$minutes,$seconds,$month,$day,$year);
		return $timestamp;
	}
	
	public static function getRusMonth($month){
		if($month > 12 || $month < 1) return FALSE;
		$aMonth = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
		return $aMonth[$month - 1];
	}
	public static function getRusDayOfWeek($date){
		$aDOW = array('Воскресенье','Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота');
		return $aDOW[date('w',$date)];
	}
	
	public static function StartMonth($date){
		$date_time_array = getdate($date);
		$month = $date_time_array['mon'];
		$day = 1;//month first date
		$year = $date_time_array['year'];		
		return mktime(0,0,0,$month,$day,$year);
	}
	public static function EndMonth($date){	
		$feb_days = (MyDate::IsLeapYear($date))? 29:28;
		$DAYS_IN_MONTHS = array(31,$feb_days,31,30,31,30,31,31,30,31,30,31);
		
		$date_time_array = getdate($date);
		$month = $date_time_array['mon'];
		$day = $DAYS_IN_MONTHS[$month-1];//month last day
		$year = $date_time_array['year'];		
		
		return mktime(23,59,59,$month,$day,$year);
	}	
	public static function StartYear($date){
		$date_time_array = getdate($date);
		$month = 1;//first month
		$day = 1;//month first date
		$year = $date_time_array['year'];		
		return mktime(0,0,0,$month,$day,$year);
	}
	public static function EndYear($date){
		$date_time_array = getdate($date);
		$month = 12;//last month
		$day = 31;//last date
		$year = $date_time_array['year'];		
		return mktime(23,59,59,$month,$day,$year);
	}
	public static function EndDay($date){
		$dt = getdate($date);
		return mktime(23,59,59,$dt['mon'],$dt['mday'],$dt['year']);
	}
	public static function StartDay($date){
		$dt = getdate($date);
		return mktime(0,0,0,$dt['mon'],$dt['mday'],$dt['year']);
	}
	
	
}

?>