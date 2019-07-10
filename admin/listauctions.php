<?

require('../includes/config.inc.php');
include "loggedin.inc.php";
include $include_path.'dates.inc.php';

$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
$NOW = date("YmdHis",$TIME);

//-- Set offset and limit for pagination
$limit = 20;
if(!$_GET[offset]) {
  $offset = 0;
} else {
  $offset = $_GET[offset];
}
$_SESSION['RETURN_LIST'] = 'listauctions.php';
$_SESSION['RETURN_LIST_OFFSET'] = intval($_GET['offset']);

$action = isset($_GET['action'])?$_GET['action']:"";
$res_id = isset($_GET['res_id'])?$_GET['res_id']:0;

$ERR = "";
if($action == "reset" && is_numeric($res_id) && $res_id>0)
{    
    $sql = "SELECT * FROM HB_auctions WHERE id=$res_id";
    $res = mysql_query($sql);
    if($row1 = mysql_fetch_assoc($res))
    {
        $starts = $NOW;
        $ends_time = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
        $ends = date("YmdHis", ($ends_time + ($row1['duration']*3600*24)) );
        $second_starts = $ends;
        $second_ends_time = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d")+$row1['duration'],date("Y"));
        $second_ends = date("YmdHis", ($second_ends_time+$row1['second_duration']*60) );
        if($row1['auction_type']==1)
        {
            $sql = "UPDATE HB_auctions
                    SET
                        starts='$starts',
                        ends='$ends',
                        closed=0,
                        suspended=0
                    WHERE id=$res_id";
        }else{
            $sql = "UPDATE HB_auctions
                    SET
                        starts='$starts',
                        ends='$ends',
                        second_starts='$second_starts',
                        second_ends='$second_ends',
                        closed=0,
                        suspended=0
                    WHERE id=$res_id";            
        }
        if(mysql_query($sql))$ERR = $MSG_31_0062;
        else{
            print "Database access error: abnormal termination<BR>$sql<BR>".mysql_error();
            exit;
        }
    }
}
?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<script type="javascript">
function reset_auction()
{
  var answer = confirm("Are you sure you want to reset auction?");
  if(answer)alert("ok");
}
</script>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div class="admintitle">Running Auctions</div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px">
  <tr>
    <td align="center" valign="middle"><TABLE WIDTH="95%" BORDER="3" CELLSPACING="0" CELLPADDING="1" ALIGN="CENTER" bordercolor="#3399CC">
        <TR>
            <TD>
            <TABLE WIDTH=100% CELLPADDING=4 CELLSPACING=1 BORDER=0 ALIGN="CENTER">
              <B><?=$ERR?></B>
              <?
              $query = "select count(id) as auctions from HB_auctions
                  WHERE (auction_type='1' AND closed='0') OR
                        ((auction_type='2' OR auction_type='3') AND (closed != '2')) ";
              $result = mysql_query($query);
              if(!$result){
              	print "$ERR_001<BR>$query<BR>".mysql_error();
              	exit;
              }
              $num_auctions = mysql_result($result,0,"auctions");
              print "<TR BGCOLOR=#FFFFFF>
				<TD COLSPAN=6>
				<B style=font-size:14px>
				$num_auctions auctions running</B> 
		  		</TD>
				</TR>";
	?>
              <TR BGCOLOR="#FFCC00">
                <TD ALIGN=LEFT> <B> Auction Title </B>  </TD>
                <TD ALIGN=LEFT> <B> ID </B>  </TD>
                <TD ALIGN=LEFT> <B> Date Started </B>  </TD>
                <TD ALIGN=CENTER> <B> Bids Left </B>  </TD>
                <TD ALIGN=CENTER> <B> Coins/Bid </B>  </TD>
                <TD ALIGN=LEFT> <B> Actions </B>  </TD>				
              <TR>
                <?
                  $query = "SELECT 
                            DISTINCT(a.id), a.title, a.starts, a.ends, a.description, a.suspended, auction_type, a.number_of_bids, a.bid_value
                            
                        FROM HB_auctions a
                          
                        WHERE (auction_type='1' AND closed='0') OR
                            ((auction_type='2' OR auction_type='3') AND (closed != '2'))
                			ORDER BY a.starts DESC limit $offset, $limit";                            
				
                // $query = "SELECT DISTINCT(a.id), u.username, a.title, a.starts, a.description, a.suspended, auction_type,
                //			c.cat_name, d.description as duration 
                //			FROM 	HB_auctions a, 
                //					HB_adminusers u, 
                //					HB_categories c, 
                //					HB_durations d 
                //            WHERE (a.auction_type='1' AND a.closed='0') OR 
                //                  ((a.auction_type='2' OR a.auction_type='3') AND (a.closed != '2'))
                //			ORDER BY username limit $offset, $limit";
                $result = mysql_query($query);
                if(!$result){
                	print "Database access error: abnormal termination<BR>$query<BR>".mysql_error();
                	exit;
                }
                $num_auction = mysql_num_rows($result);
                $i = 0;
                $bgcolor = "#FFFFFF";
                while($i < $num_auction){
                	
                	if($bgcolor == "#FFFFFF"){
                		$bgcolor = "#EEEEEE";
                	}else{
                		$bgcolor = "#FFFFFF";
                	}
                	$id = mysql_result($result,$i,"id");
					$bidvalue = mysql_result($result,$i,"bid_value");
                	$title = stripslashes(mysql_result($result,$i,"title"));
                	//$nick = mysql_result($result,$i,"nick");
                	$tmp_date = mysql_result($result,$i,"starts");
                	$number_of_bids = mysql_result($result,$i,"number_of_bids");

					$query1 = "SELECT COUNT(*) as current_bids FROM HB_bids WHERE auction=".intval($id);
					$result1=mysql_query($query1);
					$row1=mysql_fetch_array($result1);
					$remained_bids=$number_of_bids-$row1['current_bids'];

                	//$category = mysql_result($result,$i,"cat_name");
					$auction_type = mysql_result($result,$i,"auction_type");
                	$description = strip_tags(stripslashes(mysql_result($result,$i,"description")));
                	$suspended = mysql_result($result,$i,"suspended");
                	$day = substr($tmp_date,6,2);
                	$month = substr($tmp_date,4,2);
                	$year = substr($tmp_date,0,4);
                	$date = "$day/$month/$year";
                    $start_date=mysql_result($result,$i,"starts");
                    $end_date=mysql_result($result,$i,"ends");
					
			?>
              <TR BGCOLOR="<?=$bgcolor?>">
                <TD>
                  <?
                  if($suspended == 1) {
                  	print "<FONT COLOR=red><B>$title</B>";
                  } else {
                  	print $title;
                  }
			?>
                </TD>
                <!--<TD><?//=$nick?></TD>-->
                <TD>
                  <?=$id?>
                </TD>
                <TD>
                  <?=$date?>
                </TD>
                <TD align="center">
                <?
                    echo "".$remained_bids;
                    echo " of ";
					echo "".$number_of_bids;
                    
                  ?>
                </TD>
                <TD align="center">
                  <?=$bidvalue?>
                </TD>
				
                <TD ALIGN=LEFT nowrap>
                  <A HREF="editauction.php?id=<?=$id?>&offset=<?=$offset?>" class="buttonadminblue"><?=$MSG_298?></A>
                  <A HREF="deleteauction.php?id=<?=$id?>&offset=<?=$offset?>" class="buttonadminblue"><?=$MSG_299?></A>
                  <?
                     if(($auction_type==2) || ($auction_type==3)){
                        echo "<A HREF='users_signed.php?id=".$id."' class='buttonadminblue'>Users signed</A>";
                        echo "<A HREF='ignore_minimal_users.php?id=".$id."' class='buttonadminblue'>Ignore minimum</A>";
                     }
                  ?>
                  <A HREF="listsuspendedauctions.php?id=<?=$id?>&offset=<?=$offset?>" class="buttonadminblue"><?=$MSG_300?></A>
                  
                  
                  <!--- added by mike ---->
                  
                  <A HREF="auction_users_bids.php?aid=<?=$id?>&<?=$title?>" class="buttonadminblue">Bids History</A>
                  
                  <!--->
			    
		  <!--<A HREF="#" onClick="reset_auction();" class="nounderlined">Reset</A><BR>-->
				  <BR>
                </TD>
              </TR>
                <?
                $i++;
                }
		?>
            </TABLE></TD>
        </TR>
      </TABLE>
      <TABLE WIDTH=600 BORDER=0 CELLPADDING=4 CELLSPACING=0 ALIGN=CENTER>
        <TR ALIGN=CENTER BGCOLOR=#FFFFFF>
          <TD COLSPAN=2><SPAN CLASS="navigation">
            <?
            $num_pages = ceil($num_auctions / $limit);
            $i = 0;
            while($i < $num_pages ){
            	
            	$of = ($i * $limit);
            	
            	if($of != $offset){
            		print "<A HREF=\"listauctions.php?offset=$of\" CLASS=\"navigation\">".($i + 1)."</A>";
            		if($i != $num_pages) print " | ";
            	}else{
            		print $i + 1;
            		if($i != $num_pages) print " | ";
            	}
            	
            	$i++;
            }
	  ?>
            </SPAN> </TD>
        </TR>
      </TABLE></TD>
  </TR>
</TABLE>
</td>
</tr>
</table>
</BODY>
</HTML>
