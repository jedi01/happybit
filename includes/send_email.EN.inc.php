<?
if(!defined('INCLUDED')) exit("Access denied");

$FROM = "From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\n"."Content-Type: text/html; charset=$CHARSET";
$TO = stripslashes($seller_email);
$SUBJECT = $MSG_650;
$MESSAGE = "Hello $seller_nick,<br>
<br>
This message is sent from $SETTINGS[sitename].<br>
<br>
<#s_name#> at <a href='mailto:<#sender_email#>'><#sender_email#></a> has a question for you regarding your auction $item_title.<br>
<br>
Question:<br>
".strip_tags(Filter($_POST[sender_question]))."<br>
<br>
Auction URL: <a href='".$SETTINGS['siteurl']."item.php?id=".$auction_id."'>".$SETTINGS['siteurl']."item.php?id=".$auction_id."</a><br>
<br>
Thank you for be part of $SETTINGS[sitename]<br>
<a href='<#c_siteurl#>'><#c_siteurl#></a><br>
";

$MESSAGE = ereg_replace("<#s_name#>","$_POST[sender_name]",$MESSAGE);
$MESSAGE = ereg_replace("<#s_email#>","$_POST[sender_email]",$MESSAGE);
$MESSAGE = ereg_replace("<#s_comment#>","$sender_comment",$MESSAGE);
$MESSAGE = ereg_replace("<#sender_question#>","$_POST[sender_question]",$MESSAGE);
$MESSAGE = ereg_replace("<#sender_email#>","$_POST[sender_email]",$MESSAGE);
$MESSAGE = ereg_replace("<#c_sitename#>",$SETTINGS[sitename],$MESSAGE);
$MESSAGE = ereg_replace("<#c_siteurl#>",$SETTINGS[siteurl],$MESSAGE);

?>