<?

require('../includes/config.inc.php');
include "loggedin.inc.php";

$ABSOLUTEWIDTH = 650;
$MAX = 0;
$TOTAL_PAGEVIEWS = 0;
$TOTAL_UNIQUEVISITORS = 0;
$TOTAL_USERSESSIONS = 0;


#// Retrieve data
$query = "SELECT year FROM HB_accesseshistoric GROUP BY year ORDER BY year desc ";
$res = @mysql_query($query);
if(!$res)
{
	print "Error: $query".mysql_error();
	exit;
}
while($year = mysql_fetch_array($res))
{
	$YEARS[] = $year[year];
	
	#//
	$query = "SELECT * FROM HB_accesseshistoric WHERE year='$year[year]' ORDER BY month DESC";
	$r = @mysql_query($query);
	if(!$r)
	{
		print "Error: $query".mysql_error();
		exit;
	}
	while($month = mysql_fetch_array($r))
	{
		$PAGEVIEWS[$year[year]][$month[month]] = $month[pageviews];
		if($month[pageviews] > $MAX) $MAX = $month[pageviews];
		$TOTAL_PAGEVIEWS += $month[pageviews];
		
		$UNIQUEVISITORS[$year[year]][$month[month]] = $month[uniquevisitiors];
		if($month[uniquevisitiors] > $MAX) $MAX = $month[uniquevisitiors];
		$TOTAL_UNIQUEVISITORS += $month[uniquevisitiors];
		
		$USERSESSIONS[$year[year]][$month[month]] = $month[usersessions];
		if($month[usersessions] > $MAX) $MAX = $month[usersessions];
		$TOTAL_USERSESSIONS += $month[usersessions];
	}
}

?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr> 
          <td width="30"><img src="images/i_sta.gif" ></td>
          <td class=white><?=$MSG_25_0023?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_5143?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
    <tr> 
    <td align="center" valign="middle">
<TABLE WIDTH=95% CELLPADDING=2 CELLSPACING=1 BORDER=0 ALIGN="CENTER">
    <TR BGCOLOR="#FFCC00">
      <TD ALIGN=CENTER colspan="2" bgcolor="#eeeeee">
        <p class=title>
          <?=$MSG_5158."<I>$SETTINGS[sitename]</I>"?>
          </b> <BR>
          <?=$MSG_5281;?></p>
        <p>
			<A HREF=viewbrowserstats.php?><?=$MSG_5165?></A> |
			<A HREF=viewdomainstats.php?><?=$MSG_5166?></A> |
			<A HREF=viewplatformstats.php?><?=$MSG_5318?></A>
			</p>
      </TD>
    </TR>
    <TR>
      <TD colspan="2">
        <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#FFFFFF">
          <tr>
            <td><b>
              <?=strtoupper($MSG_5164)?>
              </b></td>
          </tr>
          <tr>
            <td>
              <table border=0 callpadding=0 cellspacing=0 width=250 bgcolor=red>
                <tr>
                  <td width="22" bgcolor="#006699">&nbsp;</td>
                  <td bgcolor="#FFFFFF" width="144"><b>&nbsp;
                    <?=$MSG_5161?>
                    : </b></td>
                  <td bgcolor="#FFFFFF" width="78"><b>
                    <?=$TOTAL_PAGEVIEWS?>
                    </b></td>
                </tr>
              </table>
              <table border=0 callpadding=0 cellspacing=0 width=250 bgcolor=orange>
                <tr>
                  <td width="22" bgcolor="#66CC00">&nbsp;</td>
                  <td bgcolor="#FFFFFF" width="144"><b>&nbsp;
                    <?=$MSG_5162?>
                    : </b></td>
                  <td bgcolor="#FFFFFF" width="78"><b>
                    <?=$TOTAL_UNIQUEVISITORS?>
                    </b></td>
                </tr>
              </table>
              <table border=0 callpadding=0 cellspacing=0 width=250 bgcolor=yellow>
                <tr>
                  <td width="22">&nbsp;</td>
                  <td bgcolor="#FFFFFF" width="144"><b><font color="#000000">&nbsp;
                    <?=$MSG_5163?>
                    :<b><font color="#000000">
                    </b></td>
                  <td bgcolor="#FFFFFF" width="78">
		  	<b><font color="#000000">
                    <?=$TOTAL_USERSESSIONS?>
                    </b>
		    </font>
                  </td>
                </tr>
              </table>
              &nbsp;&nbsp;&nbsp;</td>
          </tr>
        </table>
      </TD>
    </TR>
    <TR BGCOLOR=#FFFFFF>
      <TD width="80">&nbsp;</TD>
      <TD width="692">&nbsp;</TD>
    </TR>
    <tr bgcolor="#CCCCCC">
      <td align=CENTER width="80" height="21">
        <b>
        <?=$MSG_5280?>
        </b>  </td>
      <td align=right height="21" width="692">
        <a href="viewaccessstats.php">
        <?=$MSG_5282?>
        </a>  </td>
      <?
      if(is_array($PAGEVIEWS))
      {
      	while(list($k,$v) = each($PAGEVIEWS))
      	{
		?>
			<TR BGCOLOR=yellow >
				<TD COLSPAN=2><B><?=$k?></B></TD>
			</TR>
			<?
			while(list($t,$y) = each($v))
			{
			?>
    		<TR BGCOLOR=#eeeeee>
    		  <TD width="80" ALIGN=CENTER><b>
        		<?=$t?>
        		</b> </TD>
    		  <TD width="692">
        		<table width="100%" border="0" cellspacing="0" cellpadding="0">
        		  <tr>
            		<td width="89%">
            		  <? $WIDTH = ( $PAGEVIEWS[$k][$t] * $ABSOLUTEWIDTH ) / $MAX;?>
            		  
            		  <TABLE BORDER=0 CALLPADDING=0 CELLSPACING=0 WIDTH=<?=intval($WIDTH)?> BGCOLOR=#006699>
                		<TR>
                		  <TD><B><FONT COLOR=white>
                    		<?=$PAGEVIEWS[$k][$t]?>
                    		</B></TD>
                		</TR>
            		  </TABLE>
            		</td>
        		  </tr>
        		  <tr>
            		<td width="89%">
            		  <? $WIDTH = ( $UNIQUEVISITORS[$k][$t] * $ABSOLUTEWIDTH ) / $MAX;?>
            		  
            		  <TABLE BORDER=0 CALLPADDING=0 CELLSPACING=0 WIDTH=<?=intval($WIDTH)?> BGCOLOR=#66CC00>
                		<TR>
                		  <TD><B><FONT COLOR=white>
                    		<?=$UNIQUEVISITORS[$k][$t]?>
                    		</B></TD>
                		</TR>
            		  </TABLE>
            		</td>
        		  </tr>
        		  <tr>
            		<td width="89%">
            		  <? $WIDTH = ( $USERSESSIONS[$k][$t] * $ABSOLUTEWIDTH ) / $MAX;?>
            		  
            		  <TABLE BORDER=0 CALLPADDING=0 CELLSPACING=0 WIDTH=<?=intval($WIDTH)?> BGCOLOR=#FFFF33>
                		<TR>
                		  <TD><B>
                    		<?=$USERSESSIONS[$k][$t]?>
                    		</B></TD>
                		</TR>
            		  </TABLE>
            		</td>
        		  </tr>
        		</table>
    		  </TD>
    		</TR>
    <?
			}
      	}
      }
		?>
  </TABLE>
  </TD>
  </TR>
  </TABLE>
  </BODY>
  </HTML>