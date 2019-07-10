<?php


include "../includes/config.inc.php";
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
<head>
<title>ADMIN AREA</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
</head>

<body bgcolor=\"#546f95\" background=\"images/bac_hea.gif\" text=\"#FFFFFF\" link=\"#FFFFFF\" vlink=\"#CCCCCC\" alink=\"#666666\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">
<table width=\"100%\" height=\"4";
echo "2\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" background=\"images/bac_hea.gif\">
  <tr> 
    <td width=\"435\" rowspan=\"2\" valign=\"middle\">
		<h2 style='margin:0px;'></h2>
	</td>
    <td height=\"15\" valign=\"bottom\">
		<div style='margin:0px;' align=\"right\"><b>Admin</b><!--<img src=\"images/t_adm_be.gif\" width=\"192\" height=\"16\" hspace=\"5\">--></div>
	</td>
  </tr>
  <tr>
  	<TD>
  	";
if (file_exists("../reverse/index.php"))
{
	print '' . "<A TARGET=_top HREF=../reverse/admin/>" . $MSG_2_0046 . "</A>";
}
print "&nbsp;&nbsp;&nbsp;";
if (file_exists("../classifieds/index.php"))
{
	print '' . "<A TARGET=_top HREF=../classifieds/admin/>" . $MSG_2_0001 . "</A>";
}
echo "	</TD> 
    <td valign=\"top\" align=right>
		<font size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\">
		";
if ($_SESSION["HAPPYBID_ADMIN_LOGIN"])
{
	echo "		  ";
	echo $MSG_592;
	echo "		  <B>
		  ";
	echo $_SESSION["HAPPYBID_ADMIN_USER"];
	echo "		  </B></FONT>
		  ";
}
 else 
{
	print "&nbsp;";
}
if ($_SESSION["HAPPYBID_ADMIN_LOGIN"])
{
	echo "		 <font color=\"#FFFFFF\" SIZE=1> | 
		 </font> <font size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\"><a href=\"logout.php\" TARGET=content>logout</a>&nbsp;</FONT></font>
		 
		 ";
}
echo "	 </td>
  </tr>
</table>
</body>
</html>
";
