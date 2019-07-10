<?
/**
$mail_to
$user_name
$auc_title
$id
$CHARSET
*/

if(!defined('INCLUDED')) exit("Access denied");

$message = "Hello $user_name,<br>
<br>
This is an automated response. <br> 
Auction, which was signed: ".$auc_title." set aside to ".$now."! <br> 
Auction URL: <br>
<a href=".$SETTINGS['siteurl']."item.php?mode=1&id=$auction_id>$auc_title</a>";

$CHARSET = "utf-8";
$headers = "From: HAPPYBID - 	
The new auction site to the bottom <$SETTINGS[adminmail]>\r\n" . "Reply-To: $SETTINGS[adminmail]\r\n" . "Return-path: $SETTINGS[adminmail]\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET";

mail($mail_to, "Auction started", $message, $headers);

?>
