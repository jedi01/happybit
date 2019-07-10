<?
if(!defined('INCLUDED')) exit("Access denied");

#// Retrieve user's prefered language
$USERLANG = @mysql_result(@mysql_query("SELECT language FROM HB_userslanguage WHERE user='".$row['id']."'"),0,"language");
if(!isset($USERLANG)) $USERLANG = $SETTINGS['defaultlanguage'];

$buffer = file($include_path."mail_endauction_cumulative.".$USERLANG.".inc.php");
$i = 0;
$j = 0;
while($i < count($buffer))
{
	if(!ereg("^#(.)*$",$buffer[$i])){
		$skipped_buffer[$j] = $buffer[$i];
		$j++;
	}
	$i++;
}
//--Reteve message
$message = implode($skipped_buffer,"");

//--Change TAGS with variables content

$message = ereg_replace("<#s_name#>",$Seller['name'],$message);
$message = ereg_replace("<#i_report#>",$report,$message);

$message = ereg_replace("<#c_sitename#>",$SETTINGS[sitename],$message);
$message = ereg_replace("<#c_siteurl#>",$SETTINGS[siteurl],$message);
$message = ereg_replace("<#c_adminemail#>",$SETTINGS[adminmail],$message);

mail($Seller["email"],$MSG_25_0199,stripslashes($message),"From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\n"."Content-Type: text/html; charset=$CHARSET");

?>