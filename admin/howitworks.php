<?php

require("../includes/config.inc.php");
include("loggedin.inc.php");
include($include_path . "time.inc.php");
unset($ERR);
if ($_POST[action] == "update" && basename($_SERVER["HTTP_REFERER"]) == basename($_SERVER["PHP_SELF"])) {
	$query = "" . "update HB_settings SET\n\t\t\t\t  howitworks='" . $_POST["howitworks"] . "',\n\t\t\t\t  howitworkstext='" . nl2br(addslashes($_POST[howitworkstext])) . "'";
	$res = @mysql_query($query);
	if (!$res) {
		print("" . "Error: " . $query . "<BR>" . mysql_error());
		exit();
	}
	else {
		$ERR = $MSG_31_0052;
		$SETTINGS = $_POST;
	}
}
$query = "SELECT howitworks,howitworkstext FROM HB_settings";
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
echo("<HTML>\n<HEAD>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n<link rel='stylesheet' type='text/css' href='style.css' />\n<body bgcolor=\"#FFFFFF\" text=\"#000000\" link=\"#0066FF\" vlink=\"#666666\" alink=\"#000066\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">\n<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n  <tr> \n    <td background=\"images/bac_barint.gif\"><tab");
echo("le width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\">\n        <tr> \n          <td width=\"30\"><img src=\"images/i_con.gif\" ></td>\n          <td class=white>");
echo($MSG_25_0018);
echo("&nbsp;&gt;&gt;&nbsp;");
echo($MSG_31_0048);
echo("</td>\n        </tr>\n      </table></td>\n  </tr>\n  <tr>\n    <td align=\"center\" valign=\"middle\">&nbsp;</td>\n  </tr>\n    <tr> \n    <td align=\"center\" valign=\"middle\">\n<TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR=\"#FFFFFF\">\n<TR>\n<TD align=\"center\">\n<BR>\n<FORM NAME=conf ACTION=");
echo(basename($_SERVER["PHP_SELF"]));
echo(" METHOD=POST>\n\t<TABLE WIDTH=\"95%\" BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"1\" BGCOLOR=\"#546f95\">\n\t\t<TR>\n\t\t\t<TD ALIGN=CENTER class=title>\n\t\t\t\t");
print($MSG_31_0048);
echo("\t\t\t\t</TD>\n\t\t</TR>\n\t\t<TR>\n\t\t\t<TD>\n\n<TABLE WIDTH=100% CELLPADDING=2 ALIGN=\"CENTER\" BGCOLOR=\"#FFFFFF\">\n  ");
if (isset($ERR)) {
	echo("  <TR BGCOLOR=yellow>\n\t<TD class=error COLSPAN=\"2\" ALIGN=CENTER>");
	print($ERR);
	echo("</TD>\n  </TR>\n  ");
}
echo("  <TR VALIGN=\"TOP\">\n\t<TD WIDTH=109 HEIGHT=\"22\">\n\t  ");
echo($MSG_31_0050);
echo("</TD>\n\t<TD WIDTH=\"375\" HEIGHT=\"22\">\n\t  ");
echo($MSG_31_0049);
echo("<BR>\n\t  <INPUT TYPE=\"radio\" NAME=\"howitworks\" VALUE=\"y\" ");
if ($SETTINGS[howitworks] == "y") {
	print(" CHECKED");
}
echo(">\n\t  ");
print($MSG_030);
echo("\t  <INPUT TYPE=\"radio\" NAME=\"howitworks\" VALUE=\"n\" ");
if ($SETTINGS[howitworks] == "n") {
	print(" CHECKED");
}
echo(">\n\t  ");
print($MSG_029);
echo("\t  </TD>\n  </TR>\n  <TR VALIGN=\"TOP\">\n\t<TD WIDTH=109 HEIGHT=\"22\">\n\t  ");
print($MSG_31_0051);
echo("\t  </TD>\n\t<TD WIDTH=\"375\" HEIGHT=\"22\">\n\t  ");
echo("<BR>\n\t    ");
echo("<s");
echo("cript src=\"http://js.nicedit.com/nicEdit-latest.js\" type=\"text/javascript\"></script>\n");
echo("<s");
echo("cript type=\"text/javascript\">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>\n\t  <textarea name=\"howitworkstext\" id=\"howitworkstext\" cols=\"90\"\n\t  rows=\"15\">");
echo(stripslashes(str_replace("<br />", "", stripslashes($SETTINGS[howitworkstext]))));
echo("</textarea>\n\t\n\t  </TD>\n  </TR>\n  <TR VALIGN=\"TOP\">\n\t<TD WIDTH=109 HEIGHT=\"22\">&nbsp;</TD>\n\t<TD WIDTH=\"375\" HEIGHT=\"22\">&nbsp;</TD>\n  </TR>\n  <TR>\n\t<TD WIDTH=109>\n\t  <INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"update\">\n\t</TD>\n\t<TD WIDTH=\"375\">\n\t  <INPUT TYPE=\"submit\" onclick=\"updateTextArea('howitworkstext');\" NAME=\"act\" VALUE=\"");
print($MSG_530);
echo("\">\n\t</TD>\n  </TR>\n  <TR>\n\t<TD WIDTH=109></TD>\n\t<TD WIDTH=\"375\"> </TD>\n  </TR>\n</TABLE>\n\t\t\t</TD>\n\t\t</TR>\n\t</TABLE>\n\t</FORM>\n</TD>\n</TR>\n</TABLE>\n</TD>\n</TR>\n</TABLE>\n</BODY>\n</HTML>");

