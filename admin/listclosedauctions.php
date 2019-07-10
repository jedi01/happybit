<?php


include "../includes/config.inc.php";
include "loggedin.inc.php";
$limit = 30;
if (!$_GET[offset])
{
	$offset = 0;
}
 else 
{
	$offset = $_GET[offset];
}
$PAGES = ceil($TOTALUSERS / $limit);
$_SESSION["RETURN_LIST"] = "listclosedauctions.php";
$_SESSION["RETURN_LIST_OFFSET"] = intval($_GET["offset"]);
echo "<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor=\"#FFFFFF\" text=\"#000000\" link=\"#0066FF\" vlink=\"#666666\" alink=\"#000066\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
  <tr> 
    <td background=\"images/bac_barint.gif\"><table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\">
";
echo "        <tr> 
          <td width=\"30\"><img src=\"images/i_auc.gif\" ></td>
          <td class=white>";
echo $MSG_239;
echo "&nbsp;&gt;&gt;&nbsp;";
echo $MSG_5226;
echo "</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"middle\">&nbsp;</td>
  </tr>
    <tr> 
    <td align=\"center\" valign=\"middle\">
<TABLE WIDTH=\"95%\" BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"1\" BGCOLOR=\"#546f95\" ALIGN=\"CENTER\">
<TR>
  <TD ALIGN=CENTER class=title>";
print $MSG_5226;
echo "</TD>
</TR>
<TR>
  <TD><TABLE WIDTH=100% CELPADDING=0 CELLSPACING=1 BORDER=0 ALIGN=\"CENTER\" CELLPADDING=\"3\">
      ";
$query = '' . "SELECT 
				a.bid, a.winner, a.closingdate, a.bid, 
				b.title, b.id, b.pict_url,
				c.nick
			FROM HB_winners a
			    INNER JOIN HB_auctions b ON a.auction = b.id
				LEFT OUTER JOIN HB_users c ON a.winner = c.id
				WHERE
					(b.auction_type='1' AND b.closed='1') OR
					((b.auction_type='2' OR b.auction_type='3') AND (b.closed = '2'))
			ORDER BY a.closingdate DESC limit " . $offset . ", " . $limit;
$result = mysql_query($query);
if (!$result)
{
	print '' . $ERR_001 . "<BR>" . $query . "<BR>" . mysql_error();
	exit();
}
$num_auctions = mysql_num_rows($result);
print '' . "<TR BGCOLOR=#FFFFFF><TD COLSPAN=7><B>
				" . $num_auctions . " " . $MSG_311 . "</B> 
				</TD></TR>";
echo "      <TR BGCOLOR=\"#FFCC00\">
        <TD ALIGN=CENTER> <B> ";
print $MSG_312;
echo " </B>  </TD>
        <TD ALIGN=CENTER> <B> ";
print $MSG_313;
echo " </B>  </TD>
        <TD ALIGN=CENTER> <B> ";
print $MSG_314;
echo " </B>  </TD>
        <TD ALIGN=LEFT> <B> ";
print $MSG_317;
echo " </B>  </TD>
        <TD ALIGN=LEFT> <B> ";
print $MSG_297;
echo " </B>  </TD>
      </tr>
        ";
$query = '' . "SELECT 
				a.bid, a.winner, a.closingdate, a.bid, 
				b.title, b.id, b.pict_url, b.closed, b.starts, b.description, b.suspended, 
				c.nick
			FROM HB_winners a
			    INNER JOIN HB_auctions b ON a.auction = b.id
				LEFT OUTER JOIN HB_users c ON a.winner = c.id
				WHERE
					(b.auction_type='1' AND b.closed='1') OR
					((b.auction_type='2' OR b.auction_type='3') AND (b.closed = '2'))
			ORDER BY a.closingdate DESC limit " . $offset . ", " . $limit;
$result = mysql_query($query);
if (!$result)
{
	print '' . "Database access error: abnormal termination<BR>" . $query . "<BR>" . mysql_error();
	exit();
}
$num_auction = mysql_num_rows($result);
$i = 0;
$bgcolor = "#FFFFFF";
while ($num_auction > $i)
{
	if ($bgcolor == "#FFFFFF")
	{
		$bgcolor = "#EEEEEE";
	}
	 else 
	{
		$bgcolor = "#FFFFFF";
	}
	$id = mysql_result($result, $i, "id");
	$query = '' . "SELECT id FROM HB_winners WHERE auction='" . $id . "'";
	$res_w = mysql_query($query);
	if (!$res_w)
	{
		print '' . $query . "<BR>" . mysql_error();
		exit();
	}
	 else 
	{
		if (mysql_num_rows($res_w) > 0)
		{
			$HASWINNERS = TRUE;
		}
		 else 
		{
			$HASWINNERS = FALSE;
		}
	}
	$title = stripslashes(mysql_result($result, $i, "title"));
	$nick = mysql_result($result, $i, "nick");
	$tmp_date = mysql_result($result, $i, "starts");
	$description = strip_tags(stripslashes(mysql_result($result, $i, "description")));
	$suspended = mysql_result($result, $i, "suspended");
	$day = substr($tmp_date, 6, 2);
	$month = substr($tmp_date, 4, 2);
	$year = substr($tmp_date, 0, 4);
	$date = '' . $day . "/" . $month . "/" . $year;
	print '' . "<TR BGCOLOR=" . $bgcolor . ">
					<TD>";
	if ($suspended == 1)
	{
		print '' . "<FONT COLOR=red><B>" . $title . "</B>";
	}
	 else 
	{
		print $title;
	}
	print "
						</TD>
						<TD>
						" . $nick . "
						
						</TD>
						<TD>
						" . $date . ('' . "
						
						</TD>
						<TD>
						" . $description . "
						
						</TD>
						<TD ALIGN=LEFT>
						<A HREF=\"editauction.php?id=" . $id . "&offset=" . $offset . "\" class=\"nounderlined\">" . $MSG_298 . "</A><BR>
						<A HREF=\"deleteauction.php?id=" . $id . "&offset=" . $offset . "\" class=\"nounderlined\">" . $MSG_299 . "</A><BR>
						<BR>
						</TD>
						<TR>");
	$i++;
	continue;
}
echo "					</TABLE>
					";
print "<TABLE WIDTH=100% BORDER=0 CELLPADDING=4 CELLSPACING=0 ALIGN=CENTER>
			   <TR ALIGN=CENTER BGCOLOR=#FFFFFF>
			   <TD COLSPAN=2>";
print "<SPAN CLASS=\"navigation\">";
$num_pages = ceil($num_auctions / $limit);
$i = 0;
while ($num_pages > $i)
{
	$of = $i * $limit;
	if ($of != $offset)
	{
		print '' . "<A HREF=\"listclosedauctions.php?offset=" . $of . "\" CLASS=\"navigation\">" . $i + 1 . "</A>";
		if ($i != $num_pages)
		{
			print " | ";
		}
	}
	 else 
	{
		print $i + 1;
		if ($i != $num_pages)
		{
			print " | ";
		}
	}
	$i++;
	continue;
}
print "</SPAN></TR></TD></table>";
echo "    </td></tr>
	</TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>


";
