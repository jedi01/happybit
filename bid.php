<?
include "./includes/config.inc.php";
include $include_path."auction_types.inc.php";
include $include_path."dates.inc.php";
$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
$NOW = date("YmdHis",$TIME);

if (!$id) $id = $_REQUEST[id];
if (!$bid) $bid = $_REQUEST[bid];

/**
* first check if valid auction ID passed
*/
$result = mysql_query("SELECT * FROM HB_auctions WHERE id=".intval($id));
// SQL error
if (!$result) {
    MySQLError($query);
    exit;
}
$Data = mysql_fetch_array($result);
$n = mysql_num_rows($result);
$TPL_title = htmlspecialchars($Data['title']);

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
// such auction does not exist
if ($n == 0) {
    include("header.php");
    $TPL_errmsg = $ERR_606;
    include(phpa_include("template_bid_php.html"));
    
    include("footer.php");
    exit;
}

if (!checkmoney($_POST['bid'])) {
    include("header.php");
    $TPL_errmsg = $ERR_058;
    $bidH = $_POST['bid'];
    include(phpa_include("template_bid_php.html"));
    
    include("footer.php");
    exit;
}

// $bid = input_money($_POST['bid']);
// extract info about this auction into an hash

$auctiondate = $Data['starts'];
$auctionends = $Data['ends'];
$item_title = $Data["title"];
$increment = $Data['increment'];
$item_description = $Data["description"];
$aquantity = $Data['quantity'];
$minimum_bid = $Data['minimum_bid'];
$current_bid = $Data['current_bid'];
// check if auction isn't closed
$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
$AuctionIsClosed = false;
$closed = intval($Data["closed"]);
$c = $Data["ends"];


if ($closed == 1 ) {
    include("header.php");
    $TPL_errmsg = $ERR_614;
    include(phpa_include("template_bid_php.html"));
    
    include("footer.php");
    exit;
}
// fetch info about seller
$result = mysql_query("SELECT * FROM HB_users WHERE id='" . $Data["user"] . "'");
$n = 0;
if ($result)
$n = mysql_num_rows($result);
if ($n > 0)
$Seller = mysql_fetch_array($result);
else
$Seller = array();

$atype = intval($Data['auction_type']);
$reserve = $Data['reserve_price'];
// calculate: increment and mimimum bid value
// determine max bid for this auction
$query = "SELECT bid,bidder FROM HB_bids WHERE auction=".intval($id)." ORDER BY bid DESC";
$result_bids = mysql_query ($query) ;
if (!$result_bids) {
    print $ERR_001;
    exit;
}

if (mysql_num_rows($result_bids) > 0) {
    $high_bid = mysql_result ($result_bids, 0, "bid");
    $WINNING_BIDDER = mysql_result ($result_bids, 0, "bidder");
} else {
    $high_bid = $current_bid;
}

/**
* Get bid increment for current bis and calculate minimum bid
*/
$customincrement = $Data['increment'];
$minimum_bid = $Data['minimum_bid'];
$query = "SELECT increment FROM HB_increments WHERE" . "((low<=".doubleval($high_bid)." AND high>=".doubleval($high_bid).") OR" . "(low<".doubleval($high_bid)." AND high<".doubleval($high_bid).")) ORDER BY increment DESC";
$result_incr = mysql_query ($query);
if ($result_incr && mysql_num_rows($result_incr) > 0) {
    $increment = mysql_result ($result_incr, 0, "increment");
} else {
    $increment = 0;
}

if ($atype == 2) {
    $increment = 0;
}
if ($customincrement > 0) {
    $increment = $customincrement;
}

if (doubleval($high_bid) == 0 || $atype == 2) {
    $next_bid = $minimum_bid;
} else {
    $next_bid = $high_bid - $increment;
    //#1 change $next_bid = $high_bid + $increment;
}

/**
* else: such auction does exist.
* if called from item.php - then transfer passed data
* if called - check data/username/password and then execute autobid
*/

unset($display_bid_form1);
if (empty($_POST['action'])) {
    // no "action" specified
    $display_bid_form1 = true;
} else {
    // an action specified: check for data and perform corresponding actions
    unset($ERR);
    
    $bid = input_money($_POST['bid']);
    
    // check if bid value is OK
    //#2 change if ($bid < $next_bid && $atype !=2){
    if ($bid > $next_bid && $atype !=2){
        $ERR = "607";
    }
    // check if number of items is OK
    if (($atype == 2) && (!isset($ERR))) {
        if ((intval($_POST[qty]) == 0) || (intval($_POST[qty]) > intval($Data["quantity"]))) {
            $ERR = "608";
        } else {
            # // If the bidder already bidded on this auction the following condition must be satisfied
            # // (current bid * current amount bidded) > (previous bid * previous amount bidded)
            $query = "SELECT bid,quantity FROM HB_bids WHERE bidder=".intval($bidder_id)." ORDER BY bid DESC";
            $res = @mysql_query($query);
            if (!$res) {
                MySQLError($query);
                exit;
            } elseif (mysql_num_rows($res) > 0) {
                $PREVIOUSBID = mysql_fetch_array($res);
                if (($current_bid * $_POST[qty]) <= ($PREVIOUSBID['bid'] * $PREVIOUSBID['quantity'])) {
                    $ERR = "608";
                }
            }
        }
    }
    // check if nickname and password entered
    if (!isset($ERR)) {
        if (strlen($_POST['nick']) == 0 || strlen($_POST['password']) == 0)
        $ERR = "610";
    }
    
    // check if nick is valid
    if (!isset($ERR)) {
        $query = "SELECT * FROM HB_users WHERE nick='" . addslashes($_POST['nick']) . "'";
        $result = mysql_query($query);
        $n = 0;
        if ($result)
        $n = mysql_num_rows($result);
        else
        $ERR = "001";

        // Check if user is suspended
        if (!isset($ERR) && $n) {
            if(mysql_result($result, 0, "suspended")){
                $ERR = "618";
            }
        }

        if (!isset($ERR)) {
            if ($n == 0) $ERR = "609";
        }
        if ($n > 0) {
            //echo "1 start checking <br>";    
            $bidder_id = mysql_result($result, 0, "id");
            # // ####################################################################################
            # // If the current bidder is the winning bidder do the following
            # // 1. if the bid < current proxy bid ==> error
            # // 2. if no error at point one, update the proxy bid with the new value
            # // 3. display confirmation page and exit
            if ($WINNING_BIDDER == $bidder_id) {
                
                //echo "2 $WINNING_BIDDER == $bidder_id <br>";
                
                $query = "SELECT bid FROM HB_proxybid p, HB_users u
                              WHERE
                              userid='$WINNING_BIDDER' AND
                              itemid=".intval($id)." AND
                              p.userid=u.id AND
                              u.suspended=0
                              ORDER BY bid DESC";
                $r__ = mysql_query($query);
                //echo "<br>4 <br>";
                if (!$r__) {
                    //echo "5 No <br>";
                    MySQLError($query);
                    exit;
                } elseif (mysql_num_rows($r__) > 0) {
                    //echo "6 Yes <br>";
                    
                    $WINNER_PROXYBID = mysql_result($r__, 0, "bid");                    
                    //#3 change if ($WINNER_PROXYBID >= $bid) {
                    if ($WINNER_PROXYBID <= $bid) {
                        //echo "6-0 $WINNER_PROXYBID <= $bid <br>";
                        $ERR = "040";
                    } else {
                        //echo "6-1 $WINNER_PROXYBID >= $bid <br>";
                        # // Just update proxy_bid
                        $query = "UPDATE HB_proxybid SET
                                      bid=" . doubleval($bid) . "
                                      WHERE
                                      userid=".intval($WINNING_BIDDER)." AND
                                      itemid=".intval($id)." AND
                                      bid=$WINNER_PROXYBID";
                        $r___ = mysql_query($query);
                        //echo "<br>6-2 <br>";
                        if (!$r___) {
                            //echo "6-3 not updated <br>";
                            MySQLError($query);
                            exit;
                        }
                        //echo "6-4  $reserve > 0 | $reserve < $current_bid <br>";
                        //if ($reserve >= 0) {
                            //echo "6-5 $reserve > 0 | $reserve < $current_bid<br>";
                            //#4 change if ($reserve > $current_bid) {
                            //if ($reserve < $current_bid) {
                            if ($current_bid > 0) {
                                //echo "111 ";
                                $result = mysql_query("SELECT * FROM HB_proxybid p, HB_users u
                                                WHERE itemid=".intval($id)." AND
                                                userid=".intval($bidder_id)." AND
                                                p.userid=u.id AND
                                                u.suspended=0
                                                ORDER BY bid DESC");
                                if (mysql_num_rows($result) > 0) {
                                    //echo "222 ";
                                    $proxy_max_bid = mysql_result($result, 0, "bid");
                                }
                                //#5 change if ($proxy_max_bid <= $reserve) {
                                if ($proxy_max_bid >= $reserve) {
                                    //echo "333 $proxy_max_bid >= $reserve <br>";
                                    $next_bid = $bid; //$reserve;
                                    $reserve_met = 1;
                                    
                                    $query = "update HB_auctions set current_bid=$next_bid, num_bids=num_bids+1, starts='$auctiondate' where id=".intval($id);
                                    // print $query;
                                    if (!mysql_query($query)) {
                                        //echo "444 ";
                                        MySQLError($query);
                                        exit;
                                    }
                                    # // Also update bids table
                                    $query = "INSERT INTO HB_bids VALUES(
                                                  NULL,
                                                  ".intval($id).",
                                                  ".intval($bidder_id).",
                                                  " . doubleval($next_bid) . ",
                                                  '" . $NOW . "',
                                                  " . intval($_POST[qty]) . ")";
                                    $res___ = @mysql_query($query);
                                    if (!$res___) {
                                        MySQLError($query);
                                        exit;
                                    }
                                } else {
                                    //echo "555 ";
                                    $next_bid = $bid;
                                    
                                    $query = "update HB_auctions set current_bid=$next_bid, num_bids=num_bids+1, starts='$auctiondate' where id=".intval($id);
                                    // print $query;
                                    if (!mysql_query($query)) {
                                        MySQLError($query);
                                        exit;
                                    }
                                    # // Also update bids table
                                    $query = "INSERT INTO HB_bids VALUES(
                                                  NULL,
                                                  ".intval($id).",
                                                  ".intval($bidder_id).",
                                                  " . doubleval($next_bid) . ",
                                                  '" . $NOW . "',
                                                  " . intval($_POST[qty]) . ")";
                                    $res___ = @mysql_query($query);
                                    if (!$res___) {
                                        MySQLError($query);
                                        exit;
                                    }
                                }
                            }
                        //}
                        # // Confirmation
                        $TPL_id = $id;
                        include "header.php";
                        include phpa_include("template_bid_result_php.html");
                        include "footer.php";
                        exit;
                    }
                }
            }
        }
    }
    
    //echo "7 <br>";    
    // check if password is correct
    if (!isset($ERR)) {
        $pwd = mysql_result($result, 0, "password");

        if ($pwd == md5($MD5_PREFIX . $_POST['password'])) {

            # // Automatically login user
            $HAPPYBID_LOGGED_IN = $bidder_id;
            $HAPPYBID_LOGGED_IN_USERNAME = mysql_result($result, 0, "nick");
            $_SESSION["HAPPYBID_LOGGED_IN"]=$HAPPYBID_LOGGED_IN;
            $_SESSION["HAPPYBID_LOGGED_EMAIL"] = mysql_result($result,0,"email");
            $_SESSION["HAPPYBID_LOGGED_NAME"] = mysql_result($result,0,"name");
            $_SESSION["HAPPYBID_LOGGED_ACCOUNT"] = mysql_result($result,0,"accounttype");
            $_SESSION["HAPPYBID_LOGGED_IN_USERNAME"]=$HAPPYBID_LOGGED_IN_USERNAME;
        }
        if ($pwd != md5($MD5_PREFIX . $_POST['password'])) {
            $ERR = "611";
        } else {
            if (mysql_result($result, 0, "suspended") > 0) {
                $ERR = "618";
            }
        }
    }
    //echo "8 password correct <br>";    
    // Check if Auction is suspended
    if (!isset($ERR)) {
        $query2 = "SELECT suspended FROM HB_auctions WHERE id=".intval($id);
        $result2 = mysql_query($query2);
        
        if (mysql_result($result2, 0, "suspended") > 0) {
            $ERR = "619";
        }
    }
    
    # // ------------------------------------------------------------
    # // ADDED BY GIANLUCA Jan. 9, 2002
    # // ------------------------------------------------------------
    # // If dutch auction, check if the bidding user already
    # // placed a bid and, if yes, the current bid cannot be minor
    # // than the previous placed bid.
    if ($Data['auction_type'] == 2) {
        # //
        $CURRENT = $bid * $_POST[qty];
        # // Search for bids of this user
        $query = "SELECT * from HB_bids WHERE bidder=".intval($bidder_id)." and auction=".intval($id);

        $res_ = @mysql_query($query);
        if ($res_ && mysql_num_rows($res_) > 0) {
            while ($BID = mysql_fetch_array($res_)) {
                if ($CURRENT <= ($BID['quantity'] * $BID['bid'])) {
                    $ERR = "059";
                }

            }
        }
    }
    # // ------------------------------------------------------------
    # // >>>>>>ENDS - ADDED BY GIANLUCA Jan. 9, 2002<<<<<<<<
    # // ------------------------------------------------------------
    // check if bidder is not the seller
    if (!isset($ERR)) {
        $bidderID = mysql_result($result, 0, "id");
        if ($bidderID == $Seller["id"])
        $ERR = "612";
    }
    //echo "9 <br>";    
    // perform final actions
    if (isset($ERR)) {
        //echo "10 <br>";    
        $display_bid_form1 = true;
        $TPL_errmsg = ${"ERR_".$ERR};
    } else {
        unset($ERR);
        //echo "11 <br>";    
        // ################################
        // PROXY BIDDING
        // ################################
        if ($Data['auction_type'] == 2) {
            $next_bid = $bid;
        }

        $bidP = print_money($bid);
        $query = "SELECT * FROM HB_users WHERE nick='" . addslashes($_POST['nick']) . "'";
        $result = mysql_query($query);

        $n = 0;
        if ($result) 
        $n = mysql_num_rows($result);
        else
        $ERR = "001";

        if (!isset($ERR)) {
            if ($n == 0)
            $ERR = "609";
        }
        if ($n > 0) $bidder_id = mysql_result($result, 0, "id");

        $result = mysql_query("SELECT * FROM HB_proxybid p, HB_users u WHERE itemid=".intval($id) ." AND p.userid=u.id and u.suspended=0 ORDER by bid DESC");
        if (mysql_num_rows($result) == 0) {    // First bid
            
            //#7 change if ($next_bid < $bid) {
            if ($next_bid > $bid) {
                // "12-1 $next_bid > $bid <br>";    
                // $bid = input_money($bid);
                $query = "INSERT INTO HB_proxybid VALUES (".intval($id).",".intval($bidder_id).",".doubleval($bid).")";
                if (!mysql_query($query)) {
                    MySQLError($query);
                    exit;
                }
                $TPL_proxy = "$MSG_699 $bidP $MSG_700";
                // $next_bid=input_money($next_bid);
                $query = "update HB_auctions set current_bid=$next_bid, starts='$auctiondate' where id=".intval($id);
                if (!mysql_query($query)) {
                    MySQLError($query);
                    exit;
                }
            }
            //echo "12-2 The first bid <br>";    

            if ($reserve > 0) {
                if ($reserve > $current_bid) {
                    if ($bid >= $reserve) {
                        $next_bid = $reserve;
                        $reserve_met = 1;
                    } else {
                        $next_bid = $bid;
                        $reserve_met = 0;
                    }
                }
            }
            #// Only updates current bid if it is a new bidder, not the current one
            $query = "update HB_auctions set current_bid=$next_bid, num_bids=num_bids+1, starts='$auctiondate' where id=".intval($id);
            if (!mysql_query($query)) {
                MySQLError($query);
                exit;
            }
            # // Also update bids table
            $query = "INSERT INTO HB_bids VALUES(
                        NULL,
                        ".intval($id).",
                        ".intval($bidder_id).",
                        " . doubleval($next_bid) . ",
                        '" . $NOW . "',
                        " . intval($_POST[qty]) . ")";
            $res___ = @mysql_query($query);
            if (!$res___) {
                MySQLError($query);
                exit;
            }
        } else { // This is not the first bid
            //echo "13 This is not the first bid <br>";    
            $proxy_bidder_id = mysql_result($result, 0, "userid");
            $proxy_max_bid = mysql_result($result, 0, "bid");

            if ($proxy_max_bid < $bid) {
                $next_bid = $proxy_max_bid + $increment;
                $TPL_new_proxy = "$MSG_699 $bidP $MSG_700";

                $query = "INSERT INTO HB_proxybid VALUES (".intval($id).",".intval($bidder_id).",".doubleval($bid).")";
                if (!mysql_query($query)) {
                    MySQLError($query);
                    exit;
                }
                $proxy = 1;
                if ($reserve > 0 && $reserve > $current_bid) {
                    if ($bid >= $reserve) {
                        $next_bid = $reserve;
                        $reserve_met = 1;
                    } else {
                        $next_bid=$bid;
                        $reserve_met = 0;
                    }
                }

                if($bid < ($proxy_max_bid + $increment)){
                    $next_bid = $bid;
                }

                // Fake bid to maintain a coherent history
                if($current_bid < $proxy_max_bid) {
                    $query = "INSERT INTO HB_bids VALUES(NULL, ".intval($id).",".intval($proxy_bidder_id)."," . doubleval($proxy_max_bid) . ",'" . $NOW . "'," . intval($_POST[qty]) . ")";
                    $rr_ = @mysql_query($query);
                    if (!$rr_) {
                        MySQLError($query);
                        exit;
                    }
                    $fakebids=1;
                } else {
                    $fakebids=0;
                }
                // Update bids table
                $query = "INSERT INTO HB_bids VALUES(NULL, ".intval($id).",".intval($bidder_id)."," . doubleval($next_bid) . ",'" . $NOW . "'," . intval($_POST[qty]) . ")";
                $rr_ = @mysql_query($query);
                if (!$rr_) {
                    MySQLError($query);
                    exit;
                }
                $query = "update HB_counters set bids=(bids+1+$fakebids)";
                $result = mysql_query($query);
                if (!$result) {
                    MySQLError($query);
                    exit;
                }

                $query = "update HB_auctions set current_bid=$next_bid, num_bids=num_bids+1+$fakebids, starts='$auctiondate' where id=".intval($id);
                if (!mysql_query($query)) {
                    MySQLError($query);
                    exit;
                }
            }
            if ($proxy_max_bid == $bid) {
                $proxywinner = 1;
                $proxy = true;
                $next_bid = $proxy_max_bid;

                $TPL_new_proxy2 = "$MSG_701";
                # // Update bids table
                $query = "INSERT INTO HB_bids VALUES(NULL, ".intval($id).",".intval($bidder_id)."," . doubleval($bid) . ",'" . $NOW . "'," . intval($_POST[qty]) . ")";
                $rr_ = @mysql_query($query);
                if (!$rr_) {
                    MySQLError($query);
                    exit;
                }
                $query = "INSERT INTO HB_bids VALUES(NULL, ".intval($id).",".intval($proxy_bidder_id)."," . doubleval($next_bid) . ",'" . $NOW . "'," . intval($_POST[qty]) . ")";
                $rr_ = @mysql_query($query);
                if (!$rr_) {
                    MySQLError($query);
                    exit;
                }

                $query = "update HB_counters set bids=(bids+2)";
                $result = mysql_query($query);
                if (!$result) {
                    MySQLError($query);
                    exit;
                }

                $query = "update HB_auctions set current_bid=".doubleval($next_bid).", num_bids=num_bids+1, starts='".$auctiondate."' where id=".intval($id);
                if (!mysql_query($query)) {
                    MySQLError($query);
                    exit;
                }
                $display_bid_form = true;

                if ($display_bid_form) {
                    // prepare some data for displaying in the form
                    $nickH = htmlspecialchars($_POST['nick']);
                    $bidP = htmlspecialchars($bid);
                    $qtyH = htmlspecialchars($_POST[qty]);
                    $TPL_title = htmlspecialchars($Data['title']);
                    $TPL_next_bid = print_money($next_bid + $increment);

                    $TPL_proposed_bid = print_money($bid);
                    $TPL_cancel_bid_link = "<A HREF=".$SETTINGS['siteurl'] ."item.php>$MSG_25_0166</A>";
                    # output the form
                    include("header.php");
                    include(phpa_include("template_bid_php.html"));
                    include("footer.php");
                    exit;
                }
            }

            if ($proxy_max_bid > $bid) {
                // Update bids table
                $query = "INSERT INTO HB_bids VALUES(NULL,
                            ".intval($id).",".intval($bidder_id)."," . doubleval($bid) . ",'" . $NOW . "'," . intval($_POST[qty]) . ")";
                $rr_ = @mysql_query($query);
                if (!$rr_) {
                    MySQLError($query);
                    exit;
                }
                $proxywinner = 1;
                $proxy = true;
                if (($bid + $increment) > $proxy_max_bid) {
                    $next_bid = $proxy_max_bid;
                } else {
                    $next_bid = $bid + $increment;
                }
                $bidder_id2 = $proxy_bidder_id;
                $TPL_new_proxy3 = "$MSG_701";
                # // Update bids table
                $query = "INSERT INTO HB_bids VALUES(NULL,
                            ".intval($id).",".intval($bidder_id2)."," . doubleval($next_bid) . ",'" . $NOW . "'," . intval($_POST[qty]) . ")";
                $rr_ = @mysql_query($query);
                if (!$rr_) {
                    MySQLError($query);
                    exit;
                }
                $query = "update HB_counters set bids=(bids+2)";
                $result = mysql_query($query);
                if (!$result) {
                    MySQLError($query);
                    exit;
                }

                $query = "update HB_auctions set current_bid=".doubleval($next_bid).", num_bids=num_bids+1, starts='$auctiondate' where id=".intval($id);
                if (!mysql_query($query)) {
                    MySQLError($query);
                    exit;
                }

                $display_bid_form = true;

                if ($display_bid_form) {
                    // prepare some data for displaying in the form
                    $nickH = htmlspecialchars($_POST['nick']);
                    $bidP = htmlspecialchars($bid);
                    $qtyH = htmlspecialchars($_POST[qty]);
                    $TPL_title = htmlspecialchars($Data['title']);
                    $TPL_next_bid = print_money($next_bid + $increment);

                    $TPL_proposed_bid = print_money($bid);
                    $TPL_cancel_bid_link = "<A HREF=".$SETTINGS['siteurl'] ."item.php>$MSG_25_0166</A>";
                    // output the form
                    include("header.php");
                    include(phpa_include("template_bid_php.html"));
                    include("footer.php");
                    exit;
                }
            }
        }
        
        /**
        * NOTE: AUCTION AUTOEXTENSION
        */
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
        
        // ################################
        // END OF PROXY BIDDING
        // ################################
        $send_email = 0;
        // Send e-mail to the old winner if necessary
        // Check if there's a previous winner and get his/her data
        $query = "select bidder,bid from HB_bids where auction=".intval($id)." order by bid desc";
        $result = mysql_query($query);
        if (!$result) {
            MySQLError($query);
            exit;
        }

        if (mysql_num_rows($result) > 1) {
            if ($atype == 2) {
                $send_email = 0;
            } else $send_email = 1;

            $OldWinner_id = mysql_result($result, 1, "bidder");
            $new_bid = $next_bid;
            $OldWinner_bid = print_money($new_bid - $increment);

            $query = "SELECT * FROM HB_users where id=".intval($OldWinner_id);
            $result_old_winner = mysql_query($query);
            if (!$result_old_winner) {
                MySQLError($query);
                exit;
            }

            $OldWinner_nick = mysql_result($result_old_winner, 0, "nick");
            $OldWinner_name = mysql_result($result_old_winner, 0, "name");
            $OldWinner_email = mysql_result($result_old_winner, 0, "email");
        }
        // Update counters table with the new bid
        # // ------------------------------------------------------------
        # // ADDED BY SIMOKAS
        # // ------------------------------------------------------------
        // Send notification if users keyword matches (Item Watch)
        $result = mysql_query("SELECT * FROM HB_users");
        $num_users = mysql_num_rows($result);
        $i = 0;
        while ($i < $num_users) {
            $userid = mysql_result ($result, $i, "id");
            $nickname = mysql_result ($result, $i, "nick");
            $e_mail = mysql_result ($result, $i, "email");
            $items = mysql_result ($result, $i, "item_watch");

            $match = strstr($items, $id);
            // If keyword matches with opened auction title or/and desc send user a mail
            if ($match && $userid != $bidder_id) {
                // Get data about the auction
                $res = mysql_query("SELECT * FROM HB_auctions where id=".intval($id));
                $auc_title = stripslashes(mysql_result ($res, 0, "title"));
                $current_bid = mysql_result ($res, 0, "current_bid");
                $sitename = $SETTINGS['sitename'];
                $auction_url = $SETTINGS['siteurl'] . "item.php?id=$id&mode=1";
                $new_bid2 = print_money($current_bid);
                // Mail body and mail() function
                include $include_path."mail_item_watch.".$language.".inc.php";
            }
            $i++;
        }
        // End of Item watch
        if ($send_email) {
            $year = substr($auctionends, 0, 4);
            $month = substr($auctionends, 4, 2);
            $day = substr($auctionends, 6, 2);
            $hours = substr($auctionends, 8, 2);
            $minutes = substr($auctionends, 10, 2);
            $ends_string = $month . " " . $day . " " . $year . "  " . $hours . ":" . $minutes;
            $new_bid = print_money($next_bid);
            // -- Send e-mail message
            include('./includes/no_longer_winner.inc.php');
        }
        // 3) perform output
        if (isset($ERR)) {
            $ERR = ${"ERR_".$ERR};
            include "header.php";
            print "<CENTER> $ERR </CENTER>";
            print mysql_error();
            include "footer.php";
            exit;
        } elseif (!$display_bid_form) {
            $TPL_id = $id;
            include "header.php";
            include phpa_include("template_bid_result_php.html");
            include "footer.php";
            exit;
        }
    }
}


if ($display_bid_form1) {
    // prepare some data for displaying in the form
    $nickH = htmlspecialchars($_POST['nick']);
    $bidH = htmlspecialchars($_POST['bid']);
    $qtyH = htmlspecialchars($_POST[qty]);
    $TPL_title = htmlspecialchars($Data['title']);
    $TPL_next_bid = print_money($next_bid);

    $TPL_proposed_bid = print_money($_POST['bid']);
    $TPL_cancel_bid_link = "<A HREF=".$SETTINGS['siteurl']."item.php>$MSG_25_0166</A>";
    // output the form
    include("header.php");
    include(phpa_include("template_bid_php.html"));
    include("footer.php");
    exit;
} elseif (!$display_bid_form1) {
    $TPL_id = $id;
    include "header.php";
    include phpa_include("template_bid_result_php.html");
    include "footer.php";
    exit;
}

?>
