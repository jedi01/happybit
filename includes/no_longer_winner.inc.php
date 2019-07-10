<?
if(!defined('INCLUDED')) exit("Access denied");
#// Retrieve user's prefered language
$USERLANG = @mysql_result(@mysql_query("SELECT language FROM HB_userslanguage WHERE user='".$OldWinner_id."'"),0,"language");
if(!isset($USERLANG)) $USERLANG = $SETTINGS['defaultlanguage'];
$buffer = file($include_path."no_longer_winnermail.".$USERLANG.".inc.php");
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
$HOUR = explode(":",$ENDS[4]);

$ENDS_DATE = ArrangeDateNoCorrMesCompleto($ENDS[1],$ENDS[0],$ENDS[2],$HOUR[0],$HOUR[1]);

//--Retrieve message
$message = implode($skipped_buffer,"");
//--Change TAGS with variables content
$message = ereg_replace("<#o_name#>","$OldWinner_name",$message);
$message = ereg_replace("<#o_nick#>","$OldWinner_nick",$message);
$message = ereg_replace("<#o_email#>","$OldWinner_email",$message);
$message = ereg_replace("<#o_bid#>","$OldWinner_bid",$message);
$message = ereg_replace("<#n_bid#>",$new_bid,$message);
$message = ereg_replace("<#i_title#>","$item_title",$message);
$message = ereg_replace("<#i_description#>",substr(strip_tags($item_description),0,50)."...",$message);
$auction_url = "$SITE_URL"."item.php?id=$id";
$message = ereg_replace("<#i_url#>","$auction_url",$message);
$message = ereg_replace("<#i_ends#>","$ENDS_DATE",$message);
$message = ereg_replace("<#c_sitename#>",$SETTINGS[sitename],$message);
$message = ereg_replace("<#c_siteurl#>",$SETTINGS[siteurl],$message);
$message = ereg_replace("<#c_adminemail#>",$SETTINGS[adminmail],$message);
// Remove any &nbsp; that might have beem included in the email. //
// These are added by the print_money() function, but emails are sent  //
// as plain text //
$message = ereg_replace("&nbsp;"," ",$message);

mail($OldWinner_email,"$MSG_906",stripslashes($message),"From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\n"."Content-Type: text/html; charset=$CHARSET");

?>