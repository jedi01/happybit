<?
if(!defined('INCLUDED')) exit("Access denied");

$FROM = "From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\nReplyTo:$SETTINGS[adminmail]";
$TO = stripslashes($seller_email);
$SUBJECT = "Question about your auction";
$MESSAGE = "Hello $seller_nick,<br>
<br>
This message is sent from $SETTINGS[sitename].<br>
<br>
$sender_name has posted a comment in the \"Post a question to the Seller\" section of the item page, for your auction $item_title.<br>
Auction URL: ".$SETTINGS['siteurl']."item.php?id=".$auction_id."<br>
<br>
COMMENT:<br>
<br>
".strip_tags(Filter($reqtext));
?>