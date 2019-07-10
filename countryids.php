<? 
include './includes/config.inc.php';
include $include_path.'countries.inc.php';

/* get list of  countries */
/*
$result = mysql_query ( "SELECT * FROM HB_countries ORDER BY country_id" );
if (!$result) {
	// output error message and exit 
} else {
*/
?>
<HTML>
<HEAD>
<TITLE><? print $SETTINGS[sitename]?></TITLE>
</HEAD>
<BODY>
<TABLE width="80%" border="0" cellspacing="0" cellpadding="4" align="center" bgcolor="#FFFFFF">
  <tr>
    <TD ><? print $tlt_font?>Select exact Country Name to enter in the tab delimited file for bulk uploading</FONT></TD>
  </tr>
  <TR>
    <TD WIDTH="100%"><? print $tlt_font?>COUNTRY NAME<br>
      <br>
      </FONT></TD>
  </TR>
  <?
	reset($countries);
	foreach($countries as $k=>$v) {
		if($k) {		
			print "<TR BGCOLOR=\"$bgcolor\">
			<TD>$v</FONT></TD>";
			print"</TR>";
		}
	}
?>
  <TR >
    <TD ALIGN="center"><BR>
      <BR>
      <A HREF="Javascript:window.close()">
      <?=$MSG_678?>
      </A></TD>
  </TR>
</TABLE>
</BODY>
</HTML>
