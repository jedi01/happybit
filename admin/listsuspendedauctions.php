<?

require('../includes/config.inc.php');
include "loggedin.inc.php";
//-- Set offset and limit for pagination
$limit = 20;

$offset = isset($_REQUEST['offset'])?$_REQUEST['offset']:0;
$auc_id = isset($_REQUEST['id'])?$_REQUEST['id']:0;
//if(!$offset) $offset = 0;
$_SESSION['RETURN_LIST'] = 'listsuspendedauctions.php';
$_SESSION['RETURN_LIST_OFFSET'] = intval($_GET['offset']);

/* Validate received id and suspend an auction
* - id must be positive integer
*/
$ERR = "";
if($auc_id!=0)
{
  if(!preg_match('/^[1-9]\d{0,9}$/',$auc_id)) $ERR = "Asta ID non validi!";
  else{
    $res = mysql_query("SELECT * FROM HB_auctions WHERE id=$auc_id");
    if(!$res){
      $ERR = "Auction does not exist!";    
    }elseif(!mysql_query("UPDATE HB_auctions SET suspended=1 WHERE id=$auc_id")){
      $ERR = "Errore database. Please try again later.";
    }else
      $ERR = "Auction $auc_id has been suspended.";
  }
}
?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<?    require('../includes/styles.inc.php'); ?>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr> 
          <td width="30"><img src="images/i_auc.gif" ></td>
          <td class=white><?=$MSG_239?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_5227?></td>
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
  <TD ALIGN=CENTER class=title><? print $MSG_5227; ?></TD>
</TR>
<TR>
  <TD ALIGN=CENTER class=title><? print $ERR; ?></TD>
</TR>
<TR>
  <TD><TABLE WIDTH=100% CELPADDING=0 CELLSPACING=1 BORDER=0 ALIGN="CENTER" CELLPADDING="3">
      <?
      $query = "SELECT COUNT(id) AS auctions FROM HB_auctions WHERE suspended<>0 ";
      $result = mysql_query($query);
      if(!$result){
      	print "$ERR_001<BR>$query<BR>".mysql_error();
      	exit;
      }
      $num_auctions = mysql_result($result,0,"auctions");
      print "<TR BGCOLOR=#FFFFFF><TD COLSPAN=7><B>
				$num_auctions $MSG_311</B></TD></TR>";
	?>
      <TR BGCOLOR="#FFCC00">
        <TD ALIGN=CENTER> <B> <? print $MSG_312; ?> </B>  </TD>
        <!--<TD ALIGN=CENTER> <B> <? print $MSG_313; ?> </B>  </TD>-->
        <TD ALIGN=CENTER> <B> <? print $MSG_314; ?> </B>  </TD>
        <TD ALIGN=CENTER> <B> <? print $MSG_315; ?> </B>  </TD>
        <!--<TD ALIGN=LEFT> <B> <? print $MSG_316; ?> </B>  </TD>-->
        <TD ALIGN=LEFT> <B> <? print $MSG_317; ?> </B>  </TD>
        <TD ALIGN=LEFT> <B> <? print $MSG_297; ?> </B>  </TD>
	</tr>	
        <?
        $query = "SELECT a.* FROM
                    HB_auctions a					

					WHERE
					a.suspended<>'0'
					group by a.id ORDER BY a.title limit $offset, $limit";
        $result = mysql_query($query);
        if(!$result){
        	print "Database access error: abnormal termination<BR>$query<BR>".mysql_error();
        	exit;
        }
        $num_auction = mysql_num_rows($result);
        $i = 0;
        $bgcolor = "#FFFFFF";
        while($i < $num_auction){
        	if($bgcolor == "#FFFFFF") {
        		$bgcolor = "#EEEEEE";
        	}else{
        		$bgcolor = "#FFFFFF";
        	}
        	$id = mysql_result($result,$i,"id");
        	$title = stripslashes(mysql_result($result,$i,"title"));
        	$tmp_date = mysql_result($result,$i,"starts");
        	$duration = mysql_result($result,$i,"duration");
        	$description = strip_tags(stripslashes(mysql_result($result,$i,"description")));
        	$suspended = mysql_result($result,$i,"suspended");
        	$day = substr($tmp_date,6,2);
        	$month = substr($tmp_date,4,2);
        	$year = substr($tmp_date,0,4);
        	$date = "$day/$month/$year";
        	
        	print "<TR BGCOLOR=$bgcolor>
					<TD>";
        	if($suspended == 1) {
        		print "<FONT COLOR=red><B>$title</B>";
        	} else {
        		print $title;
        	}
        	print "
						</TD>
						<TD>
						".$date."						
						</TD>
						<TD>
						$duration						
						</TD>
						<TD>
						$description						
						</TD>
						<TD ALIGN=LEFT>
						<A HREF=\"editauction.php?id=$id&offset=$offset\" class=\"nounderlined\">$MSG_298</A><BR>
						<A HREF=\"deleteauction.php?id=$id&offset=$offset\" class=\"nounderlined\">$MSG_299</A><BR>
						<A HREF=\"excludeauction.php?id=$id&offset=$offset&mode=activate\" class=\"nounderlined\">";
        	if($suspended == 0) {
        		print $MSG_300;
        	} else {
        		print $MSG_310;
        	}
        	print "</A><BR>
						</TD>
						<TR>";
        	
        	$i++;
        }
        ?>
        </TABLE>
		<?
        //-- Build navigation line
        print "<TABLE WIDTH=100% BORDER=0 CELLPADDING=4 CELLSPACING=0 ALIGN=CENTER>
			   <TR ALIGN=CENTER BGCOLOR=#FFFFFF>
			   <TD COLSPAN=2>";
        print "<SPAN CLASS=\"navigation\">";
        $num_pages = ceil($num_auctions / $limit);
        $i = 0;
        while($i < $num_pages ){
        	$of = ($i * $limit);
        	if($of != $offset){
        		print "<A HREF=\"listsuspendedauctions.php?offset=$of\" CLASS=\"navigation\">".($i + 1)."</A>";
        		if($i != $num_pages) print " | ";
        	}else{
        		print $i + 1;
        		if($i != $num_pages) print " | ";
        	}
        	$i++;
        }
        print "</SPAN></TR></TD></TABLE>";
	  ?>
</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>