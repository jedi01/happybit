<?
if(!defined('INCLUDED')) exit("Access denied");

if(isset($_COOKIE['USERLANGUAGE'])) {
  $USERLANG = $_COOKIE['USERLANGUAGE'];
} else {
  $USERLANG = $SETTINGS['defaultlanguage'];
}

include $include_path."messages.inc.php";

//echo $include_path."usermail_needapproval.".$USERLANG.".inc.php";

//$buffer = file($include_path."usermail_needapproval.".$USERLANG.".inc.php");

//$i = 0;
//$j = 0;
//while($i < count($buffer)) {
//  if(!ereg("^#(.)*$",$buffer[$i])){
//    $skipped_buffer[$j] = $buffer[$i];
//    $j++;
//  }
//  $i++;
//}
//--Reteve message

$CONFIRMATIONPAGE = $SETTINGS[siteurl]."confirm.php?id=$TPL_id_hidden";
$message = file_get_contents("includes/usermail_needapproval.EN.inc.php");

//--Change TAGS with variables content
//print_r($_POST);

//030313 - START - Added facebook details for facebook connect email
if ($signupType==1){
$TPL_email_hidden = $email;
$message = ereg_replace("<#c_id#>",AddSlashes($TPL_id_hidden),$message);
$message = ereg_replace("<#c_name#>",AddSlashes($TPL_name_hidden),$message);
$message = ereg_replace("<#c_nick#>",$lowUsername,$message);
$message = ereg_replace("<#c_address#>",AddSlashes($_POST[TPL_address]),$message);
$message = ereg_replace("<#c_city#>",AddSlashes($_POST[TPL_city]),$message);
$message = ereg_replace("<#c_prov#>",AddSlashes($_POST[TPL_prov]),$message);
$message = ereg_replace("<#c_zip#>",AddSlashes($_POST[TPL_zip]),$message);
$message = ereg_replace("<#c_country#>",AddSlashes($_POST[TPL_country]),$message);
$message = ereg_replace("<#c_phone#>",AddSlashes($_POST[TPL_phone]),$message);
$message = ereg_replace("<#c_email#>",$TPL_email_hidden,$message);
$message = ereg_replace("<#c_password#>",$password_hidden,$message);
$message = ereg_replace("<#c_sitename#>",$SETTINGS[sitename],$message);
$message = ereg_replace("<#c_siteurl#>",$SETTINGS[siteurl],$message);
$message = ereg_replace("<#c_adminemail#>",$SETTINGS[adminmail],$message);
$message = ereg_replace("<#c_confirmation_page#>",$CONFIRMATIONPAGE,$message);
$message = ereg_replace("<#c_logo#>",$SETTINGS[siteurl]."themes/".$SETTINGS[theme]."/".$SETTINGS[logo],$message);
}else{
$message = ereg_replace("<#c_id#>",AddSlashes($TPL_id_hidden),$message);
$message = ereg_replace("<#c_name#>",AddSlashes($TPL_name_hidden),$message);
$message = ereg_replace("<#c_nick#>",AddSlashes($TPL_nick_hidden),$message);
$message = ereg_replace("<#c_address#>",AddSlashes($_POST[TPL_address]),$message);
$message = ereg_replace("<#c_city#>",AddSlashes($_POST[TPL_city]),$message);
$message = ereg_replace("<#c_prov#>",AddSlashes($_POST[TPL_prov]),$message);
$message = ereg_replace("<#c_zip#>",AddSlashes($_POST[TPL_zip]),$message);
$message = ereg_replace("<#c_country#>",AddSlashes($_POST[TPL_country]),$message);
$message = ereg_replace("<#c_phone#>",AddSlashes($_POST[TPL_phone]),$message);
$message = ereg_replace("<#c_email#>",AddSlashes($_POST[TPL_email]),$message);
$message = ereg_replace("<#c_password#>",AddSlashes($_POST[TPL_password]),$message);
$message = ereg_replace("<#c_sitename#>",$SETTINGS[sitename],$message);
$message = ereg_replace("<#c_siteurl#>",$SETTINGS[siteurl],$message);
$message = ereg_replace("<#c_adminemail#>",$SETTINGS[adminmail],$message);
$message = ereg_replace("<#c_confirmation_page#>",$CONFIRMATIONPAGE,$message);
$message = ereg_replace("<#c_logo#>",$SETTINGS[siteurl]."themes/".$SETTINGS[theme]."/".$SETTINGS[logo],$message);
}
//030313 - END - Added facebook details for facebook connect email


$CHARSET = "utf-8";
$headers = "From: $SETTINGS[sitename] <$SETTINGS[adminmail]>\r\n" . "Reply-To: $SETTINGS[adminmail]\r\n" . "Return-path: $SETTINGS[adminmail]\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET";

//echo "$TPL_email_hidden, '$MSG_098', $message,$headers";

mail($TPL_email_hidden, "$MSG_098", $message,$headers);


?>