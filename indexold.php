<?#

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

/*
prepare data for templates/template
*/

/* prepare categories list for templates/template */
# Prepare categories sorting
if($SETTINGS['catsorting'] == 'alpha') {
	$catsorting = " ORDER BY t.cat_name ASC";
} else {
	$catsorting = " ORDER BY sub_counter DESC";
}
$TPL_categories_value = "";
$query = "select distinct * from HB_categories c, HB_cats_translated t 
          WHERE c.parent_id=0
          AND t.cat_id=c.cat_id
          AND t.lang='".$USERLANG."'  
          $catsorting";
$result = mysql_query($query);
if(!$result) {
	MySQLError($query);
	exit;
} else {
	$num_cat = mysql_num_rows($result);
	$i = 0;
	$TPL_categories_value = "<ul>\n";
	while($i < $num_cat && $i < $SETTINGS['catstoshow']) {
		$catlink="";
		$cat_id = mysql_result($result,$i,"cat_id");
		$cat_name = mysql_result($result,$i,"cat_name");
		$sub_count = intval(mysql_result($result, $i, "sub_counter"));
		$cat_colour = mysql_result($result, $i, "cat_colour");
		$cat_image = mysql_result($result, $i, "cat_image");
		$cat_counter = (int)mysql_result($result, $i, "counter" );
		if ($sub_count!=0)
			$cat_counter = "(".$sub_count.")";
		else {
			$cat_counter = "";
		}
		$cat_url = "./browse.php?id=$cat_id";
		if ( $cat_image != "") {
			$catlink = "<A HREF=\"$cat_url\"><IMG SRC=\"$cat_image\" BORDER=0></a>";
		}
		#//  Select the translated category name
		$cat_name = @mysql_result(mysql_query("SELECT cat_name FROM HB_cats_translated WHERE cat_id=$cat_id AND lang='".$USERLANG."'"),0,"cat_name");
		$catlink .= "<A HREF=\"$cat_url\">$cat_name</A>"." $cat_counter";
		if ( $cat_colour != "") {
			$catlink = setsspan($catlink,"background-color:$cat_colour");
		}
		$TPL_categories_value .= "<li>".$catlink."</li>\n";
		$i++;
	}
	$TPL_categories_value .= "</ul>\n";
	$TPL_categories_value .= "<A HREF=\"browse.php?id=0\">$MSG_277</A>";
}
/********************************************************************************************/

//------------------------------------------------------------------------------
// prepare classic auctions values (get last created auctions)
    $query = "SELECT id,number_of_bids,title,starts, ends, pict_url, auction_type, item_value, bid_value,
			 
			number_of_bids-(SELECT COUNT(*) FROM HB_bids WHERE auction=id) AS remaining
			FROM HB_auctions
			WHERE closed='0' AND suspended=0 AND auction_type = 1 AND  is_main_auction =0 AND "; 
    if($SETTINGS['adultonly']=='y' && !isset($_SESSION["HAPPYBID_LOGGED_IN"])){ $query .= "adultonly='n' AND "; }
    $query .= " starts <= ".$NOW." ORDER BY remaining ASC LIMIT ".$SETTINGS['lastitemsnumber']; 

    $result = mysql_query($query);
    if ( $result ) $num_auction = mysql_num_rows($result);
    else $num_auction = 0;

    $i = 0;
    $TPL_auctions_classic = array();

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

        $TPL_auctions_classic[$i] = array();
        $TPL_auctions_classic[$i]["date_created"] = $month."/".$day."/".$year." ".$hours.":".$minutes.":".$seconds;
        $TPL_auctions_classic[$i]["remained_seconds"]=strtotime($TPL_auctions_classic[$i]["date_created"])-time();
		//ArrangeDateNoCorrection($day,$month,$year,$hours,$minutes);
        $TPL_auctions_classic[$i]["name"] = stripslashes($title);
        $TPL_auctions_classic[$i]["link_href"] = "./item.php?id=$id";
        $TPL_auctions_classic[$i]["pict_url"] = $pict_url;
		$TPL_auctions_classic[$i]["remained_bids"] = $remained_bids;
		$TPL_auctions_classic[$i]["item_value"] = stripslashes($item_value);
        $TPL_auctions_classic[$i]["bid_value"] = stripslashes($bid_value);
        $i++;
        
    }


/****************************************************************************************/
//------------------------------------------------------------------------------
// prepare more live auctions values (get last created auctions)
    $query = "SELECT id,number_of_bids,title,starts, ends, pict_url, auction_type, item_value, bid_value,
	number_of_bids-(SELECT COUNT(*) FROM HB_bids WHERE auction=id) AS remaining
	FROM HB_auctions WHERE closed='0' AND suspended=0 AND auction_type = 1 AND  is_main_auction =0 AND "; 
    if($SETTINGS['adultonly']=='y' && !isset($_SESSION["HAPPYBID_LOGGED_IN"])){ $query .= "adultonly='n' AND "; }
    $query .= " starts <= ".$NOW." ORDER BY remaining LIMIT ".$SETTINGS['lastitemsnumber'].",100"; 

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

//------------------------------------------------------------------------------
//// prepare main auctions values
//    $query = "SELECT id,number_of_bids,title,starts,  ends, pict_url, auction_type, minimum_users, item_value FROM HB_auctions WHERE closed='0' AND suspended=0 AND is_main_auction =1 AND ";
//    if($SETTINGS['adultonly']=='y' && !isset($_SESSION["HAPPYBID_LOGGED_IN"])){ $query .= "adultonly='n' AND "; }
//    $query .= "starts<=".$NOW." ORDER BY starts DESC LIMIT ".$SETTINGS['lastitemsnumber']; 
//
//    $result = mysql_query($query);
//    if ( $result ) $num_auction = mysql_num_rows($result);
//    else  $num_auction = 0;
//
//    $i = 0;
//    $TPL_main_auction = array();
//
//    while($i < $num_auction) {
//        $title      = mysql_result($result,$i,"title");
//        $id 	    = mysql_result($result,$i,"id");
//        $date	    = mysql_result($result,$i,"ends");
//        $pict_url   = mysql_result($result,$i,"pict_url");
//        if($pict_url == "") {$pict_url = 'no_image.png';}
//        $auction_type      = mysql_result($result,$i,"auction_type");
//        $minimum_users  = intval(mysql_result($result,$i,"minimum_users"));        
//        $current_users  = intval(mysql_result(mysql_query("SELECT COUNT(*)  as cnt FROM HB_auctions_signed WHERE auction_id=".$id),0,"cnt"));
//        $item_value = mysql_result($result,$i,"item_value");
//        
//		$number_of_bids           = mysql_result ( $result, $i, "number_of_bids" );
//		$remained_bids=$number_of_bids-$row1['current_bids'];
//		
//        $year = substr($date,0,4);          $month = substr($date,4,2);
//        $day = substr($date,6,2);           $hours = substr($date,8,2);
//        $minutes = substr($date,10,2);      $seconds = substr($date,12,2);
//    
//        #// Check bold and highlighted options
//        $ISBOLD = FALSE;                    $ISHIGHLIGHTED = FALSE;
//
//        $TPL_main_auction[$i] = array();
//        $TPL_main_auction[$i]["date_created"] = $month."/".$day."/".$year." ".$hours.":".$minutes.":".$seconds;
//        $TPL_main_auction[$i]["remained_seconds"]=strtotime($TPL_main_auction[$i]["date_created"])-time();
//		$TPL_main_auction[$i]["name"] = stripslashes($title);
//        $TPL_main_auction[$i]["link_href"] = "./item.php?id=$id";
//        $TPL_main_auction[$i]["pict_url"] = $pict_url;
//		$TPL_main_auction[$i]["auction_type"] = $auction_type;
//		$TPL_main_auction[$i]["remained_bids"] = $remained_bids;
//        $TPL_main_auction[$i]["minimum_users"] = $minimum_users;
//        $TPL_main_auction[$i]["current_users"] = $current_users;
//        $TPL_main_auction[$i]["item_value"] = stripslashes($item_value);                
//        $i++;
//    }
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
    ////// Build list of help topics
    ////$query = "SELECT * FROM HB_faqscategories";
    ////$r_h = @mysql_query($query);
    ////if(!$r_h) {
    ////    MySQLError($query);
    ////    exit;
    ////}
    //if(mysql_num_rows($r_h) > 0) {
    //    $TPL_helptopics = "<ul>";
    //    while($faqscat = mysql_fetch_array($r_h)) {
    //        $faqscat['category'] = stripslashes(@mysql_result(mysql_query("SELECT category FROM HB_faqscat_translated WHERE id=".$faqscat['id']." AND lang='".$USERLANG."'"),0,"category"));
    //        //$faqscat['category']=stripslashes($faqscat['category']);
    //        $TPL_helptopics .= "<li><a href=\"javascript: window_open('viewfaqs.php?cat=".$faqscat['id']."','faqs',500,400,20,20)\">".$faqscat['category']."</a></li>";
    //    }
    //    $TPL_helptopics .= "</ul>";
    //} else {
    //    $TPL_helptopics = "";
    //}

    //-- Build news list
    if($SETTINGS['newsbox'] == 1) {
        $query = "SELECT title,id,new_date from HB_news where suspended=0 order by new_date DESC limit ".$SETTINGS['newstoshow'];
        $res = mysql_query($query);
        if(!$res) {
            MySQLError($query);
            exit;
        }
        $TPL_news_list = "<ul>";
        while($new = mysql_fetch_array($res)) {
            $new['title'] = @mysql_result(@mysql_query("SELECT title FROM HB_news_translated WHERE id=".$new['id']." AND lang='".$USERLANG."'"),0,"title");
            $new_date= $new['new_date'];
            $F_date = FormatDate($new_date);
            $TPL_news_list .= "<li>$F_date - <a href=\"viewnew.php?id=".$new['id']."\">".$new['title']."</a></li>";
        }
        $TPL_news_list .= "</ul>";
    } else {
        $TPL_news_list = "&nbsp;";
    }
    $TPL_news_list .= "&nbsp;&nbsp;<a href='viewallnews.php'>".$MSG_31_0046."</a>";    

    
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
        ORDER BY ends DESC limit 0, 7";
	    
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
        $TPL_closed_auctions_list .= "<div id='closedtitle'><a href=\"item.php?id=".$row['id']."&history=view\"><b>".$title."</b></a></div>";
        $TPL_closed_auctions_list .= "<div id='closedimg'><a href=\"item.php?id=".$row['id']."\"  title='".$row['title']."' ><img alt='".$row['title']."' border='0' width='79px' src='".$SETTINGS['siteurl']."uploaded/".$row["pict_url"]."' /></a></div>";
        $TPL_closed_auctions_list .= "<div id='closedwintext'>Winning Bid</div>";
        $TPL_closed_auctions_list .= "<div id='closedwinbid'>&pound;".$bid."</div>";
        $TPL_closed_auctions_list .= "<div id='closedwinner'>".$winner."</div>";
        $TPL_closed_auctions_list .= "</div>";
	}
	$TPL_closed_auctions_list .= "</div>";
if ($num_results <= 0){
$TPL_closed_auctions_list .= "<h4 style='color:#cd0505;'>No auctions have ended yet</h4>";
} else {
    $TPL_closed_auctions_list .= "<div style='display: block;
    float: left;
    font-size: 11px;
    margin-left: 9px;
    margin-top: 8px;
    width: 217px;'><a style='font-weight: bold;left: 5px;position: relative;top: 4px;padding:8px 18px 7px;' href='viewallclosedauctions.php'  class='buttonbid' />See all ended auctions</a></div><div style='display: block; font-size: 11px; width: 217px; float: left; margin-top: 16px; margin-left: 10px;'><img src='images/latestwinners.png'></div><!----<div style='display: none;float: left;font-size: 14px;margin-left: 9px;margin-top: -8px;width: 217px; text-transform:capitalize;'><span class='cleantitle'>Total Savings: </span>&pound;16.82</div>---->";
}


    require(phpa_include("template_index_php.html"));
    require('./footer.php');
	
    
?>