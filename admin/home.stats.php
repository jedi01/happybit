<?
	$COUNTERS = @mysql_fetch_array(@mysql_query("SELECT * FROM HB_counters"));
?>
<TABLE WIDTH=95% BORDER=0 CELLPADDING=2 CELLSPACING=0 BGCOLOR="#FFFFFF" ALIGN="CENTER">
  <TR>
    	<TD>
	<A HREF=<?=basename($_SERVER['PHP_SELF'])?>><?=$MSG_25_0025?></A>
	</TD>
  </TR>
</TABLE>
<TABLE WIDTH=95% BORDER=0 CELLPADDING=1 CELLSPACING=0 BGCOLOR="#546f95" ALIGN="CENTER">
  <TR>
    <TD>
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="4" CELLSPACING="1" BGCOLOR="#546f95">
      <TR BGCOLOR="#546f95">
        <TD COLSPAN="2" ALIGN=CENTER class=title><?=$MSG_25_0031?></TD>
        </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?=$MSG_25_0055?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
			<B><?=$COUNTERS['users']?></B>
		</TD>
      </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?=$MSG_25_0056?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
			<B><?=$COUNTERS['inactiveusers']?></B>
		</TD>
      </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?=$MSG_25_0057?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
			<B><?=$COUNTERS['auctions']?></B>
		</TD>
      </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?=$MSG_25_0058?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
			<B><?=$COUNTERS['closedauctions']?></B>
		</TD>
      </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?=$MSG_25_0059?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
			<B><?=$COUNTERS['bids']?></B>
		</TD>
      </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?=$MSG_25_0060?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
		<?$AMOUNT = @mysql_result(@mysql_query("SELECT SUM(amount) as AMOUNT FROM HB_tmpinvoice"),0,"AMOUNT");?>
			<B><?=print_money($AMOUNT)?></B>
		</TD>
      </TR>
      <TR>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?=$MSG_25_0061?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
		<?$AMOUNT = @mysql_result(@mysql_query("SELECT SUM(total) as AMOUNT FROM HB_invoiceheader WHERE paid='n'"),0,"AMOUNT");?>
			<B><?=print_money($AMOUNT)?></B>
			<?=$MSG_25_0062;?>
		</TD>
      </TR>
      <TR VALIGN=TOP>
        <TD WIDTH="29%" BGCOLOR=#FFFFFF>
			<?=$MSG_25_0063?>
		</TD>
        <TD WIDTH="71%" BGCOLOR=#FFFFFF>
		<?$ACCESS = mysql_fetch_array(mysql_query("SELECT * FROM HB_currentaccesses WHERE year='".date("Y")."' AND month='".date("m")."' AND day='".date("d")."'"));?>
			<?=$MSG_5161?>: <B><?=$ACCESS['pageviews']?></B><BR>
			<?=$MSG_5162?>: <B><?=$ACCESS['uniquevisitors']?></B><BR>
			<?=$MSG_5163?>: <B><?=$ACCESS['usersessions']?></B><BR>
		</TD>
      </TR>
    </TABLE>
	</TD>
  </TR>
</TABLE>
