<?
if(!defined('INCLUDED')) exit("Access denied");

	$FROM = "From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\n"."Content-Type: text/html; charset=$CHARSET";
	$TO = stripslashes($seller_email);
	$SUBJECT = "$MSG_650 ";
	$MESSAGE = "Hello $seller_nick,

This message is sent from $SETTINGS[sitename].

$sender_name has posted a comment in the \"Post a question to the Seller\" section of the item page, for your auction $item_title.

COMMENT:

".strip_tags(Filter($reqtext))."
";
?>