<?php

require("../includes/config.inc.php");
include("loggedin.inc.php");
include($include_path . "status.inc.php");
$ERR = "&nbsp;";
if (is_array($_POST[delete]) && basename($_SERVER["HTTP_REFERER"]) == basename($_SERVER["PHP_SELF"])) {
	while (list($k, $v) = each($_POST[delete])) {
		@mysql_query("" . "delete from HB_adminusers where id=" . $k);
	}
}
$query = "SELECT * FROM HB_adminusers order by username";
$res = @mysql_query($query);
if (!$res) {
	print("" . "Error: " . $query . "<BR>" . mysql_error());
	exit();
}
echo("<HTML>\n<HEAD>\n<link rel='stylesheet' type='text/css' href='style.css' />\n</HEAD>\n<body bgcolor=\"#FFFFFF\" text=\"#000000\" link=\"#0066FF\" vlink=\"#666666\" alink=\"#000066\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">\n<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n  <tr> \n    <td background=\"images/bac_barint.gif\"><table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\">\n");
echo("        <tr> \n          <td width=\"30\"><img src=\"images/i_use.gif\" ></td>\n          <td class=white>");
echo($MSG_25_0010);
echo("&nbsp;&gt;&gt;&nbsp;");
echo($MSG_525);
echo("</td>\n        </tr>\n      </table></td>\n  </tr>\n  <tr>\n    <td align=\"center\" valign=\"middle\">&nbsp;</td>\n  </tr>\n    <tr> \n    <td align=\"center\" valign=\"middle\">\n<TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR=\"#FFFFFF\">\n<TR>\n<TD>\n<CENTER>\n<BR>\n<FORM NAME=conf ACTION=");
echo(basename($_SERVER["PHP_SELF"]));
echo(" METHOD=POST>\n<TABLE WIDTH=\"95%\" BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"1\" BGCOLOR=\"#546f95\" ALIGN=\"CENTER\">\n<TR>\n<TD ALIGN=CENTER class=title>\n");
print($MSG_525);
echo("</TD>\n</TR>\n<TR>\n<TD>\n<TABLE WIDTH=100% CELLPADDING=2 ALIGN=\"CENTER\" BGCOLOR=\"#FFFFFF\">\n<TR>\n<TD COLSPAN=\"2\"><A HREF=\"./increments.php\">\n</A>\n<TABLE WIDTH=\"100%\" BORDER=\"0\" CELLSPACING=\"1\" CELLPADDING=\"2\">\n<TR BGCOLOR=\"#EEEEEE\">\n\t\t<TD COLSPAN=\"5\" ALIGN=CENTER><A HREF=newadminuser.php>");
echo($MSG_568);
echo("</A></TD>\n</TR>\n<TR BGCOLOR=\"#999999\">\n\t\t<TD WIDTH=\"30%\">\n\t\t\t\t<CENTER>\n\t\t\t\t\t<B>\n\t\t\t\t\t");
print($MSG_557);
echo("\t\t\t\t\t</B>\n\t\t\t\t</CENTER>\n\t\t</TD>\n\t\t<TD WIDTH=\"16%\">\n\t\t\t\t<CENTER>\n\t\t\t\t\t<B>\n\t\t\t\t\t");
print($MSG_558);
echo("\t\t\t\t\t</B>\n\t\t\t\t</CENTER>\n\t\t</TD>\n\t\t<TD WIDTH=\"19%\">\n\t\t\t\t<CENTER>\n\t\t\t\t\t<B>\n\t\t\t\t\t");
print($MSG_559);
echo("\t\t\t\t\t</B>\n\t\t\t\t</CENTER>\n\t\t</TD>\n\t\t<TD WIDTH=\"12%\">\n\t\t\t\t<CENTER>\n\t\t\t\t\t<B>\n\t\t\t\t\t");
print($MSG_560);
echo("\t\t\t\t\t</B>\n\t\t\t\t</CENTER>\n\t\t</TD>\n\t\t<TD WIDTH=\"23%\">\n\t\t\t\t<CENTER>\n\t\t\t\t\t<B>\n\t\t\t\t\t<INPUT TYPE=\"submit\" NAME=\"Submit\" VALUE=\"");
echo($MSG_561);
echo("\">\n\t\t\t\t\t</B>\n\t\t\t\t</CENTER>\n\t\t</TD>\n</TR>\n");
while ($USER = mysql_fetch_array($res)) {
	$CREATED = substr($USER[created], 4, 2) . "/" . substr($USER[created], 6, 2) . "/" . substr($USER[created], 0, 4);
	if ($USER[lastlogin] == 0) {
		$LASTLOGIN = $MSG_570;
	}
	else {
		$LASTLOGIN = substr($USER[lastlogin], 4, 2) . "/" . substr($USER[lastlogin], 6, 2) . "/" . substr($USER[lastlogin], 0, 4) . " " . substr($USER[lastlogin], 8, 2) . ":" . substr($USER[lastlogin], 10, 2) . ":" . substr($USER[lastlogin], 12, 2);
	}
	echo("<TR BGCOLOR=\"#EEEEEE\">\n\t\t<TD WIDTH=\"30%\">\n\t\t\t\t<A HREF=editadminuser.php?id=");
	echo($USER[id]);
	echo(">\n\t\t\t\t");
	echo($USER[username]);
	echo("\t\t\t\t</A></TD>\n\t\t<TD WIDTH=\"16%\" ALIGN=CENTER>\n\t\t\t\t");
	echo($CREATED);
	echo("\t\t\t\t</TD>\n\t\t<TD WIDTH=\"19%\" ALIGN=CENTER>\n\t\t\t\t");
	echo($LASTLOGIN);
	echo("\t\t\t\t</TD>\n\t\t<TD WIDTH=\"12%\" ALIGN=CENTER>\n\t\t\t\t");
	echo($STATUS[$USER[status]]);
	echo("\t\t\t\t</TD>\n\t\t<TD WIDTH=\"23%\">\n\t\t\t\t<CENTER>\n\t\t\t\t<INPUT TYPE=\"checkbox\" NAME=\"delete[");
	echo($USER[id]);
	echo("]\" VALUE=\"");
	echo($USER[id]);
	echo("\">\n\t\t\t\t</CENTER>\n\t\t</TD>\n</TR>\n");
}
echo("</TABLE>\n<A HREF=\"./increments.php\" CLASS=\"links\">\n</A></TD>\n</TR>\n<TR>\n<TD WIDTH=169>\n<INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"update\">\n</TD>\n<TD WIDTH=\"365\">&nbsp; </TD>\n</TR>\n<TR>\n<TD WIDTH=169></TD>\n<TD WIDTH=\"365\"> </TD>\n</TR>\n</TABLE>\n</TD>\n</TR>\n</TABLE>\n</FORM>\n</TD>\n</TR>\n</TABLE>\n</TD>\n</TR>\n</TABLE>\n</BODY>\n</HTML>");

