<?
require('../includes/config.inc.php');
include "loggedin.inc.php";

unset($ERR);

#//
if($_POST[action] == "update" && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF']))
{
	#// Update database
	$query = "update HB_settings SET
				  terms='$_POST[terms]',
				  termstext='".nl2br(addslashes($_POST[termstext]))."'";
	//print $query;
	$res = mysql_query($query);
	if(!$res)
	{
		print "Error: $query<BR>".mysql_error();
		exit;
	}
	else
	{
		$ERR = $MSG_5084;
		$SETTINGS = $_POST;
	}
}
else
{
	#//
	$query = "SELECT terms,termstext FROM HB_settings";
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr> 
          <td width="30"><img src="images/i_con.gif" ></td>
          <td class=white><?=$MSG_25_0018?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_5075?></td>
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
			<TD ALIGN=CENTER class=title>
				<? print $MSG_5075; ?>
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
	<TD WIDTH=109 HEIGHT="22">
	  <?=$MSG_5082?></TD>
	<TD WIDTH="375" HEIGHT="22">
	  <?=$MSG_5081?><BR>
	  <INPUT TYPE="radio" NAME="terms" VALUE="y" <?if($SETTINGS[terms] == "y") print " CHECKED"?>>
	  <? print $MSG_030; ?>
	  <INPUT TYPE="radio" NAME="terms" VALUE="n" <?if($SETTINGS[terms] == "n") print " CHECKED"?>>
	  <? print $MSG_029; ?>
	  </TD>
  </TR>
  <TR VALIGN="TOP">
	<TD WIDTH=109 HEIGHT="22">
	  <? print $MSG_5083; ?>
	  </TD>
	<TD WIDTH="375" HEIGHT="22">
	 
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
	  <textarea name="termstext" cols="90"
	  rows="15"><?=stripslashes(str_replace("<br />","",stripslashes($SETTINGS[termstext])))?></textarea>
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
