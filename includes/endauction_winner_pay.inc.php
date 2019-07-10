<?#//v.3.1.1
if(!defined('INCLUDED')) exit("Access denied");

#// Check if the e-mail has to be sent or not
$emailmode = $USERLANG = @mysql_result(@mysql_query("SELECT endemailmode FROM HB_users WHERE id='".$Seller['id']."'"),0,"endemailmode");
if($emailmode != 'one') return;

#// Retrieve user's prefered language
$USERLANG = @mysql_result(@mysql_query("SELECT language FROM HB_userslanguage WHERE user='".$Seller['id']."'"),0,"language");
if(!isset($USERLANG)) $USERLANG = $SETTINGS['defaultlanguage'];

$buffer = file($include_path."mail_endauction_winner_pay.".$USERLANG.".inc.php");

$i = 0;

$j = 0;

while($i < count($buffer)){

	if(!ereg("^#(.)*$",$buffer[$i])){

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

$message = ereg_replace("<#i_title#>",$Auction['title'],$message);
$message = ereg_replace("<#i_currentbid#>",print_money($Auction['current_bid']),$message);
$auction_url = "$SITE_URL"."item.php?id=".$Auction['id'];
$message = ereg_replace("<#i_url#>",$auction_url,$message);

$message = ereg_replace("<#c_sitename#>",$SETTINGS[sitename],$message);
$message = ereg_replace("<#c_siteurl#>",$SETTINGS[siteurl],$message);
$message = ereg_replace("<#c_adminemail#>",$SETTINGS[adminmail],$message);

mail($Seller["email"],"$MSG_112 $MSG_907: ".$Auction['title'],stripslashes($message),"From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\n"."Content-Type: text/html; charset=$CHARSET");

?>
