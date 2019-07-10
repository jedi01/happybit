<?

require('../includes/config.inc.php');
include "loggedin.inc.php";
include $include_path.'status.inc.php';

#//
$ERR = "&nbsp;";

if($_POST[action] == "insert" && basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['PHP_SELF']))
{
	if(empty($_POST[username]) ||
	empty($_POST[password]) ||
	empty($_POST[repeatpassword])
	)
	{
		$ERR = $ERR_047;
	}
	elseif((!empty($_POST[password]) && empty($_POST[repeatpassword])) ||
	(empty($_POST[password]) && !empty($_POST[repeatpassword])))
	{
		$ERR = $ERR_054;
	}
	elseif($_POST[password] != $_POST[repeatpassword])
	{
		$ERR = $ERR_006;
	}
	else
	{
		#// Check if "username" already exists in the database
		$query = "select id from HB_adminusers where username='$_POST[username]'";
		$r = @mysql_query($query);
		if(!$r)
		{
			print "Error: $query<BR>".mysql_error();
			exit;
		}
		elseif(mysql_num_rows($r) > 0)
		{
			$ERR = $ERR_055;
		}
		else
		{
			$TODAY = date("Ymd");
			$PASS = md5($MD5_PREFIX.$_POST[password]);
			#// Update
			$query = "INSERT INTO HB_adminusers VALUES (NULL,
												 '".addslashes($_POST[username])."',
												 '$PASS',
												 '$TODAY',
												 '0',
												 ".intval($_POST[status]).")";
			$res = @mysql_query($query);
			if(!$res)
			{
				print "Error: $query<BR>".mysql_error();
				exit;
			}
			else
			{
				Header("Location: adminusers.php");
				exit;
			}
		}
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
          <td width="30"><img src="images/i_use.gif" ></td>
          <td class=white><?=$MSG_25_0010?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_367?></td>
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
	<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#546f95" ALIGN="CENTER">
		<TR>
			<TD ALIGN=CENTER class=title>
				<? print $MSG_367; ?>
			</TD>
		</TR>
		<TR>
		<TD>
		<TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
			<TR>
				<TD COLSPAN="2" ALIGN=CENTER><B>
					<? print $ERR; ?>
					</B></TD>
			</TR>
			<TR>
				<TD WIDTH="129"> 
					<? print $MSG_557; ?>
					</TD>
				<TD WIDTH="405">
					<B>
					<INPUT TYPE="text" NAME="username" SIZE="25" MAXLENGTH="32" VALUE="<?=$_POST[username]?>">
					</B> </TD>
			</TR>
			<TR>
				<TD WIDTH="129">
					<? print $MSG_004; ?>
					</TD>
				<TD WIDTH="405">
					<INPUT TYPE="PASSWORD" NAME="password" SIZE="25">
				</TD>
			</TR>
			<TR>
				<TD WIDTH="129">
					<? print $MSG_564; ?>
					</TD>
				<TD WIDTH="405">
					<INPUT TYPE="PASSWORD" NAME="repeatpassword" SIZE="25">
				</TD>
			</TR>
			<TR>
				<TD WIDTH="129">
					<? print $MSG_565; ?>
					</TD>
				<TD WIDTH="405">
					<INPUT TYPE="radio" NAME="status" VALUE="1"
		<? if($_POST[status] == 1 || empty($_POST[status])) print " CHECKED";?>
		>
					
					<? print $MSG_566; ?>
					
					<INPUT TYPE="radio" NAME="status" VALUE="2"
		<? if($_POST[status] == 2) print " CHECKED";?>
		>
					
					<? print $MSG_567; ?>
					 </TD>
			</TR>
			<TR>
				<TD WIDTH=129>&nbsp;</TD>
				<TD WIDTH="405">&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH=129>
					<INPUT TYPE="hidden" NAME="action" VALUE="insert">
				</TD>
				<TD WIDTH="405">
					<INPUT TYPE="submit" NAME="act" VALUE="<? print $MSG_569; ?>">
				</TD>
			</TR>
			<TR>
				<TD WIDTH=129></TD>
				<TD WIDTH="405"> </TD>
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
