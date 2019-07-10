<?
// Connect to sql server & inizialize configuration variables
require('./includes/config.inc.php');

#// If user is not logged in redirect to login page

if(!isset($_SESSION["HAPPYBID_LOGGED_IN"])) {
	Header("Location: user_login.php");
	exit;
}

require("header.php");

// Auction id is present, now update table
if ($_GET["insert"]=="true") {
	// Check if this keyword is not already added
	echo "<input type=hidden name=add value=".$_REQUEST['add'].">";
	if ($_REQUEST['add']=="") {
		$_REQUEST['add']="";
	}
	$query = "SELECT auc_watch from HB_users where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
	$result = @mysql_query($query);
	if(!$result) {
		MySQLError($query);
		exit;
	}
	$auctions = trim(mysql_result ($result,0,"auc_watch"));
	if (!empty($auctions)) {
		$match = @strstr($auctions, $_REQUEST['add']);
		$auctions = $auctions;
		$TPL_active="<a href='auction_watch.php?active=no'>deactivate ?</a>";
	} else {
		$auctions = "";
		$TPL_active="<a href='auction_watch.php?active=no'>deactivate ?</a>";
	}

	if (!$match) {
		$auction_watch = trim("$auctions ".$_REQUEST['add']);
		$auction_watch_new = trim($auction_watch);
		$TPL_active="<a href='auction_watch.php?active=no'>deactivate ?</a>";
		$query = "UPDATE HB_users set auc_watch='$auction_watch_new',reg_date=reg_date where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
		$result = @mysql_query("$query");
		if(!$result) {
			MySQLError($query);
			exit;
		}
	}

	// Show results
	$query = "SELECT auc_watch from HB_users where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
	$result = @mysql_query("$query");
	if(!$result) {
		MySQLError($query);
		exit;
	}
	$auctions = trim(mysql_result ($result,0,"auc_watch"));

	if (($auctions=="") || ($auctions=="NULL") ) { 
	} else {
		$auction = split(" ",$auctions);
		for ($j=0; $j < count($auction); $j++) {
			$TPL_auction_watch.="<tr BGCOLOR=#FFFFFF><td>$auction[$j]</td><td ALIGN=RIGHT>
			                    <a href='auction_watch.php?delete=".urlencode($auction[$j])."'><IMG SRC='./images/trash.gif' BORDER='0' alt='delete' /></a>
			                    </td></tr>";
		}
	}
}

// Delete auction from auction watch
if ($_GET['delete']) {
	$query = "SELECT auc_watch from HB_users where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
	$result = @mysql_query("$query");
	if(!$result) {
		MySQLError($query);
		exit;
	}
	$auctions = trim(mysql_result ($result,0,"auc_watch"));

	$auc_id = split(" ",$auctions);
	for ($j=0; $j < count($auc_id); $j++) {
		$match = strstr($auc_id[$j],$_GET['delete']);
		//print "$auc_id[$j],$_GET['delete']<BR>";
		if ($match) {
			$auction_watch = $auction_watch;
		} else {
			$auction_watch = "$auc_id[$j] $auction_watch";
		}
	}
	$auction_watch_new = trim($auction_watch);
	if (($auction_watch_new=="") ) {
		$auction_watch_new="";
		$TPL_active="not active";
	} else {
		$TPL_active="<a href='auction_watch.php?active=no'>deactivate ?</a>";
	}
	$query = "UPDATE HB_users set auc_watch='$auction_watch_new',reg_date=reg_date where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
	$result = @mysql_query("$query");
	if(!$result) {
		MySQLError($query);
		exit;
	}

	// Show results

	$query = "SELECT auc_watch from HB_users where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
	$result = @mysql_query("$query");
	if(!$result) {
		MySQLError($query);
		exit;
	}
	$auctions = trim(mysql_result ($result,0,"auc_watch"));

	if ( ($auctions=="") || ($auctions=="NULL") ) { }
	else {
		$auction = split(" ",$auctions);
		for ($j=0; $j < count($auction); $j++) {
			$TPL_auction_watch.="<tr><td> $auction[$j]</a></td><td ALIGN=RIGHT>
			                    <a href='auction_watch.php?delete=".urlencode($auction[$j])."'><IMG SRC='./images/trash.gif' BORDER='0' alt='delete' /></a>
			                    </td></tr>";
		}
	}

}

// Disable auction watch
if ($active=="no") {
	$query = "UPDATE HB_users set auc_watch='',reg_date=reg_date where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
	$result = @mysql_query($query);
	if(!$result) {
		MySQLError($query);
		exit;
	}
}


// Show results if nothing changed

if ((!$_REQUEST['add']) && (!$_GET['delete'])) {
	$query = "SELECT auc_watch from HB_users where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
	$result = @mysql_query("$query");
	if(!$result) {
		MySQLError($query);
		exit;
	}
	$auctions = trim(mysql_result ($result,0,"auc_watch"));

	if (($auctions=="") || ($auctions=="NULL") ) {
		$TPL_active="not active";
	} else {
		$TPL_active="<a href='auction_watch.php?active=no'>deactivate ?</a>";
		$auction = split(" ",$auctions);
		for ($j=0; $j < count($auction); $j++) {
			$TPL_auction_watch.="<tr><td> $auction[$j]</a></td><td ALIGN=RIGHT>
			                    <a href='auction_watch.php?delete=".urlencode($auction[$j])."'><IMG SRC=images/trash.gif BORDER=0></a>
			                    </td></tr>";

		}
	}
}

include phpa_include("template_auction_watch_php.html");
include "./footer.php";

?>
