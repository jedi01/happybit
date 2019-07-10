<?

require('./includes/config.inc.php');

#// Run cron according to SETTINGS
if($SETTINGS['cron'] == 2) { include_once "cron.php"; }

require("./header.php");


  $query1 = "select * from HB_users where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
  $result1 = @mysql_query($query1);
 
  if(!$result) {
      MySQLError($query1);
      exit;
  } else {
      $USER = mysql_fetch_array($result1);
      $USER_ID = $USER['id'];
      $USER_BAL = $USER['balance'];
if($_SESSION["HAPPYBID_LOGGED_IN"]) { 
$query_refs = "SELECT COUNT(referrer) FROM HB_users where referrer=".$USER_ID."";  
$result_refs = mysql_query($query_refs) or die(mysql_error()); 
foreach(mysql_fetch_array($result_refs) as $total_referrals);
}

  }

$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
//echo "<br />";
$NOW = date("YmdHis",$TIME);

/********************************************************************************************/

//------------------------------------------------------------------------------
// prepare ending auctions values (get last created auctions) TIMED AUCTIONS
    $query = "SELECT id,number_of_bids,title,starts, itemends, pict_url, auction_type, item_value, bid_value, timed_auction,
			number_of_bids-(SELECT COUNT(*) FROM HB_bids WHERE auction=HB_auctions.id) AS remaining
			FROM HB_auctions
			WHERE closed='0' AND suspended=0 AND auction_type = 1 AND timed_auction = 'y' AND "; 
    if($SETTINGS['adultonly']=='y' && !isset($_SESSION["HAPPYBID_LOGGED_IN"])){ $query .= "adultonly='n' AND "; }
    $query .= " starts <= ".$NOW." ORDER BY remaining ASC LIMIT 1"; 

    $result = mysql_query($query);
    if ( $result ) $num_auction = mysql_num_rows($result);
    else $num_auction = 0;

    $i = 0;
    $TPL_auctions_timed = array();

    while($i < $num_auction) {
        
        $title      = mysql_result($result,$i,"title");
        $id 	    = mysql_result($result,$i,"id");
        $my_end	    = mysql_result($result,$i,"itemends");
        $pict_url   = mysql_result($result,$i,"pict_url");
        if($pict_url == "") {$pict_url = 'no_image.png';}
        $auction_type      = mysql_result($result,$i,"auction_type");
        $item_value = mysql_result($result,$i,"item_value");
        $bid_value = mysql_result($result,$i,"bid_value");
		
		$query1 = "SELECT COUNT(*) as current_bids FROM HB_bids WHERE auction=".intval($id);
		$result1=mysql_query($query1);
		$row1=mysql_fetch_array($result1);

		$number_of_bids           = mysql_result ( $result, $i, "number_of_bids" );
		$remained_bids=$number_of_bids-$row1['current_bids'];
        
        $bidscount = ($number_of_bids - $remained_bids);
        
if ($timed_auction == 'y' && $valuestep == 'y') {
if ($bidscount >= 1000) {
$item_value = '500';
}  elseif ($bidscount >= 900) {
$item_value = '450';
}  elseif ($bidscount >= 800) {
$item_value = '400';
} elseif ($bidscount >= 700) {
$item_value = '350';
} elseif ($bidscount >= 600) {
$item_value = '300';
} elseif ($bidscount >= 500) {
$item_value = '250';
} elseif ($bidscount >= 400) {
$item_value = '200';
} elseif ($bidscount >= 300) {
$item_value = '150';
} elseif ($bidscount >= 200) {
$item_value = '100';
} elseif ($bidscount >= 100) {
$item_value = '75';
} elseif ($bidscount <= 99) {
$item_value = '50';
}
}
        
        $NOW = date("YmdHis",mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y")));
        $timeleft = (strtotime($my_end) - strtotime($NOW));
        
        $year = substr($date,0,4);          $month = substr($date,4,2);
        $day = substr($date,6,2);           $hours = substr($date,8,2);
        $minutes = substr($date,10,2);      $seconds = substr($date,12,2);
    
        #// Check bold and highlighted options
        $ISBOLD = FALSE;                    $ISHIGHLIGHTED = FALSE;

        $TPL_auctions_timed[$i] = array();
        $TPL_auctions_timed[$i]["date_created"] = $month."/".$day."/".$year." ".$hours.":".$minutes.":".$seconds;
        $TPL_auctions_timed[$i]["remained_seconds"]=strtotime($TPL_auctions_ending[$i]["date_created"])-time();
		//ArrangeDateNoCorrection($day,$month,$year,$hours,$minutes);
        $TPL_auctions_timed[$i]["name"] = stripslashes($title);
        $TPL_auctions_timed[$i]["link_href"] = "./item.php?id=$id";
        $TPL_auctions_timed[$i]["pict_url"] = $pict_url;
		$TPL_auctions_timed[$i]["remained_bids"] = $remained_bids;
		$TPL_auctions_timed[$i]["item_value"] = stripslashes($item_value);
        $TPL_auctions_timed[$i]["bid_value"] = stripslashes($bid_value);
        $i++;
        
    }
    
/****************************************************************************************/

//------------------------------------------------------------------------------
// prepare ending auctions values (get last created auctions) TOP OF INDEX PAGE ENDING SOON AUCTIONS
    $query = "SELECT id,number_of_bids,title,starts, ends, pict_url, auction_type, item_value, bid_value,
			number_of_bids-(SELECT COUNT(*) FROM HB_bids WHERE auction=HB_auctions.id) AS remaining
			FROM HB_auctions
			WHERE closed='0' AND suspended=0 AND auction_type = 1 AND timed_auction = 'n' AND "; 
    if($SETTINGS['adultonly']=='y' && !isset($_SESSION["HAPPYBID_LOGGED_IN"])){ $query .= "adultonly='n' AND "; }
    $query .= " starts <= ".$NOW." ORDER BY remaining ASC LIMIT 3"; 

    $result = mysql_query($query);
    if ( $result ) $num_auction = mysql_num_rows($result);
    else $num_auction = 0;

    $i = 0;
    $TPL_auctions_ending = array();

    while($i < $num_auction) {
        
        $title      = mysql_result($result,$i,"title");
        $id 	    = mysql_result($result,$i,"id");
        $date	    = mysql_result($result,$i,"ends");
        $pict_url   = mysql_result($result,$i,"pict_url");
        if($pict_url == "") {$pict_url = 'no_image.png';}
        $auction_type      = mysql_result($result,$i,"auction_type");
        $item_value = mysql_result($result,$i,"item_value");
        $bid_value = mysql_result($result,$i,"bid_value");
		
		$query1 = "SELECT COUNT(*) as current_bids FROM HB_bids WHERE auction=".intval($id);
		$result1=mysql_query($query1);
		$row1=mysql_fetch_array($result1);

		$number_of_bids           = mysql_result ( $result, $i, "number_of_bids" );
		$remained_bids=$number_of_bids-$row1['current_bids'];
        
        $year = substr($date,0,4);          $month = substr($date,4,2);
        $day = substr($date,6,2);           $hours = substr($date,8,2);
        $minutes = substr($date,10,2);      $seconds = substr($date,12,2);
    
        #// Check bold and highlighted options
        $ISBOLD = FALSE;                    $ISHIGHLIGHTED = FALSE;

        $TPL_auctions_ending[$i] = array();
        $TPL_auctions_ending[$i]["date_created"] = $month."/".$day."/".$year." ".$hours.":".$minutes.":".$seconds;
        $TPL_auctions_ending[$i]["remained_seconds"]=strtotime($TPL_auctions_ending[$i]["date_created"])-time();
		//ArrangeDateNoCorrection($day,$month,$year,$hours,$minutes);
        $TPL_auctions_ending[$i]["name"] = stripslashes($title);
        $TPL_auctions_ending[$i]["link_href"] = "./item.php?id=$id";
        $TPL_auctions_ending[$i]["pict_url"] = $pict_url;
		$TPL_auctions_ending[$i]["remained_bids"] = $remained_bids;
		$TPL_auctions_ending[$i]["item_value"] = stripslashes($item_value);
        $TPL_auctions_ending[$i]["bid_value"] = stripslashes($bid_value);
        $i++;
        
    }
    
/****************************************************************************************/
//------------------------------------------------------------------------------
// prepare more live auctions values (get last created auctions)
    $query = "SELECT id,number_of_bids,title,starts, ends, pict_url, auction_type, item_value, bid_value,
	number_of_bids-(SELECT COUNT(*) FROM HB_bids WHERE auction=HB_auctions.id) AS remaining
	FROM HB_auctions WHERE closed='0' AND suspended=0 AND auction_type = 1 AND timed_auction = 'n' AND is_main_auction =0 AND "; 
    if($SETTINGS['adultonly']=='y' && !isset($_SESSION["HAPPYBID_LOGGED_IN"])){ $query .= "adultonly='n' AND "; }
    $query .= " starts <= ".$NOW." ORDER BY remaining ASC LIMIT 3,100"; 

    $result = mysql_query($query);
    if ( $result ) $num_auction = mysql_num_rows($result);
    else $num_auction = 0;

    $i = 0;
    $TPL_more_auctions = array();

    while($i < $num_auction) {
        
        $title      = mysql_result($result,$i,"title");
        $id 	    = mysql_result($result,$i,"id");
        $date	    = mysql_result($result,$i,"ends");
        $pict_url   = mysql_result($result,$i,"pict_url");
        if($pict_url == "") {$pict_url = 'no_image.png';}
        $auction_type      = mysql_result($result,$i,"auction_type");
        $item_value = mysql_result($result,$i,"item_value");
        $bid_value = mysql_result($result,$i,"bid_value");
		
		$query1 = "SELECT COUNT(*) as current_bids FROM HB_bids WHERE auction=".intval($id);
		$result1=mysql_query($query1);
		$row1=mysql_fetch_array($result1);

		$number_of_bids           = mysql_result ( $result, $i, "number_of_bids" );
		$remained_bids=$number_of_bids-$row1['current_bids'];
        
        $year = substr($date,0,4);          $month = substr($date,4,2);
        $day = substr($date,6,2);           $hours = substr($date,8,2);
        $minutes = substr($date,10,2);      $seconds = substr($date,12,2);
    
        #// Check bold and highlighted options
        $ISBOLD = FALSE;                    $ISHIGHLIGHTED = FALSE;

        $TPL_more_auctions[$i] = array();
        $TPL_more_auctions[$i]["date_created"] = $month."/".$day."/".$year." ".$hours.":".$minutes.":".$seconds;
        $TPL_more_auctions[$i]["remained_seconds"]=strtotime($TPL_more_auctions[$i]["date_created"])-time();
		//ArrangeDateNoCorrection($day,$month,$year,$hours,$minutes);
        $TPL_more_auctions[$i]["name"] = stripslashes($title);
        $TPL_more_auctions[$i]["link_href"] = "./item.php?id=$id";
        $TPL_more_auctions[$i]["pict_url"] = $pict_url;
		$TPL_more_auctions[$i]["remained_bids"] = $remained_bids;
		$TPL_more_auctions[$i]["item_value"] = stripslashes($item_value);
        $TPL_more_auctions[$i]["bid_value"] = stripslashes($bid_value);
        $i++;
        
    }

/****************************************************************************************/


/**
* NOTE: get higher bids
*/
$TPL_maximum_bids = "";
$query = "select auction,max(bid) AS max_bid
         FROM HB_bids b, HB_auctions a WHERE a.suspended=0 AND a.closed=0 AND a.id=b.auction GROUP BY b.bid,b.auction ORDER BY max_bid desc";
$result = mysql_query($query);

if ($result)
	$num_auction = mysql_num_rows($result);
else
	$num_auction = 0;

$i = 0;
$j = 0;
$bgcolor = "#FFFFFF";
$AU = array();

while($i < $num_auction && $j < $SETTINGS['higherbidsnumber']) {
	$max_bid  = mysql_result($result,$i,"max_bid");
	$auction  = mysql_result($result,$i,"auction");

	//-- Get auction data

	$query = "SELECT title,closed,id from HB_auctions
	         WHERE id=\"$auction\" AND";
			 $query .= "'".$NOW."'>=starts";
	//print $query;
	$result_bid = mysql_query($query);
	if(mysql_num_rows($result_bid) > 0) {
		$title = mysql_result($result_bid,0,"title");
		$closed = mysql_result($result_bid,0,"closed");
		$auc_id = mysql_result($result_bid,0,"id");
	}

	if($closed == "0" && !in_array($auction,$AU)) {
		#// Check bold and highlighted options
		$ISBOLD = FALSE;
		$ISHIGHLIGHTED = FALSE;


		$TPL_maximum_bids .="
		                    <p style=\"background-color:$bgcolor;display:block\"><A HREF=javascript:window_open('converter.php?AMOUNT=$max_bid','incre',650,200,30,30)>"
		                    .print_money ($max_bid)."&nbsp;<A HREF=\"./item.php?id=$auc_id\">";
		if($ISHIGHLIGHTED) {
			$TPL_maximum_bids .= "<SPAN CLASS=hg>";
		}
		if($ISBOLD) {
			$TPL_maximum_bids .= "<B>";
		}
		$TPL_maximum_bids .= stripslashes($title);
		if($ISBOLD) {
			$TPL_maximum_bids .= "</B>";
		}
		if($ISHIGHLIGHTED) {
			$TPL_maximum_bids .= "</SPAN>";
		}
		$TPL_maximum_bids .= "</A></p>";
		if($bgcolor == "#FFFFFF") {
			$bgcolor = $FONTCOLOR[$SETTINGS['headercolor']];
		} else {
			$bgcolor = "#FFFFFF";
		}
		$AU[] = $auction;
		$j++;
	}
	$i++;
}

    
    //-- Build closed auctions list    
	$query = "SELECT
            a.title, a.id, a.pict_url,
            w.bid, w.winner, IF(w.closingdate IS NULL,a.ends,w.closingdate) AS closingdate, w.bid,
            u.nick
        FROM HB_auctions a
            LEFT OUTER JOIN HB_winners w ON a.id = w.auction
            LEFT OUTER JOIN HB_users u ON w.winner = u.id
        WHERE
            (auction_type = '1' AND closed = '1') OR
            ((auction_type = '2' OR auction_type = '3') AND closed = '2')            
        ORDER BY closingdate DESC limit 0, 7";
	    
    $res = mysql_query($query);
     $num_results = mysql_num_rows($res); 
	if(!$res) {
		//MySQLError($query);
		//exit;
	}
	$TPL_closed_auctions_list = "<div style='margin-bottom: 12px;
    margin-top: 14px;'>";
	while($row = mysql_fetch_array($res)) {
		$title = ((strlen($row['title']) > 28) ? substr($row['title'], 0, 22)."..." : $row['title']);
        $closed_date = $row['closingdate'];
        $pict_url   = $row['pict_url'];
        if($pict_url == "") {$pict_url = 'no_image.png';}
        $winner = ((strlen($row['nick']) > 9) ? substr($row['nick'], 0, 9)."" : $row['nick']);
		$bid = number_format($row['bid'], 2);
		$F_date = FormatDate($closed_date);
        $TPL_closed_auctions_list .= "<div id='closedHP'>";
        $TPL_closed_auctions_list .= "<div id='closedtitle'><a href=\"item.php?id=".$row['id']."&history=view?reload\"><b>".$title."</b></a></div>";
        $TPL_closed_auctions_list .= "<div id='closedimg'><a href=\"item.php?id=".$row['id']."&history=view?reload\"><img alt='".$row['title']."' style='border:1px solid #DDDDDD;' width='100px' src='".$SETTINGS['siteurl']."uploaded/".$row["pict_url"]."' /></a></div>";
        $TPL_closed_auctions_list .= "<div id='closedwinbid'>&pound;".$bid."</div>";
        $TPL_closed_auctions_list .= "<div id='closedwinner' style='font-size:12px'>Winner:</div>";
        $TPL_closed_auctions_list .= "<div id='closedwinner'>".$winner."</div>";
        $TPL_closed_auctions_list .= "</div>";
	}
	$TPL_closed_auctions_list .= "</div>";
if ($num_results <= 0){
$TPL_closed_auctions_list .= "<h4 style='color:#cd0505;'>No auctions have ended yet</h4>";
} else {
    $TPL_closed_auctions_list .= "<div id='viewwinners'><a href='viewallclosedauctions.php'  class='buttonbid closedbutton' />See all ended auctions</a></div>
    <div class='winnersimage'><img src='images/latestwinners.png'></div><!----<div style='display: none;float: left;font-size: 14px;margin-left: 9px;margin-top: -8px;width: 217px; text-transform:capitalize;'><span class='cleantitle'>Total Savings: </span>&pound;16.82</div>---->";
}


    require(phpa_include("template_index_php.html"));
    require('./footer.php');
	
    
?>