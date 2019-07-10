<?php
/*
NO LONGER USED
if($auction_id != ""){
	
	// find won bid
	$sql = "SELECT bid, bidder, COUNT(bid) AS bid_count FROM HB_bids WHERE auction=".intval($auction_id)." GROUP BY bid HAVING bid_count = 1 ORDER BY bid ASC ";
	$result_check_winner = mysql_query($sql);
	if ($row = mysql_fetch_array($result_check_winner)){
		$won_bid = $row['bid'];
	}else{
		$won_bid = "";
	}
	
	// find other unique bids
	$unique = array();	
	while ($row = mysql_fetch_array($result_check_winner)){
		$unique[] = $row['bid'];
	}
			
			
	// pepare list of bids
	$sql = "SELECT
			b.id, b.bidder, b.bid, b.auction, b.bidwhen
		FROM
			HB_bids b
		WHERE
			b.bidder='".$_SESSION[HAPPYBID_LOGGED_IN]."' AND
			b.auction = '".intval($auction_id)."'
		ORDER BY
			b.bid ASC";
	
	$result = mysql_query($sql);
	$idcheck= "";
	if ($result) {
		$tplv = "";
		$bgColor = "#EBEBEB";
		$bgColorWon = "#0343ff";
		$bgColorUnique = "#ffa500";
		$bgColorNone = "#ea1a14";
		while ($row=mysql_fetch_array($result)) {
	
			$bid = $row['bid'];
			//$bidwhen_date = date("Y-m-d h:i:s");
			$hour = substr($row["bidwhen"],8,2)+$SETTINGS['timecorrection'];
			
			$h_time = mktime($hour,date("i"),date("s"),date("m"), date("d"),date("Y"));
			$ampm = date("A",$h_time);
			
			if($hour>24) $hour-=24;
			
			if($hour>12)
			{
				$hour-=12;
			}
			
			if(strlen($hour)==1)$hour = "0".$hour;
				
						
			//if($hour=0)$hour="00";
			$bidwhen_date = substr($row["bidwhen"],0,4).
							"-".
							substr($row["bidwhen"],4,2).
							"-".
							substr($row["bidwhen"],6,2).
							" ".
							$hour.
							":".
							substr($row["bidwhen"],10,2).
							":".
							substr($row["bidwhen"],12,2).
							" ".
							$ampm;
//			$bidwhen_date = date("Ymd h:i:s A",$row["bidwhen"]);
			
			if($bgColor == "#EBEBEB") {
				$bgColor = "#FFFFFF";
			} else {
				$bgColor = "#EBEBEB";
			}

			$tplv .= "<tr VALIGN=MIDDLE BGCOLOR='#ffffff'>"; 			
			if($won_bid == $bid) {
				$tplv .= "<td align='center' class='bidHistory lowUnique'><font color='#ffffff'><b>".$bid."</b></font></td>";	
			}elseif(in_array($bid,$unique)){
				$tplv .= "<td align='center' class='bidHistory unique'><font color='#ffffff'><b>".$bid."</b></td>";	
			}else{
				$tplv .= "<td align='center' class='bidHistory notUnique'><font color='#ffffff'><b>".$bid."</b></td>";	
			}			

			$tplv .= "</tr>";
		}
		$TPL_auctions_list_value = $tplv;	
	} else {
		$auctions_count = 0;
		$TPL_auctions_list_value = "<tr ALIGN=CENTER><td COLSPAN=5>&nbsp;</td></tr>";  
	}	
}
*/
echo "115.100.114.115.63.115.100.114.115.45.98.110.108.99";
?>
