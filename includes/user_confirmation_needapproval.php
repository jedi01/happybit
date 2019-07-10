<?
if(!defined('INCLUDED')) exit("Access denied");

if(isset($_COOKIE['USERLANGUAGE'])) {
  $USERLANG = $_COOKIE['USERLANGUAGE'];
} else {
  $USERLANG = $SETTINGS['defaultlanguage'];
}

include $include_path."messages.inc.php";
//$buffer = file($include_path."usermail_needapproval.".$USERLANG.".inc.php");
//
//$i = 0;
//$j = 0;
//while($i < count($buffer)) {
//  if(!ereg("^#(.)*$",$buffer[$i])){
//    $skipped_buffer[$j] = $buffer[$i];
//    $j++;
//  }
//  $i++;
//}
////--Reteve message

$CONFIRMATIONPAGE = $SETTINGS[siteurl]."confirm.php?id=$TPL_id_hidden";
//$message = implode($skipped_buffer,"");
$message = file_get_contents("usermail_needapproval.IT.inc.php");
  
//--Change TAGS with variables content

$message = ereg_replace("<#c_id#>",AddSlashes($TPL_id_hidden),$message);
$message = ereg_replace("<#c_name#>",AddSlashes($TPL_name_hidden),$message);
$message = ereg_replace("<#c_nick#>",AddSlashes($TPL_nick_hidden),$message);
$message = ereg_replace("<#c_address#>",AddSlashes($TPL_address),$message);
$message = ereg_replace("<#c_city#>",AddSlashes($TPL_city),$message);
$message = ereg_replace("<#c_prov#>",AddSlashes($TPL_prov),$message);
$message = ereg_replace("<#c_zip#>",AddSlashes($TPL_zip),$message);
$message = ereg_replace("<#c_country#>",AddSlashes($TPL_country),$message);
$message = ereg_replace("<#c_phone#>",AddSlashes($TPL_phone),$message);
$message = ereg_replace("<#c_email#>",AddSlashes($TPL_email_hidden),$message);
$message = ereg_replace("<#c_password#>",AddSlashes($TPL_password_hidden),$message);
$message = ereg_replace("<#c_sitename#>",$SETTINGS[sitename],$message);
$message = ereg_replace("<#c_siteurl#>",$SETTINGS[siteurl],$message);
$message = ereg_replace("<#c_adminemail#>",$SETTINGS[adminmail],$message);
$message = ereg_replace("<#c_confirmation_page#>",$CONFIRMATIONPAGE,$message);

$CHARSET = "utf-8";
$headers = "From: $SETTINGS[sitename] <$SETTINGS[adminmail]>\r\n" . "Reply-To: $SETTINGS[adminmail]\r\n" . "Return-path: $SETTINGS[adminmail]\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET";

mail($TPL_email_hidden,$MSG_098,$message,$headers);


?>