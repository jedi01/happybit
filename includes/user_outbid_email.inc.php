<?
if(!defined('INCLUDED')) exit("Access denied");

if(isset($_COOKIE['USERLANGUAGE'])) {
  $USERLANG = $_COOKIE['USERLANGUAGE'];
} else {
  $USERLANG = $SETTINGS['defaultlanguage'];
}

include $include_path."messages.inc.php";


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
$message = file_get_contents("includes/usermail_outbid_email.EN.inc.php");

//--Change TAGS with variables content
//print_r($_POST);

//030313 - START - Added facebook details for facebook connect email

$TPL_email_hidden = $min_bidder_email;
$message = ereg_replace("<#c_nick#>",$min_bidder_nick,$message);
$message = ereg_replace("<#c_auctiontitle#>",AddSlashes($TPL_title),$message);
$message = ereg_replace("<#c_auctionid#>",AddSlashes($TPL_id_value),$message);
$message = ereg_replace("<#c_sitename#>",$SETTINGS[sitename],$message);
$message = ereg_replace("<#c_siteurl#>",$SETTINGS[siteurl],$message);
$message = ereg_replace("<#c_adminemail#>",$SETTINGS[adminmail],$message);
$message = ereg_replace("<#c_confirmation_page#>",$CONFIRMATIONPAGE,$message);
$message = ereg_replace("<#c_logo#>",$SETTINGS[siteurl]."themes/".$SETTINGS[theme]."/".$SETTINGS[logo],$message);


$CHARSET = "utf-8";
$headers = "From: $SETTINGS[sitename] <$SETTINGS[adminmail]>\r\n" . "Reply-To: $SETTINGS[adminmail]\r\n" . "Return-path: $SETTINGS[adminmail]\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET";

//echo "$TPL_email_hidden, '$MSG_098', $message,$headers";

mail($TPL_email_hidden, "You've been outbid on ".$TPL_title, $message,$headers);


?>