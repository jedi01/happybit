<?

require('../includes/config.inc.php');
include "loggedin.inc.php";

#//
unset($ERR);

#//
if($_POST[action] == "update" && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF']))
{
	#// Data check
	if(empty($_POST[sitename]) ||
	empty($_POST[siteurl]) ||
	empty($_POST[adminmail]))
	{
		$ERR = $ERR_047;
		$SETTINGS = $_POST;
	}
	else
	{
		#// Update data
		$query = "update HB_settings set
			sitename='".addslashes($_POST[sitename])."',
			adminmail='".addslashes($_POST[adminmail])."',
			g_analytics_enabled='".addslashes($_POST[g_analytics_enabled])."',
			g_analytics_code='".addslashes($_POST[g_analytics_code])."',
			refer_bids='".addslashes($_POST[refer_bids])."',
			bid_ratio='".addslashes($_POST[bid_ratio])."',
			bonus_signup_bids='".addslashes($_POST[bonus_signup_bids])."',
			twitter_enabled='".addslashes($_POST[twitter_enabled])."',
			fb_enabled='".addslashes($_POST[fb_enabled])."',
			twitter_consumer='".addslashes($_POST[twitter_consumer])."',
			twitter_secret='".addslashes($_POST[twitter_secret])."',
			fb_app_id='".addslashes($_POST[fb_app_id])."',
			fb_app_secret='".addslashes($_POST[fb_app_secret])."',
                        publisher_id='".addslashes($_POST[publisher_id])."',
                        api_key='".addslashes($_POST[api_key])."',
                        cpalead_pwd='".addslashes($_POST[cpalead_pwd])."',
                        cpalead_pubid='".addslashes($_POST[cpalead_pubid])."',
                        cpalead_gateway='".addslashes($_POST[cpalead_gateway])."',
                        enable_cpalead='".addslashes($_POST[enable_cpalead])."',
                        enable_adscend='".addslashes($_POST[enable_adscend])."',
                        adscend_test='".addslashes($_POST[adscend_test])."',
			siteurl='".addslashes($_POST[siteurl])."'";
		$res = mysql_query($query);
		if(!$res)
		{
			print "Error: $query<BR>".mysql_error();
			exit;
		}
		else
		{
			$ERR = $MSG_542;
			$SETTINGS = $_POST;
		}
	}
}
else
{
	#//
	$query = "SELECT siteurl,adminmail,sitename,g_analytics_enabled,g_analytics_code,refer_bids,bid_ratio,bonus_signup_bids,twitter_enabled,fb_enabled,twitter_consumer,twitter_secret,fb_app_id,fb_app_secret,publisher_id,api_key,cpalead_pwd,cpalead_pubid,cpalead_gateway,enable_cpalead,enable_adscend,adscend_test FROM HB_settings";
	$res = @mysql_query($query);
	if(!$res)
	{
		print "Error: $query<BR>".mysql_error();
		exit;
	}
	elseif(mysql_num_rows($res) > 0)
	{
		$SETTINGS = mysql_fetch_array($res);
	}
}

?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr> 
          <td width=31><img src="images/i_set.gif" width="21" height="19"></td>
          <td class=white><?=$MSG_25_0007?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_526?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
    <tr> 
    <td align="center" valign="middle">
		<TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
		<TR>
		<TD align="center">
			<BR>
			<FORM NAME=conf ACTION=<?=basename($_SERVER['SCRIPT_NAME'])?> METHOD=POST >
				<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#546f95">
					<TR>
						<TD ALIGN=CENTER class=title>
							<? print $MSG_526; ?>
						</TD>
					</TR>
					<TR>
						<TD>
		
			<TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
			<?
			if(isset($ERR))
			{
			?>
				<TR BGCOLOR=yellow>
				<TD COLSPAN="2" ALIGN=CENTER><B>
				  <? print $ERR; ?>
				  </B></TD>
			  </TR>
			 <?
			}
			 ?>
			  <TR VALIGN="TOP">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? print $MSG_527; ?>
				  </TD>
				<TD WIDTH="365"> 
				  <? print $MSG_535; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="sitename" SIZE="45" MAXLENGTH="255" VALUE="<?=stripslashes($SETTINGS[sitename])?>">
				</TD>
			  </TR>
			  <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? print $MSG_528; ?>
				  </TD>
				<TD WIDTH="365"> 
				  Make sure you include the trailing slash! E.g. http://happybid.com/
				  <BR>
				  <INPUT TYPE="text" NAME="siteurl" SIZE="45" MAXLENGTH="255" VALUE="<?=$SETTINGS[siteurl]?>">
				</TD>
			  </TR>
			  <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				    Admin/contact email address
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  This is used to send automatic e-mails and acts as the 'Contact us' address
				  <BR>
				  <INPUT TYPE="text" NAME="adminmail" SIZE="45" MAXLENGTH="100" VALUE="<?=$SETTINGS[adminmail]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>
		


 <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "Enable Google Analytics tracking?"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "Enter 1 to enable, 0 to disable"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="g_analytics_enabled" SIZE="45" MAXLENGTH="100" VALUE="<?=$SETTINGS[g_analytics_enabled]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>

 <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "Enter Google Analytics ID"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "Something like UA-2453251-1. You must set this up in Analytics and get the code."; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="g_analytics_code" SIZE="45" MAXLENGTH="100" VALUE="<?=$SETTINGS[g_analytics_code]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>

 <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "Number of referral bids received per survey"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "This is the number of bids earned each time a referred member completes a survey"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="refer_bids" SIZE="10" MAXLENGTH="20" VALUE="<?=$SETTINGS[refer_bids]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>

 <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "Set $ to bid ratio. Applies to Adscend Only. "; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "The CPALead ratio is controlled from the widget itself, within CPAlead<br>&nbsp;&nbsp;If using both networks these ratios should match!"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="bid_ratio" SIZE="10" MAXLENGTH="20" VALUE="<?=$SETTINGS[bid_ratio]?>"><br>bids per $1 earned from surveys
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>

 <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/AA6sV.png'> Enable AdscendMedia Earn bids button on Home/Account page?"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "Enter 1 to enable and 0 to disable"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="enable_adscend" SIZE="45" MAXLENGTH="20" VALUE="<?=$SETTINGS[enable_adscend]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>

<TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/Wxp9i.png'> Enable CPALead Earn bids button on Home/Account page?"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "Enter 1 to enable and 0 to disable"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="enable_cpalead" SIZE="45" MAXLENGTH="20" VALUE="<?=$SETTINGS[enable_cpalead]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>

<TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/AA6sV.png'> Enable AdscendMedia test mode?"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "Enter 1 to enable and 0 to disable - put in test mode to test postback without IP restrictions"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="adscend_test" SIZE="45" MAXLENGTH="20" VALUE="<?=$SETTINGS[adscend_test]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>


                        <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/AA6sV.png'> Adscend Media Publisher ID"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "Your Adscend Media publisher ID"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="publisher_id" SIZE="45" MAXLENGTH="20" VALUE="<?=$SETTINGS[publisher_id]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>

                          <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/AA6sV.png'> Adscend Media API Key"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "Your Adscend Media API Key"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="api_key" SIZE="45" MAXLENGTH="20" VALUE="<?=$SETTINGS[api_key]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>


                         <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/Wxp9i.png'> CPA Lead gateway password"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "CPA Lead gateway password"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="cpalead_pwd" SIZE="45" MAXLENGTH="20" VALUE="<?=$SETTINGS[cpalead_pwd]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>

                          <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/Wxp9i.png'> CPA Lead publisher ID"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "CPA Lead publisher ID"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="cpalead_pubid" SIZE="45" MAXLENGTH="20" VALUE="<?=$SETTINGS[cpalead_pubid]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>


                          <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/Wxp9i.png'> CPA Lead gateway ID code"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "It will be something like MzYzNTM%3D - make sure <strong>you don't</strong> add the single quotes!"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="cpalead_gateway" SIZE="45" MAXLENGTH="20" VALUE="<?=$SETTINGS[cpalead_gateway]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>
			  
			       <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/w113S.png'> Bonus bids credited on signup"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "Number of credits a new user receives when signing up"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="bonus_signup_bids" SIZE="45" MAXLENGTH="20" VALUE="<?=$SETTINGS[bonus_signup_bids]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>
			  
			  
			  
			  	  		       <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/6LvBi.png'> Enable Twitter Login?"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "Enter 0 to disable, 1 to enable."; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="twitter_enabled" SIZE="10" MAXLENGTH="20" VALUE="<?=$SETTINGS[twitter_enabled]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>
			  
			  		       <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/6LvBi.png'> Twitter Consumer Key"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "Twitter Consumer Key - from https://dev.twitter.com"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="twitter_consumer" SIZE="45" MAXLENGTH="100" VALUE="<?=$SETTINGS[twitter_consumer]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>
			  
			  		       <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/6LvBi.png'> Twitter Secret Key"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "Twitter Secret Key - from https://dev.twitter.com"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="twitter_secret" SIZE="45" MAXLENGTH="100" VALUE="<?=$SETTINGS[twitter_secret]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>
			  
			       <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/kdG7U.gif'> Enable Facebook Login?"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "Enter 0 to disable, 1 to enable."; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="fb_enabled" SIZE="10" MAXLENGTH="1" VALUE="<?=$SETTINGS[fb_enabled]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>
			  
			  
			  	       <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/kdG7U.gif'> Facebook App ID"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "Facebook App ID - from https://developers.facebook.com/apps"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="fb_app_id" SIZE="45" MAXLENGTH="40" VALUE="<?=$SETTINGS[fb_app_id]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>
			  
			  	       <TR VALIGN="TOP" bgcolor="eeeeee">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR VALIGN="TOP">
				<TD WIDTH=169>
				  <? echo "<img src='http://i.imgur.com/kdG7U.gif'> Facebook App Secret"; ?>
				  </TD>
				<TD WIDTH="365"> &nbsp;
				   
				  <? echo "Facebook App Secret - from https://developers.facebook.com/apps"; ?>
				  <BR>
				  <INPUT TYPE="text" NAME="fb_app_secret" SIZE="45" MAXLENGTH="100" VALUE="<?=$SETTINGS[fb_app_secret]?>">
				  &nbsp;
				   &nbsp;
				  </TD>
			  </TR>
			  
			 			  
			  <TR VALIGN="TOP">
				<TD COLSPAN="2"></TD>
			  </TR>
			  <TR>
				<TD WIDTH=169>
				  <INPUT TYPE="hidden" NAME="action" VALUE="update">
				</TD>
				<TD WIDTH="365">
				  <INPUT TYPE="submit" NAME="act" VALUE="<? print $MSG_530; ?>">
				</TD>
			  </TR>
			  <TR>
				<TD WIDTH=169></TD>
				<TD WIDTH="365"> </TD>
			  </TR>
			</TABLE>
						</TD>
					</TR>
				</TABLE>
			</FORM>
		</TD>
		</TR>
		</TABLE>
	</TD>
	</TR>
	</TABLE>
</BODY>
</HTML>