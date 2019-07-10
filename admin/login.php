<?php


include "../includes/config.inc.php";
if ($_POST["act"] == "insert" && basename($_SERVER["HTTP_REFERER"]) == basename($_SERVER["PHP_SELF"]))
{
	$RR = mysql_query("SELECT id from HB_adminusers");
	if (mysql_num_rows($RR) > 0)
	{
		print "Fatal error: user cannot be inserted - one or more administrators are already present in the database.<BR><A HREF=login.php>login page</A>";
		exit();
	}
	$md5_pass = md5($MD5_PREFIX . $_POST["password"]);
	$query = '' . "insert into HB_adminusers values (10,'" . $_POST["username"] . "', '" . $md5_pass . "', '20011224', '20020110093458', 1)";
	$result = mysql_query($query);
	header("Location: login.php");
	exit();
}
$query = "select MAX(id) from HB_adminusers";
$result = mysql_query($query);
while ($row = mysql_fetch_row($result))
{
	$id = $row[0] + 1;
	continue;
}
echo "<HTML>
<HEAD>
<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\" />
</HEAD>
<BODY>
";
if ($id == 1)
{
	$id = 0;
	echo "<TABLE BORDER=0 WIDTH=650 CELLPADDING=0 CELLSPACING=0 BGCOLOR=\"#FFFFFF\" ALIGN=\"CENTER\">
	<TR>
		<TD><CENTER><BR><BR>
			<FORM NAME=login ACTION=login.php METHOD=POST>
			<TABLE WIDTH=\"410\" BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"1\" BGCOLOR=\"#336699\">
			<TR>
				<TD>
					<TABLE WIDTH=100% CELLPADDING=3 ALIGN=\"CENTER\" CELLSPACING=\"0\" BORDER=\"0\" BGCOLOR=\"#FFFFFF\">
					<TR BGCOLOR=\"#336699\">
						<TD COLSPAN=\"";
	echo "2\" ALIGN=CENTER>
							<FONT COLOR=white><B>:: Please create your username and password ::</B></FONT>
						</TD>
					</TR>
					<TR>
						<TD></TD>
						<TD> <FONT COLOR=red>
						";
	print $ERR;
	echo "						</TD>
					</TR>
					<TR>
						<TD ALIGN=right> 
							";
	print $MSG_003;
	echo "						</TD>
						<TD>
							<INPUT TYPE=TEXT NAME=username SIZE=20 >
						</TD>
					</TR>
					<TR>
						<TD ALIGN=right> 
							";
	print $MSG_004;
	echo "						</TD>
						<TD>
							<INPUT TYPE=password NAME=password SIZE=20 >
						</TD>
					</TR>
					<TR>
						<TD></TD>
						<TD>
							<INPUT TYPE=\"submit\" NAME=\"act\"ion VALUE=\"insert\">
						</TD>
					</TR>
					</TABLE>
				</TD>
			</TR>
			</TABLE>
			</FORM>
			</CENTER>
		</TD>
	</TR>
	</TABLE>
";
}
 else 
{
	$id = 1;
	if ($_POST[action] == "login")
	{
		if (strlen($_POST[username]) == 0 || strlen($_POST[password]) == 0)
		{
			$ERR = $ERR_047;
		}
		 else 
		{
			$query = '' . "select * from HB_adminusers where username='" . $_POST["username"] . "' and password='" . md5($MD5_PREFIX . $_POST[password]) . "'";
			$res = mysql_query($query);
			if (!$res)
			{
				print '' . "Error: " . $query . "<BR>" . mysql_error();
				exit();
			}
			if (mysql_num_rows($res) == 0)
			{
				$ERR = $ERR_048;
			}
			 else 
			{
				$admin = mysql_fetch_array($res);
				$HAPPYBID_ADMIN_LOGIN = $admin[id];
				$HAPPYBID_ADMIN_USER = $admin[username];
				$_SESSION["HAPPYBID_ADMIN_LOGIN"] = $HAPPYBID_ADMIN_LOGIN;
				$_SESSION["HAPPYBID_ADMIN_USER"] = $HAPPYBID_ADMIN_USER;
				$query = "update HB_adminusers set lastlogin='" . date("YmdHis") . ('' . "' where username='" . $admin["username"] . "'");
				$rr = mysql_query($query);
				if (!$rr)
				{
					print '' . "Error: " . $query . "<BR>" . mysql_error();
					exit();
				}
				print "<SCRIPT Language=Javascript>
						parent.location.href='admin2.php';
						</SCRIPT>";
				exit();
			}
		}
	}
	echo "<TABLE BORDER=0 WIDTH=650 CELLPADDING=0 CELLSPACING=0 BGCOLOR=\"#FFFFFF\" ALIGN=\"CENTER\">
<TR>
	<TD>
		<CENTER>
		<BR><BR>
";
	if (!$act || $act && $ERR)
	{
		echo "		<FORM NAME=login ACTION=login.php METHOD=POST>
		<TABLE WIDTH=\"415\" BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"1\" BGCOLOR=\"#CCCCCC\">
		<TR>
			<TD>
				<TABLE WIDTH=100% CELLPADDING=4 ALIGN=\"CENTER\" CELLSPACING=\"0\" BORDER=\"0\" BGCOLOR=\"#FFFFFF\">
				<TR BGCOLOR=\"#DDDDDD\">
					<TD COLSPAN=\"2\" ALIGN=CENTER>
						<B>:: LOGIN ::</B>
					</TD>
				</TR>
				<TR>
		";
		echo "			<TD></TD>
					<TD>
						<FONT COLOR=red>";
		print $ERR;
		echo "					</TD>
				</TR>
				<TR>
					<TD ALIGN=right> 
						";
		print $MSG_003;
		echo "					</TD>
					<TD>
						<INPUT TYPE=TEXT NAME=username SIZE=20 class=adminfield >
					</TD>
				</TR>
				<TR>
					<TD ALIGN=right>
						";
		print $MSG_004;
		echo "					</TD>
					<TD>
						<INPUT TYPE=password NAME=password SIZE=20 class=adminfield >
					</TD>
				</TR>

				<TR>
					<TD></TD>
					<TD>
						<INPUT TYPE=\"submit\" NAME=\"action\" VALUE=\"login\" class=\"buttonadminblue\">
					</TD>
				</TR>
				</TABLE>
			</TD>
		</TR>
		</TABLE>
		</FORM>
";
	}
	echo "		
		</CENTER>
	</TD>
</TR>
</TABLE>
";
}
include "./footer.php";
