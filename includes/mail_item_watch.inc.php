<?#//v.3.1.0
if(!defined('INCLUDED')) exit("Access denied");
$message = "Hello $user_name,<br>
<br>
Someone has bid on an item you have added to your watch list.<br>
<br>
Auction Title: $auc_title <br>
<br>
Current Bid: $new_bid2 <br>
<br>
Auction URL:<br>
$auction_url";

mail($e_mail,"$sitename - Auction watch alert",$message,"From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\nReplyTo:$SETTNGS[adminmail]"); 

?>