<?
if(!defined('INCLUDED')) exit("Access denied");

if(isset($_COOKIE['USERLANGUAGE'])) {
  $USERLANG = $_COOKIE['USERLANGUAGE'];
} else {
  $USERLANG = $SETTINGS['defaultlanguage'];
}

include $include_path."messages.inc.php";

if($SETTINGS[signupfee] == 2) {
  //$buffer = file($include_path."usermail.".$USERLANG.".inc.php");
  $message = file_get_contents("includes/usermail.EN.inc.php");
} else {
  if($SETTINGS[feetype] == "pay") {
    //$buffer = file($include_path."usermail_pay_invoice.".$USERLANG.".inc.php");
    $message = file_get_contents("includes/usermail_pay_invoice.EN.inc.php");
  } else {
    //$buffer = file($include_path."usermail_prepay.".$USERLANG.".inc.php");
    $message = file_get_contents("includes/usermail_prepay.EN.inc.php");    
  }
}
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
////--Retrieve message

$CONFIRMATIONPAGE = $SETTINGS[siteurl]."confirm.php?id=$TPL_id_hidden";

#//
$query = "SELECT * FROM HB_altpayments";
$r_ = @mysql_query($query);
if(@mysql_num_rows($r_) > 0) {
  while($row = mysql_fetch_array($r_))
  {
    $PAYMENTS .= "$row[title]\n".str_replace("<BR>","\n",$row[description])."\n\n";
  }
  $PAYMENTS .= "\n";
}

//$message = implode($skipped_buffer,"");

//--Change TAGS with variables content

$message = ereg_replace("<#c_payment_methods#>",$PAYMENTS,$message);
$message = ereg_replace("<#c_signupfee#>",print_money($SETTINGS[signupvalue]),$message);
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
$message = ereg_replace("<#c_password#>",AddSlashes($_POST[TPL_password_hidden]),$message);
$message = ereg_replace("<#c_sitename#>",$SETTINGS[sitename],$message);
$message = ereg_replace("<#c_siteurl#>",$SETTINGS[siteurl],$message);
$message = ereg_replace("<#c_adminemail#>",$SETTINGS[adminmail],$message);
$message = ereg_replace("<#c_confirmation_page#>",$CONFIRMATIONPAGE,$message);
$message = ereg_replace("<#c_logo#>",$SETTINGS[siteurl]."themes/".$SETTINGS[theme]."/".$SETTINGS[logo],$message);

$CHARSET = "utf-8";
$headers = "From: $SETTINGS[sitename] <$SETTINGS[adminmail]>\r\n" . "Reply-To: $SETTINGS[adminmail]\r\n" . "Return-path: $SETTINGS[adminmail]\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET";

mail($TPL_email_hidden,"$MSG_098",$message,$headers);

?>