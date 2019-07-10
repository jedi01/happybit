<?php

include("../includes/config.inc.php");
if (!(defined("INCLUDED"))) {
	exit("Access denied");
}
$img = $_GET["img"];
echo("<HTML>\n<BODY TOPMARGIN=0 LEFTMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>\n<A HREF=\"Javascript:window.close()\"><IMG SRC=");
echo("../" . $uploaded_path . session_id() . "/" . $img);
echo(" BORDER=0></A>\n</BODY>\n</HTML>");

