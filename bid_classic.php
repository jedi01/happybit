<?

include "./includes/config.inc.php";

include $include_path."auction_types.inc.php";
include $include_path."dates.inc.php";
$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
$NOW = date("YmdHis",$TIME);

#// Run cron according to SETTINGS
if($SETTINGS['cron'] == 2) { include_once "cron.php"; }

// Get number of offers for 2-nd and 3-rd type of auctions
function get_HOW_MANY($auction_id)
{
    $how_many = "&nbsp;";
    if(isset($_SESSION["HAPPYBID_LOGGED_IN"])) {
        $sql = "SELECT asi.offers
                FROM HB_auctions_signed asi
                INNER JOIN HB_auctions a ON asi.auction_id=a.id
                WHERE asi.user_id=".$_SESSION["HAPPYBID_LOGGED_IN"]." AND
                    asi.auction_id=".$auction_id." AND a.auction_type>1";
        $res = mysql_query($sql);
        if($res){
            if(mysql_num_rows($res)>0){
                $row1 = mysql_fetch_array($res);
                $how_many = "Your number of offers available for this auction are: ".$row1['offers'];
            }
        }
    }
	return $how_many;
}

//--------------------------------------------------------------------------
// gets random integer
//--------------------------------------------------------------------------
function getRandomInt($length = 20) {
    $template = "1234567890abcdefghijklmnopqrstuvwxyz";
    //$template = "1234567890";
    settype($template, "string");
    settype($length, "integer");
    settype($rndstring, "string");
    settype($a, "integer");
    settype($b, "integer");
       
    for ($a = 0; $a <= $length; $a++) {
        $b = rand(0, strlen($template) - 1);
        $rndstring .= $template[$b];
    }       
    return $rndstring;       
}

    #// ################################################
    #// Is the seller logged in?
    /*if(!isset($_SESSION['HAPPYBID_LOGGED_IN']))
    {
        $REDIRECT_AFTER_LOGIN = "boards.php";
        $_SESSION['REDIRECT_AFTER_LOGIN']=$REDIRECT_AFTER_LOGIN;
    
        Header("Location: user_login.php");
        exit;

    }*/
    
    if (!$id) $id = $_REQUEST[id];
    if (!$bid) $bid = $_REQUEST[bid];

    $auction_type = $_POST['auction_type'];
    $type = $_POST['form_type'];    
    $TPL_id = $id;

    /** first check if valid auction ID passed */
    $result = mysql_query("SELECT * FROM HB_auctions WHERE id=".intval($id));
    // SQL error
    if (!$result)
    {
        MySQLError($query);
        exit;
    }
	
	//030313 - START - GET CURRENT WINNER DETAILS
$queryWinner = "select min(bid) AS minbid, bidder, auction FROM HB_bids WHERE auction=".intval($id)." GROUP BY bid HAVING count(*)=1";
$result_bids = mysql_query($queryWinner);

if ( mysql_num_rows($result_bids ) > 0) {
    $min_bidder_bid = mysql_result ( $result_bids, 0, "minbid" );
    $min_bidder_id = mysql_result ( $result_bids, 0, "bidder" );
    $min_bidder_aid= mysql_result ( $result_bids, 0, "auction" );
   $queryWinner2 = "select email,nick from HB_users WHERE id=".$min_bidder_id;
   $result_winner = mysql_query($queryWinner2);
   $min_bidder_email = mysql_result ( $result_winner, 0, "email" );
   $min_bidder_nick = mysql_result ( $result_winner, 0, "nick" );
}

//030313 - END - GET CURRENT WINNER DETAILS

    $Data = mysql_fetch_array($result);
    $n = mysql_num_rows($result);
    $TPL_title = htmlspecialchars($Data['title']);
    $TPL_id_value = $id;
    $TPL_auctions_list_value = "";
    
    $query = "select bid,id from HB_bids where auction=\"".intval($id)."\" ORDER BY id DESC";
    $result___ = mysql_query($query);
    if (mysql_num_rows($result___) > 0) {
        $ARETHEREBIDS = "<A HREF=\"".$SETTINGS['siteurl']."item.php?id=$id&history=view#history\">$MSG_105</A>";
        $CURRENTBID_ID = mysql_result($result___,0,"id");
    } else {
        unset($TPL_BIDS_value);
    }

    # // ###############################
    // $ITEM = mysql_fetch_array($result);
    // such auction does not exist, so exit
    if ($n == 0)
    {
        include("header.php");
        $TPL_errmsg = $ERR_606;
        include(phpa_include("template_bid_php.html"));        
        include("footer.php");
        exit;
    }
    
    # // ###############################    
if ($_POST['bid_type']=='simple' && !is_numeric($_POST['bid']))
    {
      include("header.php");
        $TPL_errmsg = "You must enter a single number and not text.<br><br>e.g. If your guess is ". print_money('1.28') . " just enter 1.28<br><br><a href='item.php?id=$TPL_id_value&history=view#history' class='buttonbid'>
Back To Auction</a>";
       $bidH = $_POST['bid'];

        // Show list of bids
         $auction_id = $id;
        include_once("bid_list.php");

          include(phpa_include("template_bid_php.html"));        
         include("footer.php");
       exit;
    }else if(
             $_POST['bid_type']=='range'
             &&
             (!is_numeric($_POST['bid_from']) || !is_numeric($_POST['bid_to']))            
            )
    {
        include("header.php");
        $TPL_errmsg = $ERR_058;
        $bidH = $_POST['bid_from'];

        // Show list of bids
        $auction_id = $id;
        include_once("bid_list.php");

        include(phpa_include("template_bid_php.html"));        
        include("footer.php");
        exit;
    }
/*
else if(
             (floatval($_POST['bid_from'])-intval($_POST['bid_from']))!=0.00
             ||
             (floatval($_POST['bid_to'])-intval($_POST['bid_to']))!=0.00        
            )
    {
        include("header.php");
        $TPL_errmsg = $ERR_058;
        $bidH = $_POST['bid_from'];

        // Show list of bids
        $auction_id = $id;
        include_once("bid_list.php");

        include(phpa_include("template_bid_php.html"));        
        include("footer.php");
        exit;
    }
*/

    # // ###############################
    # check if the bids are more than 0
    if ($_POST['bid_type']=='simple' && $_POST['bid']<=0)
    {
        include("header.php");
        $TPL_errmsg = "The bid must be greater than zero<br><br><a href='item.php?id=$TPL_id_value&history=view#history' class='buttonbid'>
Back To Auction</a>";
        $bidH = $_POST['bid'];

        // Show list of bids
        $auction_id = $id;
        include_once("bid_list.php");

        include(phpa_include("template_bid_php.html"));        
        include("footer.php");
        exit;
    }else if($_POST['bid_type']=='range'  && ($_POST['bid_from']<=0 || $_POST['bid_to']<=0))
    {
        include("header.php");
        $TPL_errmsg = "All bids must be greater than zero<br><br><a href='item.php?id=$TPL_id_value&history=view#history' class='buttonbid'>
Back To Auction</a>";
        $bidH = $_POST['bid_from'];

        // Show list of bids
        $auction_id = $id;
        include_once("bid_list.php");

        include(phpa_include("template_bid_php.html"));        
        include("footer.php");
        exit;
    }

if($_POST['bid_type']=='range'  && ($_POST['bid_from'] >= $_POST['bid_to']))
    {
        include("header.php");
        $TPL_errmsg = "The bid 'To' amount must be higher than the 'From' amount.<br><br><a href='item.php?id=$TPL_id_value&history=view#history' class='buttonbid'>
Back To Auction</a>";
        $bidH = $_POST['bid_from'];

        // Show list of bids
        $auction_id = $id;
        include_once("bid_list.php");

        include(phpa_include("template_bid_php.html"));        
        include("footer.php");
        exit;
    }

// check if user would waste bids using the selected range
 if($_POST['bid_type']=='range'  && ($_POST['bid_to'] > $_POST['bid_from']))
    {

/* get auction data  */
$query = "select * from HB_auctions where id=".intval($id);
$result = mysql_query($query);
if ( !$result ) {
    MySQLError($query);
    exit;
}

$query1 = "SELECT COUNT(*) as current_bids FROM HB_bids WHERE auction=".intval($id);
$result1=mysql_query($query1);
$row1=mysql_fetch_array($result1);

$bidsPlacedSoFar  = mysql_result ( $result, 0, "number_of_bids" );
$bidsBeforeEnd=$bidsPlacedSoFar-$row1['current_bids'];
$bidsWouldBePlaced=($_POST['bid_to'] - $_POST['bid_from'])/0.01;

      if ((($_POST['bid_to'] - $_POST['bid_from'])/0.01)>$bidsBeforeEnd)
        {
        include("header.php");
        $TPL_errmsg = $MSG_31_00651;
        $bidH = $_POST['bid_from'];

        // Show list of bids
        $auction_id = $id;
        include_once("bid_list.php");

        include(phpa_include("template_bid_php.html"));        
        include("footer.php");
        exit;
        }
    }

    # // ###############################
    # check if bids are not greater than MAX_OFFER
    if ($_POST['bid_type']=='simple' && $_POST['bid']>$_SESSION['MAX_OFFER'])
    {
        include("header.php");
        $TPL_errmsg = "The bid must not be greater than ".$_SESSION['MAX_OFFER'];
        $bidH = $_POST['bid'];

        // Show list of bids
        $auction_id = $id;
        include_once("bid_list.php");

        include(phpa_include("template_bid_php.html"));        
        include("footer.php");
        exit;
    }else if($_POST['bid_type']=='range' && ($_POST['bid_from']>$_SESSION['MAX_OFFER'] || $_POST['bid_to']>$_SESSION['MAX_OFFER']))
    {
        include("header.php");
        $TPL_errmsg = "All offers in the range must not exceed ".$_SESSION['MAX_OFFER'];
        $bidH = $_POST['bid_from'];

        // Show list of bids
        $auction_id = $id;
        include_once("bid_list.php");

        include(phpa_include("template_bid_php.html"));        
        include("footer.php");
        exit;
    }

    # // ###############################
    # check if the user has enough money on his account
    $bid_sum = 0;
    // Retrieve bid value (one bid cost)
    if(ereg("^(\+?((([0-9]+(\.)?)|([0-9]*\.[0-9]+))([eE][+-]?[0-9]+)?))$",$Data['bid_value'])){
        $bid_value = $Data['bid_value'];
    }else $bid_value = 2;
    
    if ($_POST['bid_type']=='simple')
    {
        $bid_sum = $bid_value;
    }else if($_POST['bid_type']=='range')
    {
        // Multiply number of bids to 2 Euro
        for($i=0;$i<=($_POST['bid_to']-$_POST['bid_from']);$i=$i+0.01)
        {
            $bid_sum+=$bid_value;
        }
    }
    
    $query = "SELECT id, balance FROM HB_users WHERE nick='". addslashes($_SESSION['HAPPYBID_LOGGED_IN_USERNAME'])."'";
    $result = mysql_query($query);
    $bal_row = mysql_fetch_array($result);
    $balance_ = $bal_row['balance'];
    $user_id_ = $bal_row['id'];
    
    // the user has not enough money    
    if($balance_ < $bid_sum)
    {
        include("header.php");
        $TPL_errmsg = $ERR_32_0001;
        $bidH = $bid_sum;

        // Show list of bids
        $auction_id = $id;
        include_once("bid_list.php");

        include(phpa_include("template_bid_php.html"));        
        include("footer.php");
        exit;
    }


    $auctiondate = $Data['starts'];
    $auctionends = $Data['ends'];
    $item_title = $Data["title"];
    $item_description = $Data["description"];

    // check if auction isn't closed    
    $AuctionIsClosed = false;
    $closed = intval($Data["closed"]);
    $c = $Data["ends"];
    

    if ($closed == 1 )
    {
        include("header.php");
        $TPL_errmsg = $ERR_614;

        // Show list of bids
        $auction_id = $id;
        include_once("bid_list.php");

        include(phpa_include("template_bid_php.html"));
        include("footer.php");
        exit;
    }

    $insert = "";

    // Check if the user pressed F5: if no - processing the bid, if yes - not processing
    
    if($_POST['f5_num'] != $_SESSION['f5_num1'])
    {
        // Insert records of each bid (one - if simple, multiple - if 'range')
        if ($_POST['bid_type']=='simple')
        {
            $insert = "INSERT INTO HB_bids(auction, bidder, bid, bidwhen)
                VALUES($id, $user_id_, ".$_POST['bid'].", '$NOW')";
            mysql_query($insert);
        }else if($_POST['bid_type']=='range')
        {
            for($j=$_POST['bid_from'];$j<=$_POST['bid_to'];$j=$j+0.01)
            {
                $insert = "INSERT INTO HB_bids(auction, bidder, bid, bidwhen)
                VALUES($id, $user_id_, $j, '$NOW');";
                mysql_query($insert);
            }
        }
    
        //update user's balance    
        $balance_-=$bid_sum;
        $update = "UPDATE HB_users SET balance=$balance_
                   WHERE nick LIKE '". addslashes($_SESSION['HAPPYBID_LOGGED_IN_USERNAME'])."' AND id=$user_id_";    
        mysql_query($update);
		
		//add to bid counter
        $update2 = "UPDATE HB_users SET a33 = a33 + 1
                   WHERE nick LIKE '". addslashes($_SESSION['HAPPYBID_LOGGED_IN_USERNAME'])."' AND id=$user_id_";    
        mysql_query($update2);
        
        // Save current F5 control number for next check
        $_SESSION['f5_num1'] = $_POST['f5_num'];        
    }
	$EXTSETTINGS = @mysql_fetch_array(@mysql_query("SELECT * FROM HB_auctionextension"));

	if ($EXTSETTINGS['status'] == 'enabled') {
		$__END = mktime(substr($auctionends, 8, 2), substr($auctionends, 10, 2), substr($auctionends, 12, 2), substr($auctionends, 4, 2), substr($auctionends, 6, 2), substr($auctionends, 0, 4));
		if (($__END - $TIME) <= $EXTSETTINGS['timebefore']) {
			$auctionends = date("YmdHis", mktime(substr($auctionends, 8, 2), substr($auctionends, 10, 2), substr($auctionends, 12, 2) + $EXTSETTINGS['extend'], substr($auctionends, 4, 2), substr($auctionends, 6, 2), substr($auctionends, 0, 4)));
		}
	
		$query = "UPDATE HB_auctions set ends='$auctionends' WHERE id=".intval($id);
		if (!mysql_query($query)) {
			MySQLError($query);
			exit;
		}
	}


    // Generate new F5 control number
    $f5_num = getRandomInt(20);        
    
    // Check for winner - find minimum unique bid
    $check = "SELECT bid, bidder, COUNT(bid) AS bid_count
              FROM HB_bids
              WHERE auction=$id GROUP BY bid ORDER BY bid DESC ";
              
    $check_result = mysql_query($check);    
    $winner_bid = 0;
    $winner_bid_count = 0;
    $winner_id = 0;
    if($check_row = mysql_fetch_array($check_result))
    {        
        $winner_bid = $check_row['bid'];
        $winner_bid_count = $check_row['bid_count'];
        if($winner_bid_count == 1)
            $winner_id = $check_row['bidder'];
    }

    // Find the current winner of the auction
    while($check_row = mysql_fetch_array($check_result))
    {       
        // Find out if the bid is unique        
        if($check_row['bid_count']==1)        
        {
            // If this unique bid is the lowest - it is a winner
            if($check_row['bid']<$winner_bid)
            {
                $winner_id = $check_row['bidder'];
                $winner_bid = $check_row['bid'];             
            }            
        }
    }    
    
    $MSG_WINNER = "";
    $is_winner = false;
    if($winner_id == $_SESSION['HAPPYBID_LOGGED_IN']){
        $is_winner = true; // Current user is the winner
    }
    
    // Show message about current bid if it's winner bid, its state etc...
    switch($_POST['bid_type']){
        case "simple":
            $result3 = mysql_query($check);
            $is_unique=false;
            while($row3 = mysql_fetch_array($result3)){
                if($row3['bid_count']==1 && $row3['bid']==$_POST['bid']){
                    $is_unique=true;
                    break;
                }
            }

            if($_POST['bid']==$winner_bid && $is_winner){ //This bid is winner
			
			//030313 - START - A - EMAIL CURRENT WINNER TO SAY THEY'VE BEEN OUTBID

if(isset($min_bidder_email)){
include $include_path."user_outbid_email.inc.php";   

} 

//030313 - END - A - EMAIL CURRENT WINNER TO SAY THEY'VE BEEN OUTBID
                $MSG_WINNER = $MSG_31_0053;                
            }else{
                if($is_unique==true){
                    $MSG_WINNER = $MSG_31_0054;
                    if($is_winner==true){
                        $MSG_WINNER .= str_replace("<winner_bid>",$winner_bid,$MSG_31_0057);
                    }
                }else{
                    $MSG_WINNER = $MSG_31_0055;
					
					//030313 - START - B - EMAIL CURRENT WINNER TO SAY THEY'VE BEEN OUTBID

if (($min_bidder_bid==$_POST['bid']) && isset($min_bidder_email))
{
include $include_path."user_outbid_email.inc.php";   
}
//030313 - END - B - EMAIL CURRENT WINNER TO SAY THEY'VE BEEN OUTBID
                    if($is_winner==true){
                        $MSG_WINNER .= str_replace("<winner_bid>",$winner_bid,$MSG_31_0057);
                    }
                }
            }
            break;
        case "range":
            $result4 = mysql_query($check);
            $is_unique = false;
            $min_bid = 0;
            $is_in_range = false;
            while($row4 = mysql_fetch_array($result4)){
                for($j=$_POST['bid_from'];$j<=$_POST['bid_to'];$j=$j+0.01)
                {
                    if($row4['bid_count']==1 && $row4['bid']==$j && $min_bid==0){
                        $is_unique = true;
                        $min_bid = $j;                        
                    }
                    
                    if($j==$winner_bid) $is_in_range=true;
                }
            }
            
            if($is_in_range==true && $is_winner){ //This bid is winner
			//030313 - START - C - EMAIL CURRENT WINNER TO SAY THEY'VE BEEN OUTBID

if(isset($min_bidder_email)){
include $include_path."user_outbid_email.inc.php";   
}    

//030313 - END - C - EMAIL CURRENT WINNER TO SAY THEY'VE BEEN OUTBID
                $MSG_WINNER = str_replace("<winner_bid>",$winner_bid,$MSG_31_0058);
            }else{
                if($is_unique==true){
                    $MSG_WINNER = str_replace("<min_bid>",$min_bid,$MSG_31_0059);
                    if($is_winner==true){
                        $MSG_WINNER .= str_replace("<winner_bid>",$winner_bid,$MSG_31_0057);
                    }
                }else{
                    $MSG_WINNER = $MSG_31_0055;
                    if($is_winner==true){
                        $MSG_WINNER .= str_replace("<winner_bid>",$winner_bid,$MSG_31_0057);
                    }
                }
            }
            break;
        default: break;
    }
    
    //if($is_winner==false){
    //   $MSG_WINNER .= $MSG_31_0056;
    //}

    $auction_type = $_POST['auction_type'];
    $type = $_POST['form_type'];    
    $TPL_id = $id;
    
    // Show list of bids
    $auction_id = $id;
    include_once("bid_list.php");

    
    include "header.php";            
    include phpa_include("template_bid_result_php.html");
    include "footer.php";
    exit;

?>