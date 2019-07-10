<?php

include "./includes/config.inc.php";

#// Run cron according to SETTINGS
if($SETTINGS['cron'] == 2) { include_once "cron.php"; }

include $include_path."auction_types.inc.php";
include $include_path."dates.inc.php";
$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
$NOW = date("YmdHis",$TIME);

    //#// ################################################
    //#// Is the seller logged in?
    //if(!isset($_SESSION['HAPPYBID_LOGGED_IN']))
    //{
    //    $REDIRECT_AFTER_LOGIN = "boards.php";
    //    $_SESSION['REDIRECT_AFTER_LOGIN']=$REDIRECT_AFTER_LOGIN;
    //
    //    Header("Location: user_login.php");
    //    exit;
    //
    //}
    
    if (!$id) $id = $_REQUEST[id];
    if (!$bid) $bid = $_REQUEST[bid];

    $TPL_id = $id;

    /** first check if valid auction ID passed */
    $result = mysql_query("SELECT * FROM HB_auctions WHERE closed=1 AND id=".intval($id));
    // SQL error
    if (!$result)
    {
        MySQLError($query);
        exit;
    }

    $Data = mysql_fetch_array($result);
    $n = mysql_num_rows($result);
    $TPL_title = htmlspecialchars($Data['title']);
    $TPL_id_value = $id;
    
    
    # // ###############################    
    // such auction does not exist, so exit
    if ($n == 0)
    {
        header("Location:index.php");
        exit;
    }
    
    # // ###############################    
    // select bids to show link to bid history of this user
    $query = "select bid,id from HB_bids where auction=\"".intval($id)."\" ORDER BY id DESC";
    $result___ = mysql_query($query);
    if (mysql_num_rows($result___) > 0) {
        $ARETHEREBIDS = "<A HREF=\"".$SETTINGS['siteurl']."item.php?id=$id&history=view#history\">$MSG_105</A>";
        $CURRENTBID_ID = mysql_result($result___,0,"id");
    } else {
        unset($TPL_BIDS_value);
    }

    # // ###############################    
    // Set required variables
    $auctiondate = $Data['starts'];
    $auctionends = $Data['ends'];
    $item_title = $Data["title"];
    $item_description = $Data["description"];
    
    // Find max bid count
    $max_bid_count = 0;
    $query = "SELECT COUNT(bid) AS bid_count
              FROM HB_bids
              WHERE auction=$id GROUP BY bid";
    $res = mysql_query($query);
    if($res)
    {
        $row = mysql_fetch_array($res);
        $max_bid_count = $row['bid_count'];
        while($row = mysql_fetch_array($res))
        {
            if($row['bid_count'] > $max_bid_count)
            {
                $max_bid_count = $row['bid_count'];
            }
        }
        
    }else
    {
        include("header.php");
        $TPL_errmsg = "Uknown error occured, please try later.";
        include(phpa_include("template_bid_php.html"));        
        include("footer.php");
        exit;
    }
    
    // Retrieve the winner
	$winner_id = 0;
	$winner_bid = 0;
    $winner_msg = "";
	$winner = "SELECT w.winner, w.bid, u.nick
               FROM HB_winners w
                INNER JOIN HB_users u ON w.winner=u.id
               WHERE auction=$id";
	$winner_res = mysql_query($winner);
	if ($winner_res && mysql_num_rows($winner_res) > 0)
	{
		$row = mysql_fetch_array($winner_res);
		$winner_id = $row['winner'];
		$winner_bid = $bid = number_format($row['bid'], 2);;        
        $winner_msg = "Winner: <strong>".$row['nick']."</strong>";
		$winners_bid = "winning bid: <strong>&pound;$winner_bid</strong>";
	}else
    {
        $winner_msg = "<div style='margin-top:10px;'><strong>There was no winner of this auction</strong></div>";
    }

    /**include "header.php"; **/           
    include phpa_include("template_view_bid_history_php.html");
    /**include phpa_include("template_user_menu_footer.html");**/
    exit;

?>
?>
