<?
if(!defined('INCLUDED')) exit("Access denied");

#// Retrieve user's prefered language
$USERLANG = @mysql_result(@mysql_query("SELECT language FROM HB_userslanguage WHERE user='".$winner_id."'"),0,"language");
if(!isset($USERLANG)) $USERLANG = $SETTINGS['defaultlanguage'];

$buffer = file($include_path."mail_endauction_youwin.".$USERLANG.".inc.php");
$i = 0;
$j = 0;

while($i < count($buffer)) {
	if(!ereg("^#(.)*$",$buffer[$i])){
		$skipped_buffer[$j] = $buffer[$i];
		$j++;
	}
	$i++;
}

//--Retrieve message

$message = implode($skipped_buffer,"");

//--Change TAGS with variables content
//$message = ereg_replace("<#s_name#>",$Seller['name'],$message);
//$message = ereg_replace("<#s_nick#>",$Seller['nick'],$message);
//$message = ereg_replace("<#s_email#>",$Seller['email'],$message);
//$message = ereg_replace("<#s_payment#>",$Seller['payment_details'],$message);
//$message = ereg_replace("<#s_address#>",$Seller[''],$message);
//$message = ereg_replace("<#s_city#>",$Seller[''],$message);
//$message = ereg_replace("<#s_prov#>",$Seller['prov'],$message);
//$message = ereg_replace("<#s_country#>",$Seller['country'],$message);
//$message = ereg_replace("<#s_zip#>",$Seller['zip'],$message);
//$message = ereg_replace("<#s_phone#>",$Seller['phone'],$message);

$message = ereg_replace("<#w_name#>",$Winner['name'],$message);
$message = ereg_replace("<#w_nick#>",$Winner['nick'],$message);

//$message = ereg_replace("<#i_title#>",$Auction['title'],$message);
//$message = ereg_replace("<#i_currentbid#>",print_money($Auction['current_bid']),$message);
//$message = ereg_replace("<#i_qty#>",$qty,$message);
//$message = ereg_replace("<#i_currentbid#>",print_money($WINNERS_BID[$Winner['current_bid']]),$message);
//$message = ereg_replace("<#i_winningbid#>",print_money($WINNING_BID),$message);
//$message = ereg_replace("<#i_description#>",substr(strip_tags($Auction['description']),0,50)."...",$message);
$auction_url = "$SITE_URL"."item.php?id=".$auction_id;
//$message = ereg_replace("<#i_url#>",$auction_url,$message);
//$message = ereg_replace("<#i_ends#>",$ends_string,$message);
//$message = ereg_replace("<#i_wanted>",$Winner['wanted'],$message);
//$message = str_replace("<#i_got>",$Winner['quantity'],$message);
////print "**".$Winner['quantity']."<BR>";
$message = ereg_replace("<#c_sitename#>",$SETTINGS[sitename],$message);
$message = ereg_replace("<#c_siteurl#>",$SETTINGS[siteurl],$message);
$message = ereg_replace("<#c_adminemail#>",$SETTINGS[adminmail],$message);

mail($Winner["email"],"$MSG_909",stripslashes($message),"From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\n"."Content-Type: text/html; charset=$CHARSET");

?>
