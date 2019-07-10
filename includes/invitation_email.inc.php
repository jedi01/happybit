<?
if(!defined('INCLUDED')) exit("Access denied");


#// Get the preferred langauge for the user
$USERLANG = @mysql_result(@mysql_query("SELECT language FROM HB_userslanguage WHERE user='".$user[buyer_id]."'"),0,"language");
if(empty($USERLANG)) $USERLANG = $SETTINGS['defaultlanguage'];

$buffer = file($include_path."invitationmail.".$USERLANG.".inc.php");

$i = 0;

$j = 0;

while($i < count($buffer)){

	if(!ereg("^#(.)*$",$buffer[$i])){

		$skipped_buffer[$j] = $buffer[$i];

		$j++;

	}

	$i++;

}

//--Retrieve message

$message = implode($skipped_buffer,"");


//--Change TAGS with variables content

$message = ereg_replace("<#b_name#>","$BUYER_NAME",$message);


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


$message = ereg_replace("<#a_qty#>",$sessionVars["SELL_iquantity"],$message);
$message = ereg_replace("<#a_title#>",$sessionVars["SELL_title"],$message);
$message = ereg_replace("<#a_id#>",$sessionVars["SELL_auction_id"],$message);
$message = ereg_replace("<#a_description#>",$sessionVars["SELL_description"],$message);
$message = ereg_replace("<#a_picturl#>","$pict_url",$message);
$message = ereg_replace("<#a_minbid#>",print_money($sessionVars["SELL_minimum_bid"]),$message);
$message = ereg_replace("<#a_resprice#>",print_money($sessionVars["SELL_reserve_price"]),$message);
$message = ereg_replace("<#a_duration#>",$sessionVars["SELL_duration"],$message);
$message = ereg_replace("<#a_location#>","$location",$message);
$message = ereg_replace("<#a_zip#>",$sessionVars["SELL_location_zip"],$message);
$message = ereg_replace("<#a_url#>",$SETTINGS["siteurl"]."item.php?id=".$sessionVars["SELL_auction_id"],$message);
$message = ereg_replace("<#c_sitename#>",$SETTINGS["sitename"],$message);
$message = ereg_replace("<#c_siteurl#>",$SETTINGS["siteurl"],$message);
$message = ereg_replace("<#c_adminemail#>",$SETTINGS["adminmail"],$message);                    	


if($sessionVars["SELL_customincrement"] > 0)
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

$pay_names_list = ereg_replace("@","\n",$payment_names);

$message = ereg_replace("<#a_payment#>","$pay_names_list",$message);

$message = ereg_replace("<#a_category#>","$sessionVars[categoriesList]",$message);

$message = ereg_replace("<#a_subcategory#>","$sub_name",$message);

$message = ereg_replace("<#a_ends#>","$a_ends",$message);
$message = ereg_replace("&nbsp;"," ",$message);

mail($BUYER_EMAIL,"$MSG_5196",$message,"From:$SETTINGS[sitename] <$SETTINGS[adminmail]>\n"."Content-Type: text/html; charset=$CHARSET");
?>
