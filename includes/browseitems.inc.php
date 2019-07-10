<?
if(!defined("INCLUDED")) exit("Access denied");
function browseItems($result) {
	global $SETTINGS;
	
	if ($result && mysql_num_rows($result)) {
		while ($row = mysql_fetch_array($result)) {
			/* prepare some data */
			$is_dutch = (intval($row["auction_type"])==2)?true:false;
			
			#// Check bold and highlighted options
			$ISBOLD = FALSE;
			$ISHIGHLIGHTED = FALSE;
			/* image icon */
			if ( strlen($row['pict_url'])>0 ) {
				if (intval($row["photo_uploaded"])!=0) {
					$row['pict_url'] = $SETTINGS['siteurl']."getthumb.php?w=".$SETTINGS['thumb_show']."&fromfile=uploaded/".$row['pict_url'];
				}
                $tplv['img']= "<A HREF=\"".$SETTINGS['siteurl']."item.php?id=".$row['id']."\"><IMG SRC=\"".$row['pict_url']."\" WIDTH=".$SETTINGS['thumb_show']." BORDER=0 /></A>";
			} else {
				$tplv['img']= "&nbsp;";
			}
			
			/* this subastas title and link to details */
			
			$tplv['id']=$row['id'];
			$tplv['high']=$ISHIGHLIGHTED;
			$tplv['bold']=$ISBOLD;
            $tplv['idformat']="<A HREF=\"".$SETTINGS['siteurl']."item.php?id=".$row['id']."\">";
			if($ISHIGHLIGHTED) {
				$tplv['idformat'] .= "<SPAN CLASS=hg>";
			}
			if($ISBOLD) {
				$tplv['idformat'] .= "<B>";
			}
			
			$tplv['idformat'] .= stripslashes(htmlspecialchars($row['title']));
			if($ISBOLD) {
				$tplv['idformat'] .= "</B>";
			}
			if($ISHIGHLIGHTED) {
				$tplv['idformat'] .= "</SPAN>";
			}
			$tplv['idformat'].= "</FONT></A>";
			if($row['buy_now'] > 0 && $row['bn_only']=='n' && ($row['current_bid'] == 0 || ($row['reserve_price']>0 && $row['current_bid']<$row['reserve_price']))) {
				$tplv['buy_now'] = "&nbsp;&nbsp;&nbsp;(<A HREF=".$SETTINGS['siteurl']."buy_now.php?id=".$row['id']."><IMG ALIGN=MIDDLE SRC=\"".$SETTINGS['siteurl']."images/buy_it_now.gif\" BORDER=0></A>&nbsp;
					<A HREF=javascript:window_open('".$SETTINGS['siteurl']."converter.php?AMOUNT=".$row['buy_now']."','incre',650,200,30,30)>".print_money($row['buy_now'])."</A>".")";
			}elseif($row['buy_now'] > 0 && $row['bn_only']=='y' && ($row['current_bid'] == 0 || ($row['reserve_price']>0 && $row['current_bid']<$row['reserve_price']))) {
				$tplv['buy_now'] = "&nbsp;&nbsp;&nbsp;(<A HREF=".$SETTINGS['siteurl']."buy_now.php?id=".$row['id']."><IMG ALIGN=MIDDLE SRC=\"".$SETTINGS['siteurl']."images/bn_only.png\" BORDER=0></A>&nbsp;
					<A HREF=javascript:window_open('".$SETTINGS['siteurl']."converter.php?AMOUNT=".$row['buy_now']."','incre',650,200,30,30)>".print_money($row['buy_now'])."</A>".")";
			} else {
				$tplv['buy_now']='';
			}
			/* current bid of this subastas */
			if($row['current_bid'] == 0) {
				$row['current_bid'] = $row['minimum_bid'];
			}
            if($row['buy_now'] > 0 && $row['bn_only']=='y') {
                $row['current_bid'] = $row['buy_now'];
            }
			$tplv['bid'] =$row['current_bid'];
			
			/* number of bids for this subastas */
			$tmp_res = mysql_query ( "SELECT bid FROM HB_bids WHERE auction='".$row['id']."'" );
			if ( $tmp_res )	$num_bids = mysql_num_rows($tmp_res);
			else $num_bids = 0;
			$rpr = (int)$row['reserved_price'];
			if ($rpr!=0)
			$reserved_price = " <IMG SRC=\"images/r.gif\"> ";
			else
			$reserved_price = "";
			$tplv['rpr']= $reserved_price.$num_bids."";
			
			/* time left till the end of this subastas */
            $s_difference = time()-mktime(    substr ($row["starts"], 8, 2),
            substr ($row["starts"], 10, 2),
            substr ($row["starts"], 12, 2),
            substr ($row["starts"], 4, 2),
            substr ($row["starts"], 6, 2),
            substr ($row["starts"], 0, 4));
            $nowt    = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
			$difference = mktime(	substr ($row["ends"], 8, 2),
			substr ($row["ends"], 10, 2),
			substr ($row["ends"], 12, 2),
			substr ($row["ends"], 4, 2),
			substr ($row["ends"], 6, 2),
			substr ($row["ends"], 0, 4))-$nowt;
			$days_difference = floor($difference / 86400);
			$difference = $difference % 86400;
			$hours_difference = floor($difference / 3600);
			$difference = $difference % 3600;
			$minutes_difference = floor($difference / 60);
			$seconds_difference = $difference % 60;
			$tplv['diff']= sprintf("%dd %s<BR>%02dh:%02dm:%02ds",$days_difference,$MSG_097, $hours_difference,$minutes_difference,$seconds_difference);
			$TPL_auctions_list_value[] = $tplv;
		}
	} else {
		$TPL_auctions_list_value=array();
	}
	return $TPL_auctions_list_value;
}
?>