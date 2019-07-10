<?

include "../includes/config.inc.php";
include "loggedin.inc.php";

if(!empty($_POST['subject']) && !empty($_POST['message'])) {
	mail($_POST['email'],$_POST['subject'],$_POST['message'],"From: ".$SETTINGS['sitename']." <".$SETTINGS['adminmail'].">\n"."Content-Type: text/html; charset=$CHARSET");
	$ERR = $MSG_25_0078." ".$_POST['email'];
}
# Retrieve user's information
$query = "SELECT * FROM HB_users WHERE id=".$_REQUEST[id];
$res = @mysql_query($query);
if(!$res) {
	print "Error: $query<BR>".mysql_error();
	exit;
} elseif(@mysql_num_rows($res) > 0) {
	$USER = mysql_fetch_array($res);
	
	# Retrieve e-mail messages
	$query = "SELECT language FROM HB_userslanguage WHERE user=".$_REQUEST[id];
	$res = @mysql_query($query);
	if(@mysql_num_rows($res) > 0) {
		$userlanguage = @mysql_result($res,0,"language");
	} else {
		$userlanguage = "EN";
	}
	$FP = fopen("../includes/usermail.EN.inc.php","r");
	$message = fread($FP,filesize("../includes/usermail.EN.inc.php"));
	fclose($FP);
	$CONFIRMATIONPAGE = $SETTINGS[siteurl]."confirm.php?id=".$_REQUEST[id];
	$message = ereg_replace("<#c_id#>",$USER['id'],$message);
	$message = ereg_replace("<#c_name#>",$USER['name'],$message);
	$message = ereg_replace("<#c_nick#>",$USER['nick'],$message);
	$message = ereg_replace("<#c_address#>",$USER['address'],$message);
	$message = ereg_replace("<#c_city#>",$USER['city'],$message);
	$message = ereg_replace("<#c_prov#>",$USER['prov'],$message);
	$message = ereg_replace("<#c_zip#>",$USER['zip'],$message);
	$message = ereg_replace("<#c_password#>","******",$message);
	$message = ereg_replace("<#c_country#>",$countries[$USER['country']],$message);
	$message = ereg_replace("<#c_phone#>",$USER['phone'],$message);
	$message = ereg_replace("<#c_email#>",$USER['email'],$message);
	$message = ereg_replace("<#c_sitename#>",$SETTINGS[sitename],$message);
	$message = ereg_replace("<#c_siteurl#>",$SETTINGS[siteurl],$message);
	$message = ereg_replace("<#c_adminemail#>",$SETTINGS[adminmail],$message);
	$message = ereg_replace("<#c_confirmation_page#>",$CONFIRMATIONPAGE,$message);
}

?>
<HTML>
<HEAD> 
<link rel='stylesheet' type='text/css' href='style.css' />
<TITLE>Newsletter Admin</TITLE>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="31" background="images/bac_barint.gif">
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr> 
          <td width="30"><img src="images/i_use.gif" ></td>
          <td class=white><?=$MSG_25_0010?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_607?></td>
        </tr>
      	</table>
	</td>
  	</tr>
  	<tr>
    <td align="center" valign="middle">&nbsp;</td>
  	</tr>
    <tr> 
    <td align="center" valign="middle">
		<FORM NAME=newsletter ACTION="<? print basename($PHP_SELF); ?>" METHOD="POST">
		<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#546f95" ALIGN="CENTER">
			<TR>
			<TD ALIGN=CENTER class=title>
			<? print $MSG_25_0075; ?>
			</TD>
			</TR>
			<TR>
			<TD>
				<TABLE WIDTH="100%" BORDER="0" CELLPADDING="5" BGCOLOR="#FFFFFF">
				<?
				if(!empty($ERR))
				{
				?>
					<TR>
					<TD COLSPAN=2 ALIGN=CENTER>
					<? print $ERR; ?>
					</TD>
					</TR>
				<?
				}
				?>
					<TR>
					<TD WIDTH="204" VALIGN="top" ALIGN="right">
					<? print "$MSG_5180"; ?>
					</TD>
					<TD WIDTH="486">
					<B><?=$USER['name']." (".$USER['nick'].")"; ?></B>
					</TD>
					</TR>
					<TR>
					<TD WIDTH="204" VALIGN="top" ALIGN="right">
					<? print "$MSG_400"; ?>
					</TD>
					<TD WIDTH="486">
					<B><?=$USER['email']; ?></B>
					<INPUT TYPE=hidden NAME=email VALUE=<?=$USER['email']?>>
					</TD>
					</TR>
					<TR>
					<TD WIDTH="204" VALIGN="top" ALIGN="right">
					<? print "$MSG_605<BR>($MSG_25_0077)"; ?>
					</TD>
					<TD WIDTH="486">
					<INPUT TYPE=text NAME=subject SIZE=65 VALUE="<?=$MSG_098?>">
					</TD>
					</TR>
					<TR>
					<TD WIDTH="204" VALIGN="top" ALIGN="right">
					<? print "$MSG_605<BR>($MSG_25_0077)"; ?>
					</TD>
					<TD WIDTH="486">
					<TEXTAREA NAME=message COLS=65 ROWS=20><? print $message; ?></TEXTAREA>
					</TD>
					</TR>
					<TR>
					<TD WIDTH="204" VALIGN="top" ALIGN="right"> </TD>
					<TD WIDTH="486">
					<INPUT TYPE=submit NAME=submit VALUE="<?=$MSG_25_0076?>">
					<INPUT TYPE=hidden NAME=id VALUE=<?=$_REQUEST[id]?>>
					</TD>
					</TR>
					</TABLE>
			</TD>
			</TR>
			</TABLE>
			</FORM>
	<br>		
</TD>
</TR>
</TABLE>
</BODY>
</HTML>