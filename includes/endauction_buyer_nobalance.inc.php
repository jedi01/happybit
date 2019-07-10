<?
if(!defined('INCLUDED')) exit("Access denied");


#// Retrieve user's prefered language
$USERLANG = @mysql_result(@mysql_query("SELECT language FROM HB_userslanguage WHERE user='".$Winner['id']."'"),0,"language");
if(!isset($USERLANG)) $USERLANG = $SETTINGS['defaultlanguage'];


$buffer = file($include_path."mail_endauction_buyers_nofee.".$USERLANG.".inc.php");

$i = 0;
$j = 0;

while($i < count($buffer))
{
	if(!ereg("^#(.)*$",$buffer[$i]))
	{
			$skipped_buffer[$j] = $buffer[$i];
			$j++;
	}
	$i++;
}

#// Handle time correction
$ENDS = explode(" ",$ends_string);
//$DATE = explode("-",$ENDS[0]);
$HOUR = explode(":",$ENDS[3]);
$ENDS_DATE = ArrangeDateNoCorrMesCompleto($ENDS[1],$ENDS[0],$ENDS[2],$HOUR[0],$HOUR[1]);


//--Reteve message

$message = implode($skipped_buffer,"");

//--Change TAGS with variables content

$message = ereg_replace("<#s_name#>",$Seller['name'],$message);
$message = ereg_replace("<#s_nick#>",$Seller['nick'],$message);
$message = ereg_replace("<#s_email#>",$Seller['email'],$message);
$message = ereg_replace("<#s_address#>",$Seller[''],$message);
$message = ereg_replace("<#s_city#>",$Seller[''],$message);
$message = ereg_replace("<#s_prov#>",$Seller['prov'],$message);
$message = ereg_replace("<#s_country#>",$Seller['country'],$message);
$message = ereg_replace("<#s_zip#>",$Seller['zip'],$message);
$message = ereg_replace("<#s_phone#>",$Seller['phone'],$message);

$message = ereg_replace("<#w_report#>",$report_text,$message);
$message = ereg_replace("<#w_name#>",$Winner['name'],$message);
$message = ereg_replace("<#w_nick#>",$Winner['nick'],$message);

$message = ereg_replace("<#i_title#>",$Auction['title'],$message);
$message = ereg_replace("<#i_currentbid#>",print_money($Auction['current_bid']),$message);
$message = ereg_replace("<#i_description#>",substr(strip_tags($Auction['description']),0,50)."...",$message);
$message = ereg_replace("<#i_qty#>",$Auction['quantity'],$message);
$auction_url = "$SITE_URL"."item.php?id=".$Auction['id'];
$message = ereg_replace("<#i_url#>",$auction_url,$message);
$message = ereg_replace("<#i_ends#>",$ENDS_DATE,$message);

$message = ereg_replace("<#c_sitename#>",$SETTINGS[sitename],$message);
$message = ereg_replace("<#c_siteurl#>",$SETTINGS[siteurl],$message);
$message = ereg_replace("<#c_adminemail#>",$SETTINGS[adminmail],$message);

mail($Winner["email"],"$MSG_909",stripslashes($message),"From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\n"."Content-Type: text/html; charset=$CHARSET");

?>