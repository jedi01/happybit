<?

require('../includes/config.inc.php');
include "loggedin.inc.php";
//-- Set offset and limit for pagination
$limit = 20;
if(!$offset) $offset = 0;
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
          <td width="30"><img src="images/i_con.gif" ></td>
          <td class=white><?=$MSG_25_0018?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_516?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
    <tr> 
    <td align="center" valign="middle">
	<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#546f95" ALIGN="CENTER">
	<TR>
		<TD ALIGN=CENTER class=title>
			<? print $MSG_516; ?>
		</TD>
	</TR>
	<TR>
		<TD>
			<TABLE WIDTH=100% CELPADDING=0 CELLSPACING=1 BORDER=0 ALIGN="CENTER" CELLPADDING="3">
				<TR>
					<TD ALIGN=center COLSPAN=5 BGCOLOR=#EEEEEE>
						<B><A HREF="addnew.php">
						<? print $MSG_518; ?>
						</A></B>
					</TD>
				</TR>
				<?
				$query = "select count(id) as news from HB_news";
				$result = mysql_query($query);
				if(!$result){
					print "$ERR_001<BR>$query<BR>".mysql_error();
					exit;
				}
				$num_news = mysql_result($result,0,"news");
				print "<TR BGCOLOR=#FFFFFF><TD COLSPAN=5><B>
				$num_news $MSG_517</B></TD></TR>";
	            ?>
				<TR BGCOLOR="#dddddd">
					<TD ALIGN=CENTER WIDTH=20%> 
						<B>
						<? print $MSG_314; ?>
						</B>  </TD>
					<TD ALIGN=center WIDTH=60%> 
						<B>
						<? print $MSG_312; ?>
						</B>  </TD>
					<TD ALIGN=center> 
						<B>
						<? print $MSG_297; ?>
						</B>
					</TD>
				<TR>
					<?
					$query = "select * from HB_news order by new_date limit $offset, $limit";
					$result = mysql_query($query);
					if(!$result){
						print "Database access error: abnormal termination<BR>$query<BR>".mysql_error();
						exit;
					}
					$num_news2 = mysql_num_rows($result);
					$i = 0;
					$bgcolor = "#FFFFFF";
					while($i < $num_news2){
						
						if($bgcolor == "#FFFFFF"){
							$bgcolor = "#EEEEEE";
						}else{
							$bgcolor = "#FFFFFF";
						}
						
						$id = mysql_result($result,$i,"id");
						$title = 	stripslashes(mysql_result($result,$i,"title"));
						$tmp_date = mysql_result($result,$i,"new_date");
						$suspended = mysql_result($result,$i,"suspended");
						$day = substr($tmp_date,6,2);
						$month = substr($tmp_date,4,2);
						$year = substr($tmp_date,0,4);
						$date = "$day/$month/$year";
						
						print "<TR BGCOLOR=$bgcolor>
					<TD>
						";
						if($SETTINGS['datesformat'] != 'USA')
						{
							print "$day/$month/$year";
						}
						else
						{
							print "$month/$day/$year";
						}
						
						print " 
						</TD>
						<TD>
						";
						if($suspended == 1)
						{
							print "<FONT COLOR=red><B>$title</B>";
						}
						else
						{
							print $title;
						}
						print "
						</TD>

						<TD ALIGN=LEFT>
						<A HREF=\"editnew.php?id=$id&offset=$offset\" class=\"nounderlined\">$MSG_298</A><BR>
						<A HREF=\"deletenew.php?id=$id&offset=$offset\" class=\"nounderlined\">$MSG_299</A>
						<BR>
						</TD>
						<TR>";
						
						$i++;
					}
					
					print "</TABLE>
			   </TD></TR></TABLE>";
					
					
					
					//-- Build navigation line
					print "<TABLE WIDTH=600 BORDER=0 CELLPADDING=4 CELLSPACING=0 ALIGN=CENTER>
			   <TR ALIGN=CENTER BGCOLOR=#FFFFFF>
			   <TD COLSPAN=2>";
					
					print "<SPAN CLASS=\"navigation\">";
					$num_pages = ceil($num_news / $limit);
					$i = 0;
					while($i < $num_pages ){
						
						$of = ($i * $limit);
						
						if($of != $offset){
							print "<A HREF=\"news.php?offset=$of\" CLASS=\"navigation\">".($i + 1)."</A>";
							if($i != $num_pages) print " | ";
						}else{
							print $i + 1;
							if($i != $num_pages) print " | ";
						}
						
						$i++;
					}
					print "</SPAN></TD></TR>";
	  ?>
		</TABLE>
		</TD>
		</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>