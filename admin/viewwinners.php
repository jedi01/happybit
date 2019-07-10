<?php


include "../includes/config.inc.php";
include $include_path . "dates.inc.php";
include $include_path . "auction_types.inc.php";
include "loggedin.inc.php";
if (!(isset($_GET["id"])))
{
	print $MSG__0164;
	exit();
}
$query = "SELECT * FROM HB_auctions WHERE id=" . intval($_GET["id"]);
$res = mysql_query($query);
if (!$res)
{
	print '' . $query . "<BR>" . mysql_error();
	exit();
}
 else 
{
	if (mysql_num_rows($res) == 0)
	{
		print $MSG__0165;
	}
	 else 
	{
		$AUCTION = mysql_fetch_array($res);
	}
}
$query = "SELECT * FROM HB_winners WHERE auction=" . intval($_GET["id"]);
$res = mysql_query($query);
if (!$res)
{
	print '' . $query . "<BR>" . mysql_error();
	exit();
}
 else 
{
	if (mysql_num_rows($res) > 0)
	{
		while ($row = mysql_fetch_array($res))
		{
			$WINNERS[$row["id"]] = $row;
			continue;
		}
	}
}
$query = "SELECT * FROM HB_bids WHERE auction=" . intval($_GET["id"]);
$res = mysql_query($query);
if (!$res)
{
	print '' . $query . "<BR>" . mysql_error();
	exit();
}
 else 
{
	if (mysql_num_rows($res) > 0)
	{
		while ($row = mysql_fetch_array($res))
		{
			$BIDS[$row["id"]] = $row;
			continue;
		}
	}
}
echo "<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<BODY>
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
  <tr> 
    <td background=\"images/bac_barint.gif\"><table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\">
        <tr> 
          <td width=\"30\"><img src=\"images/i_auc.gif\"></td>
          <td class=white>";
echo $MSG_239;
echo "&nbsp;&gt;&gt;&nbsp;";
echo $MSG_30_0176;
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
		<TD ALIGN=CENTER class=title>
			";
print $MSG_30_0176;
echo "		</TD>
	</TR>
	<TR>
		<TD>

    <TABLE WIDTH=100% CELPADDING=4 CELLSPACING=0 BORDER=0 ALIGN=\"CENTER\" CELLPADDING=\"3\">
      <TR BGCOLOR=\"#FFFFFF\">
        <TD ALIGN=left><B>";
echo $MSG_113;
echo ": </B> ";
echo intval($_GET["id"]);
echo "</TD>
	  </TR>
      <TR BGCOLOR=\"#FFFFFF\">
        <TD ALIGN=left><B>";
echo $MSG_197;
echo ": </B> ";
echo stripslashes($AUCTION["title"]);
echo "</TD>
	  </TR>
      <TR BGCOLOR=\"#FFFFFF\">
        <TD ALIGN=left>
			";
$SELLER = mysql_fetch_array(mysql_query("SELECT name,nick FROM HB_users WHERE id=" . $AUCTION["user"]));
echo "			<B>";
echo $MSG_125;
echo ": </B> ";
echo stripslashes($SELLER["nick"]) . " (" . $SELLER["name"] . ")";
echo "</TD>
	  </TR>
      <TR BGCOLOR=\"#FFFFFF\">
        <TD ALIGN=left><B>";
echo $MSG_127;
echo ": </B> ";
echo print_money($AUCTION["minimum_bid"]);
echo "</TD>
	  </TR>
      <TR BGCOLOR=\"#FFFFFF\">
        <TD ALIGN=left><B>";
echo $MSG_111;
echo ": </B> ";
echo formatdate($AUCTION["starts"]);
echo "</TD>
	  </TR>
      <TR BGCOLOR=\"#FFFFFF\">
        <TD ALIGN=left><B>";
echo $MSG_30_0177;
echo ": </B> ";
echo formatdate($AUCTION["ends"]);
echo "</TD>
	  </TR>
      <TR BGCOLOR=\"#FFFFFF\">
        <TD ALIGN=left><B>";
echo $MSG_257;
echo ": </B> ";
echo $auction_types[$AUCTION["auction_type"]];
echo "</TD>
	  </TR>
      <TR BGCOLOR=\"#FFFFFF\">
        <TD ALIGN=left>&nbsp;</TD>
	  </TR>
      <TR BGCOLOR=\"#FFCC00\">
        <TD ALIGN=left><B>";
echo $MSG_453;
echo "</B></TD>
	  </TR>
      <TR BGCOLOR=\"#FFFFFF\">
        <TD ALIGN=left>
		";
if (is_array($WINNERS))
{
	echo "				<TABLE WIDTH=65% ALIGN=CENTER CELLPADDING=4 CELLSPACING=1 BORDER=0 BGCOLOR=#FFFFFF>
				<TR BGCOLOR=#DDDDDD align=center>
					<TD><B>";
	echo $MSG_176;
	echo "</B></TD>
					<TD><B>";
	echo $MSG_30_0179;
	echo "</B></TD>
					<TD><B>";
	echo $MSG_284;
	echo "</B></TD>
				</TR>
			";
	while (true)
	{
		if (list($k, $v) = each($WINNERS))
		{
			$qty = mysql_result(mysql_query("SELECT quantity FROM HB_bids WHERE bidder=" . $v["winner"] . " AND auction=" . intval($_GET["id"])), 0, "quantity");
			$BIDDER = mysql_fetch_array(mysql_query("SELECT name,nick FROM HB_users WHERE id=" . $v["winner"]));
			echo "				<TR>
					<TD>";
			echo stripslashes($BIDDER["nick"]) . " (" . stripslashes($BIDDER["name"]) . ")";
			echo "</TD>
					<TD align=right>";
			echo print_money($v["bid"]);
			echo "&nbsp;</TD>
					<TD align=center>";
			if ($qty == 0)
			{
				print "--";
			}
			 else 
			{
				print $qty;
			}
			echo "</TD>
				</TR>
			";
		}
		continue;
	}
	echo "				</TABLE>
			";
}
 else 
{
	print $MSG_30_0178;
}
echo "		</TD>
	  </TR>
      <TR BGCOLOR=\"#FFCC00\">
        <TD ALIGN=left><B>";
echo $MSG_30_0180;
echo "</B></TD>
	  </TR>
      <TR BGCOLOR=\"#FFFFFF\">
        <TD ALIGN=left>
		";
if (is_array($BIDS))
{
	echo "				<TABLE WIDTH=65% ALIGN=CENTER CELLPADDING=4 CELLSPACING=1 BORDER=0 BGCOLOR=#FFFFFF>
				<TR BGCOLOR=#DDDDDD align=center>
					<TD><B>";
	echo $MSG_176;
	echo "</B></TD>
					<TD><B>";
	echo $MSG_30_0179;
	echo "</B></TD>
					<TD><B>";
	echo $MSG_284;
	echo "</B></TD>
				</TR>
			";
	while (true)
	{
		if (list($k, $v) = each($BIDS))
		{
			$qty = mysql_result(mysql_query("SELECT quantity FROM HB_bids WHERE bidder=" . $v["bidder"] . " AND auction=" . intval($_GET["id"])), 0, "quantity");
			$BIDDER = mysql_fetch_array(mysql_query("SELECT name,nick FROM HB_users WHERE id=" . $v["bidder"]));
			echo "				<TR>
					<TD>";
			echo stripslashes($BIDDER["nick"]) . " (" . stripslashes($BIDDER["name"]) . ")";
			echo "</TD>
					<TD align=right>";
			echo print_money($v["bid"]);
			echo "&nbsp;</TD>
					<TD align=center>";
			if ($qty == 0)
			{
				print "--";
			}
			 else 
			{
				print $qty;
			}
			echo "</TD>
				</TR>
			";
		}
		continue;
	}
	echo "				</TABLE>
			";
}
 else 
{
	print $MSG_30_0178;
}
echo "		</TD>
	  </TR>
	  
    </TABLE>
</TR>
</TABLE>
</BODY>
<HTML>";
