<?
if(!defined("INCLUDED")) exit("Access denied");

//require("./config.inc.php");
include $include_path."messages.inc.php";

#// Check if the e-mail has to be sent or not
$emailmode = @mysql_result(@mysql_query("SELECT startemailmode FROM HB_users WHERE id='".$_SESSION['HAPPYBID_LOGGED_IN']."'"),0,"startemailmode");
if($emailmode != 'yes') return;

#// Retrieve user's prefered language
$USERLANG = @mysql_result(@mysql_query("SELECT language FROM HB_userslanguage WHERE user='".$_SESSION['HAPPYBID_LOGGED_IN']."'"),0,"language");
if(!isset($USERLANG)) $USERLANG = $SETTINGS['defaultlanguage'];

$buffer = file($include_path."auctionmail.".$USERLANG.".inc.php");

$i = 0;
$j = 0;
while($i < count($buffer)) {
	if(!ereg("^#(.)*$",$buffer[$i])){
		$skipped_buffer[$j] = $buffer[$i];
		$j++;
	}
	$i++;
}


#// Handle time correction
$ENDS = explode(" ",$a_ends);
//$DATE = explode("-",$ENDS[0]);
$DATE[0] = substr($a_ends,0,4);
$DATE[1] = substr($a_ends,4,2);
$DATE[2] = substr($a_ends,6,2);
$HOUR[0] = substr($a_ends,8,2);
$HOUR[1] = substr($a_ends,10,2);
//$HOUR = explode(":",$ENDS[1]);
$ENDS_DATE = ArrangeDateNoCorrection($DATE[2],$DATE[1],$DATE[0],$HOUR[0],$HOUR[1]);

$message = implode($skipped_buffer,"");


#// #######################################################################
if($FEE > 0)
{
	$query = "SELECT * FROM HB_altpayments";
	$RRR = @mysql_query($query);
	if(@mysql_num_rows($RRR) > 0)
	{
		$ALTPAYMENTS = $MSG_5465.print_money($FEE)."\n".$MSG_5466."\n\n";
		while($row = mysql_fetch_array($RRR))
		{
			$ALTPAYMENTS .= $row["title"]."\n".str_replace("<BR>","\n",$row["description"])."\n\n";
		}
	}
	$message = ereg_replace("<#a_altfeedue#>",$ALTPAYMENTS,$message);
}
else
{
	$message = ereg_replace("<#a_altfeedue#>","",$message);
}
#// #######################################################################


//--Change TAGS with variables content

$message = ereg_replace("<#c_name#>",$userrec["name"],$message);
$message = ereg_replace("<#c_nick#>",$userrec["nick"],$message);
$message = ereg_replace("<#c_address#>",$userrec["address"],$message);
$message = ereg_replace("<#c_city#>",$userrec["city"],$message);
$message = ereg_replace("<#c_country#>",$userrec["country"],$message);
$message = ereg_replace("<#c_zip#>",$userrec["zip"],$message);
$message = ereg_replace("<#c_email#>",$userrec["email"],$message);

if($sessionVars["SELL_atype"] == 1)
{
	$message = ereg_replace("<#a_type#>",$MSG_642,$message);
}
else
{
	$message = ereg_replace("<#a_type#>",$MSG_641,$message);
}

$message = ereg_replace("<#a_buyitnow#>",print_money($buy_now_price),$message);
$message = ereg_replace("<#a_qty#>",$sessionVars["SELL_iquantity"],$message);
$message = ereg_replace("<#a_title#>",$sessionVars["SELL_title"],$message);
$message = ereg_replace("<#a_id#>","'".$auction_id."'",$message);
$message = ereg_replace("<#a_description#>",substr(strip_tags($sessionVars["SELL_description"]),0,50)."...",$message);
$message = ereg_replace("<#a_picturl#>",$pcURL,$message);
$message = ereg_replace("<#a_minbid#>",print_money($sessionVars["SELL_minimum_bid"]),$message);
$message = ereg_replace("<#a_resprice#>",print_money($sessionVars["SELL_reserve_price"]),$message);
$message = ereg_replace("<#a_duration#>",$sessionVars["SELL_duration"],$message);
$message = ereg_replace("<#a_location#>","$location",$message);
$message = ereg_replace("<#a_zip#>",$sessionVars["SELL_location_zip"],$message);
$message = ereg_replace("<#a_url#>","$auction_url",$message);
$message = ereg_replace("<#c_sitename#>",$SETTINGS["sitename"],$message);
$message = ereg_replace("<#c_siteurl#>",$SETTINGS["siteurl"],$message);
$message = ereg_replace("<#c_adminemail#>",$SETTINGS["adminmail"],$message);


if($customincrement > 0)
{
	$message = ereg_replace("<#a_customincrement#>",print_money($sessionVars["SELL_customincrement"]),$message);
}
else
{
	$message = ereg_replace("<#a_customincrement#>",$MSG_614,$message);
}



if($shipping == '1'){

	$shipping_string = $MSG_038;

}else{

	$shipping_string = $MSG_032;

}

$message = ereg_replace("<#a_shipping#>","$shipping_string",$message);



if($international){

	$int_string = $MSG_033;

}else{

	$int_string = $MSG_043;

}

$message = ereg_replace("<#a_intern#>","$int_string",$message);

$message = ereg_replace("<#a_payment#>","$payment_text",$message);

$message = ereg_replace("<#a_category#>",$sessionVars["categoriesList"],$message);

$message = ereg_replace("<#a_ends#>",$ENDS_DATE,$message);
$message = ereg_replace("&nbsp;"," ",$message);


$CHARSET = "utf-8";
$headers = "From: $SETTINGS[sitename] <$SETTINGS[adminmail]>\r\n" . "Reply-To: $SETTINGS[adminmail]\r\n" . "Return-path: $SETTINGS[adminmail]\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=$CHARSET";

mail($userrec["email"],"$MSG_099: ".$sessionVars["SELL_title"],$message,$headers);

?>
