<?#//v.3.2.3
if(!defined('INCLUDED')) exit("Access denied");
$message = "Hello $user_name,<br>
<br>
Someone has bid on an item you have added to your item watch list.<br>
<br>
Auction Title: $auc_title <br>
<br>
Current Bid: $new_bid2 <br>
<br>
Auction URL<br>
<a href=".$SETTINGS['siteurl']."item.php?mode=1&id=$id>$auction_url</a>";

mail($e_mail,"$sitename - $MSG_472",$message,"From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\n"."Content-Type: text/html; charset=$CHARSET");

?>