<?
require('../includes/config.inc.php');
include "loggedin.inc.php";

unset($ERR);

#//
if($_POST[action] == "update" && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF']))
{
	#// Data check
	if($_POST[https] == 'yes' && empty($_POST[httpsurl])) {
		$ERR = $ERR_047;
		$SETTINGS = $_POST;
	} else {
		#// Update database
		$query = "update HB_https SET
							 https='$_POST[https]',
							 httpsurl='$_POST[httpsurl]'";
		$res = @mysql_query($query);
		if(!$res) {
			print "Error: $query<BR>".mysql_error();
			exit;
		} else {
			$ERR = $MSG_1054;
			$SETTINGS = $_POST;
		}
	}
} else {
	#//
	$query = "SELECT * FROM HB_https";
	$res = @mysql_query($query);
	if(!$res) {
		print "Error: $query<BR>".mysql_error();
		exit;
	} elseif(mysql_num_rows($res) > 0) {
		$SETTINGS = mysql_fetch_array($res);
	}
}

?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<SCRIPT Language=Javascript>

function window_open(pagina,titulo,ancho,largo,x,y){
	var Ventana= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;
	open(pagina,titulo,Ventana);
}
</SCRIPT>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr> 
          <td width="30"><img src="images/i_set.gif" width="21" height="19"></td>
          <td class_white><?=$MSG_25_0007?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_1050?></td>
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
					<?=$MSG_1050?>
				</TD>
			</TR>
			<TR>
				<TD>

	<TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
	<?
	if(isset($ERR)) {
	?>
		<TR BGCOLOR=yellow>
		<TD COLSPAN="2" ALIGN=CENTER><B>
		  <? print $ERR; ?>
		  </B></TD>
	  </TR>
	 <?
	}
	 ?>
	  <tr valign="TOP">
		<td width=123 height="31">
		  <?=$MSG_1050?></td>
		<td height="31" width="509">
		<?=$MSG_1051?>
		<br>
		  <input type="radio" name="https" value="yes"
		  <? if($SETTINGS[https] == 'yes' || empty($SETTINGS[https])) PRINT " CHECKED"; ?>
		  >
		  <?=$MSG_030?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <input type="radio" name="https" value="no"
		  <? if($SETTINGS[https] == 'no') PRINT " CHECKED"; ?>
		  >
		  <?=$MSG_029?>
		</td>
	  </tr>
	  <tr valign="TOP">
		<td colspan="2" height="7"><img src="../images/transparent.gif" width="1" height="5"></td>
	  </tr>
	  <tr valign="TOP">
		<td width=123 height="31">
		  <?=$MSG_1052?></td>
		<td height="31" width="509">
		 <?=$MSG_1053?><BR>
		 <?=$MSG_1055?><BR><br>
		  <input type=text name=httpsurl size=45 maxlength="255" VALUE="<?=$SETTINGS[httpsurl]?>">
		</td>
	  </tr>
	  <tr valign="TOP">
		<td colspan="2" height="7"><img src="../images/transparent.gif" width="1" height="5"></td>
	  </tr>
	  <TR VALIGN="TOP">
		<TD COLSPAN="2" HEIGHT="4"><IMG SRC="../images/transparent.gif" WIDTH="1" HEIGHT="5"></TD>
	  </TR>
	  <TR>
		<TD WIDTH=123>
		  <INPUT TYPE="hidden" NAME="action" VALUE="update">
		</TD>
		<TD WIDTH="509">
		  <INPUT TYPE="submit" NAME="act" VALUE="<? print $MSG_530; ?>">
		</TD>
	  </TR>
	  <TR>
		<TD WIDTH=123></TD>
		<TD WIDTH="509"> </TD>
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
