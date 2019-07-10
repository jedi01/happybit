<?php

require("../includes/config.inc.php");
include("loggedin.inc.php");
include($include_path . "fonts.inc.php");
$ERR = "";
if ($_POST[action] == "update" && basename($_SERVER["HTTP_REFERER"]) == basename($_SERVER["PHP_SELF"])) {
	$query = "" . " UPDATE HB_settings SET\n\t\t\t\t   showacceptancetext=" . $_POST["showacceptancetext"] . ",\n\t\t\t\t   acceptancetext='" . addslashes($_POST[acceptancetext]) . "'";
	$res_ = @mysql_query($query);
	if (!$res_) {
		print("" . "Error: " . $query . "<BR>" . mysql_error());
		exit();
	}
	else {
		$SETTINGS = $_POST;
		$ERR = $MSG_25_0111;
	}
}
$query = "SELECT * FROM HB_settings";
$res = @mysql_query($query);
if (!$res) {
	print("" . "Error: " . $query . "<BR>" . mysql_error());
	exit();
}
else {
	if (0 < mysql_num_rows($res)) {
		$SETTINGS = mysql_fetch_array($res);
	}
}
echo("<HTML>\n<HEAD>\n<link rel='stylesheet' type='text/css' href='style.css' />\n</HEAD>\n<body bgcolor=\"#FFFFFF\" text=\"#000000\" link=\"#0066FF\" vlink=\"#666666\" alink=\"#000066\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">\n<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n  <tr> \n    <td background=\"images/bac_barint.gif\"><table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\">\n");
echo("        <tr> \n          <td width=\"30\"><img src=\"images/i_use.gif\"></td>\n          <td class=white>");
echo($MSG_25_0010);
echo("&nbsp;&gt;&gt;&nbsp;");
echo($MSG_25_0110);
echo("</td>\n        </tr>\n      </table></td>\n  </tr>\n  <tr>\n    <td align=\"center\" valign=\"middle\">&nbsp;</td>\n  </tr>\n    <tr> \n    <td align=\"center\" valign=\"middle\">\n<TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR=\"#FFFFFF\">\n<TR>\n<TD align=\"center\">\n<BR>\n<FORM NAME=conf ACTION=\"");
echo(basename($_SERVER["PHP_SELF"]));
echo("\" METHOD=\"POST\"  ENCTYPE=\"multipart/form-data\">\n\t<TABLE WIDTH=\"95%\" BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"1\" BGCOLOR=\"#546f95\">\n\t\t<TR>\n\t\t\t<TD ALIGN=CENTER class=title>\n\t\t\t\t");
print($MSG_25_0110);
echo("\t\t\t\t</TD>\n\t\t</TR>\n\t\t<TR>\n\t<TD>\n\t\t<TABLE WIDTH=100% CELLPADDING=2 ALIGN=\"CENTER\" BGCOLOR=\"#FFFFFF\">\n\t\t  ");
if ($ERR != "") {
	echo("\t\t  <TR>\n\t\t\t<TD class=error COLSPAN=\"2\" ALIGN=CENTER bgcolor=\"yellow\">");
	print($ERR);
	echo("</TD>\n\t\t  </TR>\n\t\t  ");
}
echo("\t\t  <tr valign=\"TOP\">\n\t\t\t<td colspan=\"2\"><img src=\"../images/transparent.gif\" width=\"1\" height=\"5\"></td>\n\t\t  </tr>\n\n\t\t  <tr valign=\"TOP\">\n\t\t\t<td width=169>\n\t\t\t  ");
print($MSG_534);
echo("\t\t\t  </td>\n\t\t\t<td width=\"393\">\n\t\t\t  ");
print($MSG_539);
echo("\t\t\t  <br>\n\t\t\t  <input type=\"radio\" name=\"showacceptancetext\" value=\"1\"\n\t\t\t\t\t ");
if ($SETTINGS[showacceptancetext] == 1) {
	print(" CHECKED");
}
echo("\t\t\t\t\t >\n\t\t\t  ");
print($MSG_030);
echo("\t\t\t  <input type=\"radio\" name=\"showacceptancetext\" value=\"2\"\n\t\t\t\t\t ");
if ($SETTINGS[showacceptancetext] == 2) {
	print(" CHECKED");
}
echo("\t\t\t\t\t >\n\t\t\t  ");
print($MSG_029);
echo("\t\t\t   </td>\n\t\t  </tr>\n\t\t  <tr valign=\"TOP\">\n\t\t\t<td width=169></td>\n\t\t\t<td width=\"393\">\n\t\t\t  <textarea name=\"acceptancetext\" cols=\"45\" rows=\"10\">");
echo(stripslashes($SETTINGS[acceptancetext]));
echo("</textarea>\n\t\t\t</td>\n\t\t  </tr>\n\t\t  <TR>\n\t\t\t<TD WIDTH=169>\n\t\t\t  <INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"update\">\n\t\t\t</TD>\n\t\t\t<TD WIDTH=\"393\">\n\t\t\t  <INPUT TYPE=\"submit\" NAME=\"act\" VALUE=\"");
print($MSG_530);
echo("\">\n\t\t\t</TD>\n\t\t  </TR>\n\t\t  <TR>\n\t\t\t<TD WIDTH=169></TD>\n\t\t\t<TD WIDTH=\"393\"> </TD>\n\t\t  </TR>\n\t\t</TABLE>\n\t</TD>\n\t</TR>\n\t</TABLE>\n\t</FORM>\n</TD>\n</TR>\n</TABLE>\n</TD>\n</TR>\n</TABLE>\n</BODY>\n</HTML>");

