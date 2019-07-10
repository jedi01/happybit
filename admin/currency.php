<?php

require("../includes/config.inc.php");
include("loggedin.inc.php");
unset($ERR);
$query = "SELECT id,valuta,symbol,ime FROM HB_rates ORDER BY ime";
$res_ = @mysql_query($query);
if (!$res_) {
	print("" . "Error: " . $query . "<BR>" . mysql_error());
	exit();
}
else {
	if (0 < @mysql_num_rows($res_)) {
		while ($row = mysql_fetch_array($res_)) {
			$CURRENCIES[$row[id]] = "" . $row["symbol"] . "&nbsp;" . $row["ime"] . "&nbsp(" . $row["valuta"] . ") ";
			$CURRENCIES_SYMBOLS[$row[id]] = "" . $row["symbol"];
		}
	}
}
if ($_POST[action] == "update" && basename($_SERVER["HTTP_REFERER"]) == basename($_SERVER["PHP_SELF"])) {
	if (empty($_POST[defaultcurrency]) || empty($_POST[moneyformat]) || empty($_POST[moneysymbol])) {
		$ERR = $ERR_047;
		$SETTINGS = $_POST;
	}
	else {
		if (!(empty($_POST[moneydecimals])) && !(ereg("" . "^[0-9]+\$", $_POST[moneydecimals]))) {
			$ERR = $ERR_051;
			$SETTINGS = $_POST;
		}
		else {
			$query = "update HB_settings set currency='" . addslashes($CURRENCIES_SYMBOLS[$_POST[defaultcurrency]]) . ("" . "',\n\t\t\t\t\t\t\t\t          moneyformat=" . $_POST["moneyformat"] . ",\n\t\t\t\t\t\t\t\t          moneydecimals=") . intval($_POST[moneydecimals]) . ("" . ",\n\t\t\t\t\t\t\t\t          moneysymbol=" . $_POST["moneysymbol"]);
			$res = @mysql_query($query);
			if (!$res) {
				print("" . "Error: " . $query . "<BR>" . mysql_error());
				exit();
			}
			else {
				$ERR = $MSG_553;
				$SETTINGS = $_POST;
			}
		}
	}
	if (is_array($_POST[othercurrencies])) {
		@mysql_query("DELETE FROM HB_currencies");
		while (list($k, $v) = each($_POST[othercurrencies])) {
			$query = "" . "INSERT INTO HB_currencies VALUES (NULL,'" . $v . "')";
			$res = @mysql_query($query);
			if ($res) {
				continue;
			}
			print("" . "Error: " . $query . "<BR>" . mysql_error());
			exit();
		}
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
$OTHERCURRENCIES = array();
$query = "SELECT * FROM HB_currencies";
$res = @mysql_query($query);
if (!$res) {
	print("" . "Error: " . $query . "<BR>" . mysql_error());
	exit();
}
else {
	if (0 < mysql_num_rows($res)) {
		while ($row = mysql_fetch_array($res)) {
			$OTHERCURRENCIES[$row[id]] = $row[currency];
		}
	}
}
echo("<HEAD>\n\n");
echo("<S");
echo("CRIPT Language=Javascript>\nfunction window_open(pagina,titulo,ancho,largo,x,y){\n\t\n\tvar Ventana= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;\n\topen(pagina,titulo,Ventana);\n\t\n}\n</SCRIPT>\n<link rel='stylesheet' type='text/css' href='style.css' />\n</HEAD>\n<body bgcolor=\"#FFFFFF\" text=\"#000000\" link=\"#0066FF\" vli");
echo("nk=\"#666666\" alink=\"#000066\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">\n<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n  <tr> \n    <td background=\"images/bac_barint.gif\"><table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\">\n        <tr> \n          <td width=\"30\"><img src=\"images/i_pre.gif\" width=\"16\" height=\"19\"></td>\n          <td class=white>");
echo($MSG_25_0008);
echo("&nbsp;&gt;&gt;&nbsp;");
echo($MSG_5004);
echo("</td>\n        </tr>\n      </table></td>\n  </tr>\n  <tr>\n    <td align=\"center\" valign=\"middle\">&nbsp;</td>\n  </tr>\n    <tr> \n    <td align=\"center\" valign=\"middle\">\n<TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR=\"#FFFFFF\">\n<TR>\n<TD align=\"center\">\n\t<BR>\n\t<FORM NAME=conf ACTION=currency.php METHOD=POST>\n\t\t<TABLE WIDTH=\"95%\" BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"1\" BGCOLOR=\"#546f95\">\n\t\t\t<TR>\n\t\t\t\t<TD A");
echo("LIGN=CENTER class=title>\n\t\t\t\t\t");
print($MSG_076);
echo("\t\t\t\t</TD>\n\t\t\t</TR>\n\t\t\t<TR>\n\t\t\t\t<TD>\n\t\t\t\t\t<TABLE WIDTH=100% CELLPADDING=2 ALIGN=\"CENTER\" BGCOLOR=\"#FFFFFF\">\n\t\t\t\t\t");
if ($ERR != "") {
	echo("\t\t\t\t\t\t<TR BGCOLOR=yellow>\n\t\t\t\t\t\t <TD class=error COLSPAN=\"2\" ALIGN=CENTER>\n\t\t\t\t\t\t ");
	print($ERR);
	echo("\t\t\t\t\t\t </TD>\n\t\t\t\t\t\t </TR>\n\t\t\t\t\t   ");
}
echo("\t\t\t\t\t\t<TR VALIGN=\"TOP\">\n\t\t\t\t\t\t\t<TD WIDTH=173 HEIGHT=\"31\">\n\t\t\t\t\t\t\t\t");
echo($MSG_5008);
echo("\t\t\t\t\t\t\t\t</TD>\n\t\t\t\t\t\t\t<TD HEIGHT=\"31\" WIDTH=\"459\">\n\t\t\t\t\t\t\t");
echo("<S");
echo("ELECT NAME=defaultcurrency>\n\t\t\t\t\t\t\t<OPTION VALUE=\"\"></OPTION>\n\t\t\t\t\t\t\t");
reset($CURRENCIES);
while (list($k, $v) = each($CURRENCIES)) {
	print("" . $k . ", " . $SETTINGS["currency"] . "<br>");
	echo("\t\t\t\t\t\t\t\t<OPTION VALUE=\"");
	echo($k);
	echo("\" ");
	if ($CURRENCIES_SYMBOLS[$k] == $SETTINGS[currency]) {
		print(" SELECTED");
	}
	echo(">");
	echo($v);
	echo("</OPTION>\n\t\t\t\t\t\t\t");
}
echo("\t\t\t\t\t\t\t</SELECT>\n\t\t\t\t\t\t\t\t<!--<INPUT TYPE=text NAME=currency VALUE=\"");
echo($SETTINGS[currency]);
echo("\" SIZE=5 MAXLENGTH=\"10\">-->\n\t\t\t\t\t\t\t<BR>\n\t\t\t\t\t\t\tNote: you can use the currency of your choice throughout the site.\n\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t</TD>\n\t\t\t\t\t\t</TR>\n\n\t\t\t\t\t\t<TR VALIGN=\"TOP\">\n\t\t\t\t\t\t\t<TD COLSPAN=\"2\" HEIGHT=\"7\"><IMG SRC=\"../images/transparent.gif\" WIDTH=\"1\" HEIGHT=\"5\"></TD>\n\t\t\t\t\t\t</TR>\n\t\t\t\t\t\t<TR VALIGN=\"TOP\">\n\t\t\t\t\t\t\t<TD WIDTH=173 HEIGHT=\"31\">\n\t\t\t\t\t\t\t\t");
echo($MSG_544);
echo("\t\t\t\t\t\t\t\t</TD>\n\t\t\t\t\t\t\t<TD HEIGHT=\"31\" WIDTH=\"459\">\n\t\t\t\t\t\t\t\t<INPUT TYPE=\"radio\" NAME=\"moneyformat\" VALUE=\"1\"\n\t\t\t\t\t\t\t");
if ($SETTINGS[moneyformat] == 1) {
	print(" CHECKED");
}
echo("\t\t\t\t\t\t\t>\n\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t");
echo($MSG_545);
echo("\t\t\t\t\t\t\t\t<BR>\n\t\t\t\t\t\t\t\t<INPUT TYPE=\"radio\" NAME=\"moneyformat\" VALUE=\"2\"\n\t\t\t\t\t\t\t");
if ($SETTINGS[moneyformat] == 2) {
	print(" CHECKED");
}
echo("\t\t\t\t\t\t\t>\n\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t");
echo($MSG_546);
echo("\t\t\t\t\t\t\t\t </TD>\n\t\t\t\t\t\t</TR>\n\t\t\t\t\t\t<TR VALIGN=\"TOP\">\n\t\t\t\t\t\t\t<TD COLSPAN=\"2\" HEIGHT=\"4\"><IMG SRC=\"../images/transparent.gif\" WIDTH=\"1\" HEIGHT=\"5\"></TD>\n\t\t\t\t\t\t</TR>\n\t\t\t\t\t\t<TR VALIGN=\"TOP\">\n\t\t\t\t\t\t\t<TD WIDTH=173 HEIGHT=\"31\">\n\t\t\t\t\t\t\t\t");
echo($MSG_548);
echo("\t\t\t\t\t\t\t\t</TD>\n\t\t\t\t\t\t\t<TD HEIGHT=\"31\" WIDTH=\"459\"> \n\t\t\t\t\t\t\t\t");
echo($MSG_547);
echo("\t\t\t\t\t\t\t\t<BR>\n\t\t\t\t\t\t\t\t<INPUT TYPE=text NAME=moneydecimals VALUE=\"");
echo($SETTINGS[moneydecimals]);
echo("\" SIZE=5 MAXLENGTH=\"10\">\n\t\t\t\t\t\t\t</TD>\n\t\t\t\t\t\t</TR>\n\t\t\t\t\t\t<TR VALIGN=\"TOP\">\n\t\t\t\t\t\t\t<TD COLSPAN=\"2\" HEIGHT=\"6\"><IMG SRC=\"../images/transparent.gif\" WIDTH=\"1\" HEIGHT=\"5\"></TD>\n\t\t\t\t\t\t</TR>\n\t\t\t\t\t\t<TR VALIGN=\"TOP\">\n\t\t\t\t\t\t\t<TD WIDTH=173 HEIGHT=\"31\">\n\t\t\t\t\t\t\t\t");
echo($MSG_549);
echo("\t\t\t\t\t\t\t\t</TD>\n\t\t\t\t\t\t\t<TD HEIGHT=\"31\" WIDTH=\"459\">\n\t\t\t\t\t\t\t\t<INPUT TYPE=\"radio\" NAME=\"moneysymbol\" VALUE=\"1\"\n\t\t\t\t\t");
if ($SETTINGS[moneysymbol] == 1) {
	print(" CHECKED");
}
echo("\t\t\t\t\t>\n\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t");
echo($MSG_550);
echo("\t\t\t\t\t\t\t\t<BR>\n\t\t\t\t\t\t\t\t<INPUT TYPE=\"radio\" NAME=\"moneysymbol\" VALUE=\"2\"\n\t\t\t\t\t");
if ($SETTINGS[moneysymbol] == 2) {
	print(" CHECKED");
}
echo("\t\t\t\t\t>\n\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t");
echo($MSG_551);
echo("\t\t\t\t\t\t\t\t </TD>\n\t\t\t\t\t\t</TR>\n\t\t\t\t\t\t<TR VALIGN=\"TOP\">\n\t\t\t\t\t\t\t<TD COLSPAN=\"2\" HEIGHT=\"4\"><IMG SRC=\"../images/transparent.gif\" WIDTH=\"1\" HEIGHT=\"5\"></TD>\n\t\t\t\t\t\t</TR>\n\t\t\t\t\t\t<TR>\n\t\t\t\t\t\t\t<TD WIDTH=173>\n\t\t\t\t\t\t\t\t<INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"update\">\n\t\t\t\t\t\t\t\t<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"");
echo($id);
echo("\">\n\t\t\t\t\t\t\t</TD>\n\t\t\t\t\t\t\t<TD WIDTH=\"459\">\n\t\t\t\t\t\t\t\t<INPUT TYPE=\"submit\" NAME=\"act\" VALUE=\"");
print($MSG_530);
echo("\">\n\t\t\t\t\t\t\t</TD>\n\t\t\t\t\t\t</TR>\n\t\t\t\t\t\t<TR>\n\t\t\t\t\t\t\t<TD WIDTH=173></TD>\n\t\t\t\t\t\t\t<TD WIDTH=\"459\"> </TD>\n\t\t\t\t\t\t</TR>\n\t\t\t\t\t</TABLE>\n\t\t\t\t</TD>\n\t\t\t</TR>\n\t\t</TABLE>\n\t\t</FORM>\n</TR>\n</TABLE>\n\n<!-- Closing external table (header.php) -->\n</TD>\n</TR>\n</TABLE>\n\n</TD>\n</TR>\n</TABLE>\n</BODY>\n</HTML>");

