<?
if(!defined('INCLUDED')) exit("Access denied");


//-- CheckAge function checks the age of a user
//-- Returns: 0 if younger than 18
//--          1 if older than 18


if(!function_exists(CheckAge)) {

	Function CheckAge($day,$month,$year)
	{
		$NOW_year	= date("Y");
		$NOW_month	= date("m");
		$NOW_day	= date("d");

		if(($NOW_year - $year) > 16)
		{
				return 1;
		}
		else if((($NOW_year - $year) == 16) && ($NOW_month > $month))
		{
				return 1;
		}
		else if((($NOW_year - $year) == 16) && ($NOW_month == $month) && ($NOW_day >= $day))
		{
				return 1;
		}
		else
		{
				return 0;
		}
	}
}

?>
