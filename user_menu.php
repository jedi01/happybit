<?
// Connect to sql server & inizialize configuration variables
include './includes/config.inc.php';
// Include messages file
include $include_path.'messages.inc.php';
unset($_SESSION['PIZ']);
# Send buyer's request to the administrator
if(isset($_POST['requesttoadmin'])) {
  include $include_path."buyer_request.".$SETTINGS['defaultlanguage'].".inc.php";
  $request_sent = $MSG_25_0142;
  # Update user's status
  @mysql_query("UPDATE HB_users SET accounttype='buyertoseller',reg_date=reg_date WHERE id=".$_SESSION['HAPPYBID_LOGGED_IN']);
  $_SESSION["HAPPYBID_LOGGED_ACCOUNT"] = 'buyertoseller';
}
if(!isset($_SESSION['cptab'])) {$_SESSION['cptab'] = "account";}
switch($_GET['cptab']) {
  case "account":
    $_SESSION['cptab'] = "account";
    break;
  case "selling":
    $_SESSION['cptab'] = "selling";
    break;
  case "buying":
    $_SESSION['cptab'] = "buying";
    break;
  case "stores":
    $_SESSION['cptab'] = "stores";
    break;
}
#// unset session variables related to About me page
unset($_SESSION['pagetitle']);
unset($_SESSION['welcome']);
unset($_SESSION['welcomemsg']);
unset($_SESSION['paragraph']);
unset($_SESSION['paragraphmsg']);
unset($_SESSION['picture']);
unset($_SESSION['auctions']);
unset($_SESSION['template']);
unset($_SESSION['PIZ']);
#// Modifyed by ?ngels, Jul 2003
#// ---> Para la versi?n final ser? necesario relizar comprobaciones
if($_SESSION['STORESENABLED']=='y' && file_exists("./modules/stores/check_store.php")) {
  $prefix="./modules/stores/";
  include ("./modules/stores/check_store.php");
}
$prefix="";

// Build user's selling activity information
if($_SESSION['cptab'] == "selling") {
  $TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
  $NOW = date("YmdHis",$TIME);


  // Active auctions
  $query = "SELECT count(*) AS active_auctions FROM HB_auctions WHERE user='".$_SESSION['HAPPYBID_LOGGED_IN']."' AND closed=0 AND starts<=".$NOW." AND suspended=0";
  $r__ = @mysql_query($query);
  if(!$r__) {
    MySQLError($query);
    exit;
  } else {
    $active_auctions = mysql_result($r__,0,"active_auctions");
  }

  // Closed auctions
  $query = "SELECT count(*) AS closed_auctions FROM HB_auctions WHERE user='".$_SESSION['HAPPYBID_LOGGED_IN']."' AND closed=1 AND suspended<>8 AND (num_bids=0 OR (num_bids>0 AND reserve_price > 0 AND current_bid < reserve_price AND sold='n'))";
  $r__ = @mysql_query($query);
  if(!$r__) {
  //  MySQLError($query);/
  //  exit;
  } else {
    $closed_auctions = mysql_result($r__,0,"closed_auctions");
  }

  // Pending auctions
  $r__ = @mysql_query("SELECT COUNT(id) as COUNT FROM HB_auctions WHERE user='".$_SESSION['HAPPYBID_LOGGED_IN']."' AND starts>".$NOW." AND suspended=0");
  if(!$r__) {
    MySQLError($query);
    exit;
  } else {
    $pending_auctions =  @mysql_result($r__,0,"COUNT");;
  }

  // Suspended auctions
  $r__ = @mysql_query("SELECT count(id) as COUNT FROM HB_auctions WHERE user=".$_SESSION['HAPPYBID_LOGGED_IN']." AND closed= 0 AND suspended<>0");
  if(!$r__) {
    MySQLError($query);
    exit;
  } else {
    $suspended_auctions =  @mysql_result($r__,0,"COUNT");;
  }

  // Sold items
  $query = "SELECT DISTINCT auction FROM HB_winners WHERE seller = '".$_SESSION['HAPPYBID_LOGGED_IN']."'";
  $r__ = @mysql_query($query);
  if(!$r__) {
    MySQLError($query);
    exit;
  } else {
    $sold_items = $num_cat = mysql_num_rows($r__);
  }
}

  // get balance information  
  $query = "select * from HB_users where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
  $result = @mysql_query($query);
  $TPL_balance = "00.00";
  if(!$result) {
      MySQLError($query);
      exit;
  } else {
      $USER = mysql_fetch_array($result);
      $TPL_balance 	= number_format($USER['balance'], 2, '.', '');
      $USER_ID = $USER['id'];
  }

if($_SESSION["HAPPYBID_LOGGED_IN"]) { 
$query_refs = "SELECT COUNT(referrer) FROM HB_users where referrer=".$USER_ID."";  
$result_refs = mysql_query($query_refs) or die(mysql_error()); 
foreach(mysql_fetch_array($result_refs) as $total_referrals);
}


$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
$NOW = date("YmdHis",$TIME);

//------------------------------------------------------------------------------
// prepare classic auctions values (get last created auctions)
    $query = "SELECT
          DISTINCT(a.id), a.title,a.number_of_bids, a.starts, a.ends, a.pict_url, a.auction_type, a.item_value, a.bid_value
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
        $TPL_auctions_classic[$i]["date_created"] = $month . "/" . $day . "/" . $year . " " . $hours . ":" . $minutes . ":" . $seconds;
        $TPL_auctions_classic[$i]["remained_seconds"]=strtotime($TPL_auctions_classic[$i]["date_created"])-time();
        //ArrangeDateNoCorrection($day,$month,$year,$hours,$minutes);
        $TPL_auctions_classic[$i]["name"] = stripslashes($title);
        $TPL_auctions_classic[$i]["link_href_1"] = "./item.php?id=$id";
        $TPL_auctions_classic[$i]["remained_bids"] = $remained_bids;
        $TPL_auctions_classic[$i]["link_href_2"] = "./item.php?id=$id&history=view#history";
        $TPL_auctions_classic[$i]["pict_url"] = $pict_url;
        $TPL_auctions_classic[$i]["item_value"] = stripslashes($item_value);
        $TPL_auctions_classic[$i]["bid_value"] = stripslashes($bid_value);

        // Check if this user winner in this auction 
		$TPL_id_value = $id;
        $sql = "SELECT bid, bidder, COUNT(bid) AS bid_count FROM HB_bids WHERE auction=".$id." GROUP BY bid HAVING bid_count = 1 ORDER BY bid_count ASC, bid ASC ";
        $result_check_winner = mysql_query($sql);
        if ($row = mysql_fetch_array($result_check_winner)){
          if($row['bidder'] == $_SESSION['HAPPYBID_LOGGED_IN']){
            $TPL_auctions_classic[$i]["is_winner"] = "<span style='color:#FF00DE;'>You have the lowest unique bid!</span>";
          }else{
            $TPL_auctions_classic[$i]["is_winner"] = "You're not winning this auction, try a <a href='item.php?id=$TPL_id_value&history=view#history'>bid</a>.";
          }
        }else{
          $TPL_auctions_classic[$i]["is_winner"] = "You're not winning this auction";
        }
        
        $i++;
        
    }


#################################################################################

require("header.php");



//echo $_SESSION['PIZ']."sdfsdf";
//echo $_SESSION["HAPPYBID_LOGGED_IN"];

?>
<center><h3 style='background-color: #EEEEEE;border: 1px solid #DDDDDD;color: #0082D4;display: block;font-size: 18px;margin: 0;padding: 14px;text-transform: capitalize;width: 520px;display:none;' id='label_loading'><!-- Start of loading bar -->
<div class="bar" style="margin-bottom:10px;">
	<span></span>
</div>
<!-- End of loading bar -->Please wait while we redirect you to payment page..</h3>
</center>
<script language="javascript">
// for ten coin
function makeClaimed_ten(campid){
document.getElementById('label_loading').style.display="block";
var datalist="idpay_ten="+campid;
var jqxhr = $.ajax({ 
url: "hook_pyapal.php",
data:datalist,
type:"POST"
})
.success(function(data) {
return true;
})
.error(function() { alert("error"); })
.complete(function() {  document.location="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=NWEAGRB54U47W"; });

return false;
}
// for twentyfive coin
function makeClaimed_twentyfive(campid){
document.getElementById('label_loading').style.display="block";
var datalist="idpay_twentyfive="+campid;
var jqxhr = $.ajax({ 
url: "hook_pyapal.php",
data:datalist,
type:"POST"
})
.success(function(data) {
return true;
})
.error(function() { alert("error"); })
.complete(function() {  document.location="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=HM2MANCMTARCE"; });

return false;
}

// for fifty coin
function makeClaimed_fifty(campid){
document.getElementById('label_loading').style.display="block";
var datalist="idpay_fifty="+campid;
var jqxhr = $.ajax({ 
url: "hook_pyapal.php",
data:datalist,
type:"POST"
})
.success(function(data) {
return true;
})
.error(function() { alert("error"); })
.complete(function() {  document.location="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=N4T8LUQRQKNU2"; });

return false;
}

// for hundred coin

function makeClaimed_hunred(campid){
document.getElementById('label_loading').style.display="block";
var datalist="idpay_hundred="+campid;
var jqxhr = $.ajax({ 
url: "hook_pyapal.php",
data:datalist,
type:"POST"
})
.success(function(data) {
return true;
})
.error(function() { alert("error"); })
.complete(function() {  document.location="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9TX2BU36PGNR2"; });

return false;
}

// for two hundred coin

function makeClaimed_twohunred(campid){
document.getElementById('label_loading').style.display="block";
var datalist="idpay_twohundred="+campid;
var jqxhr = $.ajax({ 
url: "hook_pyapal.php",
data:datalist,
type:"POST"
})
.success(function(data) {
return true;
})
.error(function() { alert("error"); })
.complete(function() {  document.location="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=AR7H8DZK8KKRL"; });

return false;
}


// for five hundred coin

function makeClaimed_fivehunred(campid){
document.getElementById('label_loading').style.display="block";
var datalist="idpay_fivehundred="+campid;
var jqxhr = $.ajax({ 
url: "hook_pyapal.php",
data:datalist,
type:"POST"
})
.success(function(data) {
return true;
})
.error(function() { alert("error"); })
.complete(function() {  document.location="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZGJSNJC2ZZ9X4"; });

return false;
}



</script>





<?php
include phpa_include("template_user_menu_php.html");
include "./footer.php";

?>
