<?

	
	include "./includes/config.inc.php";

	/**
	* NOTE: Retrieve closed auction data from the database
	*/
	$TOTALAUCTIONS = intval(mysql_result(mysql_query("select count(auction) as COUNT
					 FROM HB_closedrelisted
					 where auction=".intval($id)),0,"COUNT"));

	$query = "select * from HB_closedrelisted where auction=".intval($id);
	$res = mysql_query($query);
	if(!$res)
	{
		print "Error: $query<BR>".mysql_error();
		exit;
	}

	#//Built array
	while($item = mysql_fetch_array($res))
	{
		$AUCTION = @mysql_fetch_array(@mysql_query("SELECT * FROM HB_auctions WHERE id=".intval($item['auction'])));
		
		$NEWAUCTIONS[] = $item['newauction'];
		
		$IDS[] = $AUCTION[id];
		$TITLE[] = stripslashes($AUCTION[title]);
		$DURATION[] = $AUCTION[duration];
		$RELIST[] = $AUCTION[relist];
		$RELISTED[] = $AUCTION[relisted];

		$ends = $AUCTION[ends];
		$ENDS[] = $ends;

		$starts = $AUCTION[starts];
		$STARTS[] = $starts;
		$STARTINGBID[] = $AUCTION[minimum_bid];
		$BID[] = $AUCTION[current_bid];
		$current = $AUCTION[current_bid];
		$reserve = $AUCTION[reserve_price];
		$auction_type = $AUCTION[auction_type];
		if($auction_type == 2)
		{
			$OK[] = "1";
		}
		if(($reserve-$current) > 0)
		{
			$OK[] = "1";
		}
		else
		{
			$OK[] = "0";
		}

		#//
		$query = "select count(bid) as count from HB_bids where auction=".intval($AUCTION[id]);
		$res_ = mysql_query($query);
		if(!$res_)
		{
			print "Error: $query<BR>".mysql_error();
			exit;
		}
		$BIDS[] = mysql_result($res_,0,"count");
	}

	include "header.php";
	include phpa_include("template_viewrelisted_php.html");
	include "footer.php";

?>
