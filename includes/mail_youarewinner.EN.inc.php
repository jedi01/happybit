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
Congratulations, you've won an auction on <a href='".$SETTINGS['siteurl']."'>".$SETTINGS['sitename']."</a>! <br><br>
We'll be in touch shortly with more details!
<br><br>

<strong>Auction Details</strong>
<br>
<br>
<strong>Title:</strong> $auc_title<br>
<strong>Ended:</strong> $now<br>
<strong>Item link:</strong> <a href=".$SETTINGS['siteurl']."item.php?mode=1&id=$auction_id>".$SETTINGS['siteurl']."item.php?id=$auction_id</a>

<br>
<br>	
If you have received this message in error, please let us know.<br>";

$headers = "From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\r\n" . "Reply-To: $SETTINGS[adminmail]\r\n" . "Return-path: $SETTINGS[adminmail]\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET";

mail($mail_to, "You've won an auction!", $message, $headers);

?>