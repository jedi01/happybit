<?

require('../includes/config.inc.php');
include "loggedin.inc.php";


#// Retrieve current counters
$query = "SELECT * FROM HB_counters";
$res = @mysql_query($query);
if(!$res)
{
	print "Error: $query<BR>".mysql_error();
	exit;
}
elseif(mysql_num_rows($res) > 0)
{
	$COUNTERS = mysql_fetch_array($res);
}

require("./header.php");
?>
<link rel='stylesheet' type='text/css' href='style.css' />
<TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
<TR>
<TD>
<CENTER>
<BR>
<FORM NAME=conf ACTION=checkupdates.php METHOD=POST>
	<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#296FAB">
		<TR>
			<TD ALIGN=CENTER class=title>
				<? print $MSG_1030; ?>
			</TD>
		</TR>
		<TR>
			<TD>
				<TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
					<TR VALIGN="TOP">
						<TD COLSPAN=3>
							<?=$MSG_1031;?>
							</TD>
					</TR>
					<TR VALIGN="TOP">
						<TD COLSPAN=3>
							
							<BR><BR>
							USERS<BR>
							-----<BR>
							<?
							$query = "SELECT count(id) as COUNTER from HB_users WHERE suspended=0";
							$res = @mysql_query($query);
							if(!$res)
							{
								print "Error: $query<BR>".mysql_error();
								exit;
							}
							$USERS = mysql_result($res,0,"COUNTER");
							
							#// Update counters table
							$query = "UPDATE HB_counters set users=$USERS";
							$res_ = @mysql_query($query);
							if(!$res)
							{
								print "Error: $query<BR>".mysql_error();
								exit;
							}
							else
							{
								print "<I>active users</I> counter updated. New value is: $USERS<BR>";
							}
							?>

							<?
							$query = "SELECT count(id) as COUNTER from HB_users WHERE suspended<>0";
							$res = @mysql_query($query);
							if(!$res)
							{
								print "Error: $query<BR>".mysql_error();
								exit;
							}
							$USERS = mysql_result($res,0,"COUNTER");
							
							#// Update counters table
							$query = "UPDATE HB_counters set inactiveusers=$USERS";
							$res_ = @mysql_query($query);
							if(!$res)
							{
								print "Error: $query<BR>".mysql_error();
								exit;
							}
							else
							{
								print "<I>inactive users</I> counter updated. New value is: $USERS<BR>";
							}
							?>
							<BR>
							AUCTIONS<BR>
							--------<BR>
							<?
							$query = "SELECT count(id) as COUNTER from HB_auctions WHERE closed=0 and suspended=0 AND private='n'";
							$res = @mysql_query($query);
							if(!$res)
							{
								print "Error: $query<BR>".mysql_error();
								exit;
							}
							$AUCTIONS = mysql_result($res,0,"COUNTER");
							
							#// Update counters table
							$query = "UPDATE HB_counters set auctions=$AUCTIONS";
							$res_ = @mysql_query($query);
							if(!$res)
							{
								print "Error: $query<BR>".mysql_error();
								exit;
							}
							else
							{
								print "<I>active auctions</I> counter updated. New value is: $AUCTIONS<BR>";
							}
							?>

							<?
							$query = "SELECT count(id) as COUNTER from HB_auctions WHERE closed<>0 AND private='n'";
							$res = @mysql_query($query);
							if(!$res)
							{
								print "Error: $query<BR>".mysql_error();
								exit;
							}
							$AUCTIONS = mysql_result($res,0,"COUNTER");
							
							#// Update counters table
							$query = "UPDATE HB_counters set closedauctions=$AUCTIONS";
							$res_ = @mysql_query($query);
							if(!$res)
							{
								print "Error: $query<BR>".mysql_error();
								exit;
							}
							else
							{
								print "<I>closed auctions</I> counter updated. New value is: $AUCTIONS<BR>";
							}
							?>

							<?
							$query = "SELECT count(id) as COUNTER from HB_auctions WHERE closed=0 and suspended<>0 AND private='n'";
							$res = @mysql_query($query);
							if(!$res)
							{
								print "Error: $query<BR>".mysql_error();
								exit;
							}
							$AUCTIONS = mysql_result($res,0,"COUNTER");
							
							#// Update counters table
							$query = "UPDATE HB_counters set suspendedauctions=$AUCTIONS";
							$res_ = @mysql_query($query);
							if(!$res)
							{
								print "Error: $query<BR>".mysql_error();
								exit;
							}
							else
							{
								print "<I>suspended auctions</I> counter updated. New value is: $AUCTIONS<BR>";
							}
							?>

							<BR>
							BIDS<BR>
							----<BR>
							<?
							$query = "SELECT
										  a.id,
										  a.auction,
										  b.id
										  FROM
										  HB_bids a, HB_auctions b
										  WHERE
										  a.auction=b.id AND
										  b.closed=0 AND b.suspended=0 AND private='n'";
							$res = @mysql_query($query);
							if(!$res)
							{
								print "Error: $query<BR>".mysql_error();
								exit;
							}
							$BIDS = mysql_num_rows($res);
							
							#// Update counters table
							$query = "UPDATE HB_counters set bids=$BIDS";
							$res_ = @mysql_query($query);
							if(!$res)
							{
								print "Error: $query<BR>".mysql_error();
								exit;
							}
							else
							{
								print "<I>bids</I> counter updated. New value is: $BIDS<BR>";
							}
							?>
							<BR>
							CATEGORIES<BR>
							----------<BR>
							<?
							@mysql_query("UPDATE HB_categories set counter=0, sub_counter=0");
							print "Reset all categories counters<BR>";
							$query = "SELECT
										  a.cat_id, a.cat_name, a.parent_id, a.counter,a.sub_counter,
										  b.id, b.category
										  FROM
										  HB_categories a, HB_auctions b
										  WHERE
										  a.cat_id=b.category
										  AND
										  b.closed=0 AND b.suspended=0 AND private='n'";
							$res = @mysql_query($query);
							if(!$res)
							{
								print "Error: $query<BR>".mysql_error();
								exit;
							}
							while($row = mysql_fetch_array($res))
							{
								
								
								$cat_id = $row[cat_id];
								
								do
								{
									// update counter for this category
									$query = "SELECT * FROM HB_categories WHERE cat_id=\"$cat_id\"";
									$result = mysql_query($query);
									$CAT = mysql_fetch_array($result);
									if($result)
									{
										if (mysql_num_rows($result) > 0)
										{
											$R_parent_id = $CAT[parent_id];
											$R_cat_id = $CAT[cat_id];
											$R_sub_name = $CAT[cat_name];
											$R_counter = intval(mysql_result($result,0,"counter"));
											$R_sub_counter = intval(mysql_result($result,0,"sub_counter"));
											
											$R_sub_counter++;
											if ( $cat_id == $root_cat )
											++$R_counter;
											
											if($R_counter < 0) $R_counter = 0;
											if($R_sub_counter < 0) $R_sub_counter = 0;
											
											$query = "UPDATE HB_categories SET counter='$R_counter', sub_counter='$R_sub_counter' WHERE cat_id=\"$cat_id\"";
											@mysql_query($query);
											
											$cat_id = $R_parent_id;
											print "Counter updated for category <I>$R_sub_name</I>. New value is: $R_sub_counter<BR>\n";
										}
									}
								}
								while ($cat_id!=0);
							}
							
	?>
							</TD>
					</TR>
				</TABLE>
			</TD>
		</TR>
	</TABLE>
	</FORM>
	<BR><BR>

	
	<A HREF="admin.php" CLASS="links">Admin Home</A>
	
	</CENTER>
	<BR><BR>

</TD>
</TR>
</TABLE>

<!-- Closing external table (header.php) -->
</TD>
</TR>
</TABLE>

<? require("./footer.php"); ?>
</BODY>
</HTML>
