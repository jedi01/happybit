<?
/**
$mail_to
$user_name
$auc_title
$id
$CHARSET
*/

if(!defined('INCLUDED')) exit("Access denied");

$message = "
<br>
<strong>$user_name</strong> has just won an auction. Contact them now to arrange their prize.
<br><br>
<strong><u>Auction Information</u></strong><br>
<strong>Item</strong>: $auc_title<br>
<strong>End Date</strong>: $now<br>
<strong>Item URL</strong>: <a href=".$SETTINGS['siteurl']."item.php?mode=1&id=$auction_id>".$SETTINGS['siteurl']."item.php?id=$auction_id</a><br><br>";

$CHARSET = "ISO-8859-1";
$headers = "From: $SETTINGS[sitename] <$SETTINGS[adminmail]>\r\n" . "Reply-To: $SETTINGS[adminmail]\r\n" . "Return-path: $SETTINGS[adminmail]\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET";
mail($mail_to, "Auction Ended", $message, $headers);

?>