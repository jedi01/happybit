<?
if(!defined('INCLUDED')) exit("Access denied");

if(!function_exists(GetLeftSeconds)) {
	Function GetLeftSeconds() {
		$today = getdate();
		$month = $today['mon'];
		$mday = $today['mday'];
		$year = $today['year'];
		$lday = 31;
		#// Calculate last day
		while(!checkdate($month, $lday, $year)) {
			$lday--;
		}
		#// Days left t the end of the month
		$left = intval($lday - date("d"));

		return $left;
	}
}

if(!function_exists(FormatDate)) {
	Function FormatDate($DATE) {
		GLOBAL $SETTINGS;

		if (mysql_get_client_info() < 4.1 || !strstr($DATE,"-")){
			if($SETTINGS[datesformat] == "USA") {
				$F_date = substr($DATE,4,2)."/".
						  substr($DATE,6,2)."/".
						  substr($DATE,0,4);
			} else {
				$F_date = substr($DATE,6,2)."/".
						  substr($DATE,4,2)."/".
						  substr($DATE,0,4);
			}
		}else{
			if($SETTINGS[datesformat] == "USA") {
				$F_date = substr($DATE,5,2)."/".
						  substr($DATE,8,2)."/".
						  substr($DATE,0,4);
			} else {
				$F_date = substr($DATE,8,2)."/".
						  substr($DATE,5,2)."/".
						  substr($DATE,0,4);
			}
		}
		return $F_date;
	}
}

if(!function_exists(FormatDateNumeric)) {
	Function FormatDateNumeric($DATE) {
		GLOBAL $SETTINGS;

		if($SETTINGS[datesformat] == "USA") {
			$F_date = substr($DATE,4,2)."/".
					  substr($DATE,6,2)."/".
					  substr($DATE,0,4);
		} else {
			$F_date = substr($DATE,6,2)."/".
					  substr($DATE,4,2)."/".
					  substr($DATE,0,4);
		}
		return $F_date;
	}
}

//-- Date and time hanling functions

if(!function_exists(ActualDate)) {
	function ActualDate() {
		GLOBAL $SETTINGS;
		$date = mktime(date("H")+$SETTINGS[timecorrection],date("i"),date("s"),date("m"),date("d"),date("Y"));
		$month = "MSG_MON_0".date("m",$date);
		GLOBAL $$month;
		//$year = date(" Y, H:i:s");
		return $$month." ".date("d, Y H:i:s", $date);
	}
}

if(!function_exists(ArrangeDate)) {
	function ArrangeDate($day,$month,$year,$hours,$minutes) {
		GLOBAL $SETTINGS;
		$DATE = mktime($hours+$SETTINGS['timecorrection'],$minutes,0,$month,$day,$year);
		$mth = "MSG_MON_0".date("m",$DATE);
		GLOBAL $$mth;
		$return = $$mth.".  ".date("d, Y - H:i",$DATE);
		return $return;
	}

}

if(!function_exists(ArrangeDateNoCorrection)) {
	function ArrangeDateNoCorrection($day,$month,$year,$hours,$minutes) {
		GLOBAL $SETTINGS;
		$DATE = mktime($hours,$minutes,0,$month,$day,$year);
		$mth = "MSG_MON_0".date("m",$DATE)."E";
		GLOBAL $$mth;
		$return = $$mth." ".date("d, Y - H:i",$DATE);
		return $return;
	}
}

if(!function_exists(ArrangeDateMesCompleto)) {
	function ArrangeDateMesCompleto($day,$month,$year,$hours,$minutes) {
		GLOBAL $SETTINGS;
		$DATE = mktime($hours+$SETTINGS['timecorrection'],$minutes,0,$month,$day,$year);
		$mth = "MSG_MON_0".date("m",$DATE)."E";
		GLOBAL $$mth;
		$return = $$mth." ".date("d, Y - H:i",$DATE);
		return $return;
	}
}

if(!function_exists(ArrangeDateNoCorrMesCompleto)) {
	function ArrangeDateNoCorrMesCompleto($day,$month,$year,$hours,$minutes) {
		GLOBAL $SETTINGS;
		$DATE = mktime($hours,$minutes,0,$month,$day,$year);
		$mth = "MSG_MON_0".date("m",$DATE)."E";
		GLOBAL $$mth;
		$return = $$mth." ".date("d, Y - H:i",$DATE);
		return $return;
	}
}

if(!function_exists(TranslateMonth)) {

	function TranslateMonth($m) {		
		$mth = "MSG_MON_0".date("m")."E";
		GLOBAL $$mth;
		return $$mth;
	}
} 
?>