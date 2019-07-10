<?php

require("../includes/config.inc.php");
include("loggedin.inc.php");
unset($ERR);
if ($_POST["action"] == "update" && basename($_SERVER["HTTP_REFERER"]) == basename($_SERVER["PHP_SELF"])) {
	$query = "update HB_settings set\n                  errortext='" . addslashes($_POST["errortext"]) . "',\n                  errormail='" . $_POST["errormail"] . "'";
	$res = @mysql_query($query);
	if (!$res) {
		print("" . "Error: " . $query . "<BR>" . mysql_error());
		exit();
	}
	else {
		$ERR = $MSG_413;
		$SETTINGS = $_POST;
	}
}
else {
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
}
$SESSION_ERROR = $ERR_119;
$_SESSION["SESSION_ERROR"] = $SESSION_ERROR;
echo("<HTML>\n<HEAD>\n<link rel='stylesheet' type='text/css' href='style.css' />\n");
echo("<S");
echo("TYLE TYPE=\"text/css\">\nbody {\nscrollbar-face-color: #aaaaaa;\nscrollbar-shadow-color: #666666;\nscrollbar-highlight-color: #aaaaaa;\nscrollbar-3dlight-color: #dddddd;\nscrollbar-darkshadow-color: #444444;\nscrollbar-track-color: #cccccc;\nscrollbar-arrow-color: #ffffff;\n}</STYLE>\n</HEAD>\n<body bgcolor=\"#FFFFFF\" text=\"#000000\" link=\"#0066FF\" vlink=\"#666666\" alink=\"#000066\" leftmargin=\"0\" topmargin=\"0\" margin");
echo("width=\"0\" marginheight=\"0\">\n<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n  <tr> \n    <td background=\"images/bac_barint.gif\"><table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\">\n        <tr> \n          <td width=\"30\"><img src=\"images/i_set.gif\" width=\"21\" height=\"19\"></td>\n          <td class=white>");
echo($MSG_25_0007);
echo("&nbsp;&gt;&gt;&nbsp;");
echo($MSG_526);
echo("</td>\n        </tr>\n      </table></td>\n  </tr>\n  <tr>\n    <td align=\"center\" valign=\"middle\">&nbsp;</td>\n  </tr>\n    <tr> \n    <td align=\"center\" valign=\"middle\">\n\n        <FORM NAME=conf ACTION=");
echo(basename($_SERVER["PHP_SELF"]));
echo(" METHOD=POST>\n          <TABLE WIDTH=\"95%\" BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"1\" BGCOLOR=\"#546f95\">\n            <TR>\n              <TD ALIGN=CENTER class=title>");
print($MSG_409);
echo("</TD>\n            </TR>\n            <TR>\n              <TD>\n              <TABLE WIDTH=100% CELLPADDING=2 ALIGN=\"CENTER\" BGCOLOR=\"#FFFFFF\">\n                  ");
if (isset($ERR)) {
	echo("                  <TR BGCOLOR=yellow>\n                    <TD COLSPAN=\"2\" ALIGN=CENTER><B>");
	print($ERR);
	echo(" </B></TD>\n                  </TR>\n                  ");
}
echo("                  <TR VALIGN=\"TOP\">\n                    <TD WIDTH=134>&nbsp;</TD>\n                    <TD WIDTH=\"350\"> ");
print($MSG_410);
echo(" </TD>\n                  </TR>\n                  <TR VALIGN=\"TOP\">\n                    <TD WIDTH=134 HEIGHT=\"22\"> ");
print($MSG_411);
echo(" </TD>\n                    <TD WIDTH=\"350\" HEIGHT=\"22\">\n                      <TEXTAREA NAME=\"errortext\" COLS=\"55\" ROWS=\"8\">");
echo($SETTINGS["errortext"]);
echo("</TEXTAREA>\n                      </TD>\n                  </TR>\n                  <TR VALIGN=\"TOP\">\n                    <TD WIDTH=134 HEIGHT=\"22\"> ");
print($MSG_412);
echo(" </TD>\n                    <TD WIDTH=\"350\" HEIGHT=\"22\">\n                      <INPUT TYPE=\"text\" NAME=\"errormail\" SIZE=\"55\" VALUE=\"");
echo($SETTINGS["errormail"]);
echo("\" MAXLENGTH=\"255\">\n                      </TD>\n                  </TR>\n                  <TR VALIGN=\"TOP\">\n                    <TD WIDTH=134 HEIGHT=\"22\">&nbsp;</TD>\n                    <TD WIDTH=\"350\" HEIGHT=\"22\">&nbsp;</TD>\n                  </TR>\n                  <TR>\n                    <TD WIDTH=134><INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"update\">\n                      <INPUT TYPE=\"hidden\" NAME=\"curren");
echo("cy\" VALUE=\"");
echo($SETTINGS["currency"]);
echo("\">\n                    </TD>\n                    <TD WIDTH=\"350\"><INPUT TYPE=\"submit\" NAME=\"act\" VALUE=\"");
print($MSG_530);
echo("\">\n                    </TD>\n                  </TR>\n                  <TR>\n                    <TD WIDTH=134></TD>\n                    <TD WIDTH=\"350\"></TD>\n                  </TR>\n                </TABLE>\n                </TD>\n            </TR>\n          </TABLE>\n        </FORM>\n    </TD>\n  </TR>\n</TABLE>\n</BODY>\n</HTML>");

