<?
require('../includes/config.inc.php');
include "loggedin.inc.php";


unset($ERR);

#//
if($_POST[action] == "update" && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF']))
{
	#// Update database
	$query = "update HB_settings set
				  datesformat='$_POST[datesformat]'";
	$res = @mysql_query($query);
	if(!$res)
	{
		print "Error: $query<BR>".mysql_error();
		exit;
	}
	else
	{
		$ERR = $MSG_384;
		$SETTINGS = $_POST;
	}
}
else
{
	#//
	$query = "SELECT * FROM HB_settings";
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
          <td width="30"><img src="images/i_pre.gif" width="16" height="19"></td>
          <td class=white><?=$MSG_25_0008?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_363?></font></td>
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
	<FORM NAME=conf ACTION=<?=basename($_SERVER['PHP_SELF'])?> METHOD=POST>
		<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#546f95">
			<TR>
				<TD ALIGN=CENTER><FONT COLOR=#FFFFFF FACE="Verdana, Arial, Helvetica, sans-serif" SIZE="4"><B>
					<? print $MSG_363; ?>
					</B></FONT></TD>
			</TR>
			<TR>
				<TD>
					<TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
					<?
					if(isset($ERR))
					{
					?>
						<TR bgcolor=yellow>
							<TD COLSPAN="2" ALIGN=CENTER><B><FONT FACE="Verdana, Arial, Helvetica, sans-serif" SIZE="2" COLOR="#FF0000"></FONT></B>
								<B><FONT FACE="Verdana, Arial, Helvetica, sans-serif" SIZE="2" COLOR="#FF0000">
								<?=$ERR?>
								</FONT> </B></TD>
						</TR>
					<?
					}
					?>
						<TR VALIGN="TOP">
							<TD WIDTH=109>&nbsp;</TD>
							<TD WIDTH="375">
								<? print $MSG_379; ?>
							</TD>
						</TR>
						<TR VALIGN="TOP">
							<TD WIDTH=109 HEIGHT="22">
								<? print $MSG_380; ?>
								</FONT></TD>
							<TD WIDTH="375" HEIGHT="22">
								<INPUT TYPE="radio" NAME="datesformat" VALUE="USA" <?if($SETTINGS[datesformat] == "USA") print " CHECKED"?>>
								<? print $MSG_382; ?>
								</TD>
						</TR>
						<TR VALIGN="TOP">
							<TD WIDTH=109 HEIGHT="22">
								<? print $MSG_381; ?>
								</TD>
							<TD WIDTH="375" HEIGHT="22">
								<INPUT TYPE="radio" NAME="datesformat" VALUE="EUR" <?if($SETTINGS[datesformat] == "EUR") print " CHECKED"?>>
								<? print $MSG_383; ?>
								</TD>
						</TR>
						<TR VALIGN="TOP">
							<TD WIDTH=109 HEIGHT="22">&nbsp;</TD>
							<TD WIDTH="375" HEIGHT="22">&nbsp;</TD>
						</TR>
						<TR>
							<TD WIDTH=109>
								<INPUT TYPE="hidden" NAME="action" VALUE="update">
							</TD>
							<TD WIDTH="375">
								<INPUT TYPE="submit" NAME="act" VALUE="<? print $MSG_530; ?>">
							</TD>
						</TR>
						<TR>
							<TD WIDTH=109></TD>
							<TD WIDTH="375"> </TD>
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