<?
if(!defined("INCLUDED")) exit("Access denied");

$message = "Hello ".$row["name"].",

This is Your Auction Watch.
The following Auction  has been opened matching your keyword(s) : ".$row["auc_watch"]."

Auction : ".$sessionVars["SELL_title"]."
Auction URL: ".$SETTINGS['siteurl']."item.php?id=".$sessionVars['SELL_auction_id']."
";

$CHARSET = "utf-8";
$headers = "From: $SETTINGS['sitename'] <$SETTINGS[adminmail]>\r\n" . "Reply-To: $SETTINGS[adminmail]\r\n" . "Return-path: $SETTINGS[adminmail]\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET";

mail($row["email"],$SETTINGS["sitename"]." - ".$MSG_471,$message,$headers);

?>