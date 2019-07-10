<?

require('./includes/config.inc.php');

#// If user is not logged in redirect to login page
if(!isset($_SESSION["HAPPYBID_LOGGED_IN"])) {
	Header("Location: user_login.php");
	exit;
}


	$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
	$NOW = date("YmdHis",$TIME);
	
	$auction_id = isset($_POST['auction_id']) ? $_POST['auction_id'] : "";


	$TPL_my_auctions_list = "<option value=''>-- choose --</option>";
	
	// create list for 1-st type auctions
	$sql = "SELECT
			  DISTINCT(a.id), a.title, a.starts
			FROM HB_auctions a
			  INNER JOIN HB_bids b ON a.id = b.auction 
			  INNER JOIN HB_users c ON b.bidder = c.id          
			WHERE
			  b.bidder = ".intval($_SESSION['HAPPYBID_LOGGED_IN'])." AND 
			  a.closed='0' AND
			  a.suspended=0 AND
			  a.auction_type = 1 AND
			  a.starts <= ".$NOW." 
			ORDER BY a.starts DESC
			LIMIT 0, 100"; 
	
	$result = mysql_query($sql);
	while ($row=mysql_fetch_array($result)) {
		$TPL_my_auctions_list .= "<option ".(($auction_id == $row['id']) ? "selected" : "")." value='".$row['id']."'>".$row['title']."</option>";
	}
	
	// create list for 2-nd type auctions
	$sql = "SELECT
			  DISTINCT(a.id), a.title, a.starts
			FROM HB_auctions a
			  INNER JOIN HB_bids b ON a.id = b.auction 
			  INNER JOIN HB_users c ON b.bidder = c.id          
			WHERE          
			  b.bidder = ".intval($_SESSION['HAPPYBID_LOGGED_IN'])." AND
			  ((a.closed='0' AND a.starts <= ".$NOW.") OR (a.closed='1' AND a.second_starts <= ".$NOW.")) AND
			  a.suspended=0 AND 
			  a.auction_type = 2
			UNION        
			SELECT
			  DISTINCT(a.id), a.title, a.starts
			FROM HB_auctions a
			  INNER JOIN HB_auctions_signed d ON a.id = d.auction_id 
			  INNER JOIN HB_users c ON d.user_id = c.id
			WHERE          
			  d.user_id = ".intval($_SESSION['HAPPYBID_LOGGED_IN'])." AND
			  ((a.closed='0' AND a.starts <= ".$NOW.") OR (a.closed='1' AND a.second_starts <= ".$NOW.")) AND
			  a.suspended=0 AND 
			  a.auction_type = 2
			LIMIT 0, 100"; 
	
	$result = mysql_query($sql);
	while ($row=mysql_fetch_array($result)) {
		$TPL_my_auctions_list .= "<option ".(($auction_id == $row['id']) ? "selected" : "")." value='".$row['id']."'>".$row['title']."</option>";
	}
	
	
	// create list for 3-nd type auctions
	$sql = "SELECT
			  DISTINCT(a.id), a.title, a.starts
			FROM HB_auctions a
			  INNER JOIN HB_bids b ON a.id = b.auction 
			  INNER JOIN HB_users c ON b.bidder = c.id
			WHERE          
			  b.bidder = ".intval($_SESSION['HAPPYBID_LOGGED_IN'])." AND
			  ((a.closed='0' AND a.starts <= ".$NOW.") OR (a.closed='1' AND a.second_starts <= ".$NOW.")) AND
			  a.suspended=0 AND 
			  a.auction_type = 3      
			UNION        
			SELECT
			  DISTINCT(a.id), a.title, a.starts
			FROM HB_auctions a
			  INNER JOIN HB_auctions_signed d ON a.id = d.auction_id 
			  INNER JOIN HB_users c ON d.user_id = c.id
			WHERE          
			  d.user_id = ".intval($_SESSION['HAPPYBID_LOGGED_IN'])." AND
			  ((a.closed='0' AND a.starts <= ".$NOW.") OR (a.closed='1' AND a.second_starts <= ".$NOW.")) AND
			  a.suspended=0 AND 
			  a.auction_type = 3        
			LIMIT 0, 100"; 
	
	$result = mysql_query($sql);
	while ($row=mysql_fetch_array($result)) {
		$TPL_my_auctions_list .= "<option ".(($auction_id == $row['id']) ? "selected" : "")." value='".$row['id']."'>".$row['title']."</option>";
	}
	

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
		$auctions_count = 0;
		if ($result) {
			$tplv = "";
			$bgColor = "#ffffff";
			$bgColorWon = "#0000cd";
			$bgColorUnique = "#ffff00";
			$bgColorNone = "#cd0000";
			while ($row=mysql_fetch_array($result)) {
				$bid = $row['bid'];
				//$bidwhen_date = date("Y-m-d h:i:s");
				$hour = substr($row["bidwhen"],8,2)+$SETTINGS['timecorrection'];
				if($hour>24)$hour-=24;
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
								substr($row["bidwhen"],12,2);
	
				if($bgColor == "#EBEBEB") {
					$bgColor = "#FFFFFF";
				} else {
					$bgColor = "#EBEBEB";
				}
	
				$tplv .= "<tr align=\"center\" VALIGN=MIDDLE BGCOLOR=\"#FFFFFF\">"; 			
				if($won_bid == $bid) {
					$tplv .= "<td align='center' class='bidHistory lowUnique'><font color='#ffffff'><b>&pound;".$bid."</b></font></td>";	
				}elseif(in_array($bid,$unique)){
					$tplv .= "<td align='center' class='bidHistory unique'><font color='#ffffff'><b style='color:#000000'>&pound;".$bid."</b></td>";	
				}else{
					$tplv .= "<td align='center' class='bidHistory notUnique'><font color='#ffffff'><b>&pound;".$bid."</b></td>";	
				}			
				$tplv .= "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$bidwhen_date."</td>"; 
				$tplv .= "</tr>";
				$auctions_count++;
			}
			if($auctions_count > 0){
				$TPL_auctions_list_value = $tplv;				
			}else{
				$TPL_auctions_list_value = "<td colspan='2' align='center' BGCOLOR='#ffffff' style='font-size:14px;'><font color='#333333'><b>No offers found</b></td>";	
			}
		} else {
			$TPL_auctions_list_value = "<td colspan='2' align='center' BGCOLOR='#ffffff' style='font-size:14px;'><font color='#333333'><b>No offers found</b></td>";	
		}
		
	}



include "header.php";
include phpa_include("template_yourbids_php.html");
include "footer.php";

?>