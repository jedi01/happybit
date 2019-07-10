<?
if(!defined('INCLUDED')) exit("Access denied");

$USERLANG = @mysql_result(@mysql_query("SELECT language FROM HB_userslanguage WHERE user='".$USER."'"),0,"language");
if(empty($USERLANG)) $USERLANG = $SETTINGS['defaultlanguage'];


$buffer = file($include_path."setup_confirmation_pay_mail.".$USERLANG.".inc.php");

$i = 0;

$j = 0;

while($i < count($buffer)){

	if(!ereg("^#(.)*$",$buffer[$i])){

		$skipped_buffer[$j] = $buffer[$i];

		$j++;

	}

	$i++;

}

$auction_url = $SETTINGS[siteurl] . "item.php?mode=1&id=".$_POST[item_number];

//--Retrieve message

$message = implode($skipped_buffer,"");

$messages = stripslashes(strip_tags($message));

//--Change TAGS with variables content
$message = ereg_replace("<#c_name#>",$name,$message);
$message = ereg_replace("<#a_title#>",$TITLE,$message);
$message = ereg_replace("<#a_url#>",$auction_url,$message);
$message = ereg_replace("<#a_id#>","$_POST[item_number]",$message);
$message = ereg_replace("<#c_sitename#>",$SETTINGS[sitename],$message);
$message = ereg_replace("<#c_siteurl#>",$SETTINGS[siteurl],$message);
$message = ereg_replace("<#c_adminemail#>",$SETTINGS[adminmail],$message);
$message = ereg_replace("\n","<br>",$message);

mail($EMAIL,"$MSG_488",stripslashes($message),"From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\n"."Content-Type: text/html; charset=$CHARSET");

?>