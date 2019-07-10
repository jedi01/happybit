<?#//v.3.2.5

include './includes/config.inc.php';
include $include_path.'auction_types.inc.php';
include $include_path.'dates.inc.php';
include $include_path."membertypes.inc.php";
#// Get parameters from the URL
$params = getUrlParams("=");
if(empty($_GET['id']))
    $_GET['id'] = $params['id'];
else
    $params['id'] = $_GET['id'];
$id = $params['id'];

$_SESSION["REDIRECT_AFTER_LOGIN"] = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

foreach($membertypes as $idm => $memtypearr) {
    $memtypesarr[$memtypearr['feedbacks']]=$memtypearr;
}
ksort($memtypesarr,SORT_NUMERIC);
$BIDFILE = $SETTINGS['siteurl']."bid_classic.php";

if (!isset($_POST['id']) && !isset($_GET['id']) && isset($_SESSION["CURRENT_ITEM"])) {
    $id = $_SESSION["CURRENT_ITEM"];
}  elseif (isset($_REQUEST['id'])) {
    $_SESSION["CURRENT_ITEM"]=$_REQUEST['id'];
} else {
    // error message
    include "header.php";
    print "<table WIDTH=100% border=0 CELLPADDING=5>
               <tr><td align=\"center\" class=errfont>".$ERR_605."</td></tr>
              </table>";
    include "footer.php";
    exit;
}
// now check if requested auction exists and is/isn't closed
$AuctionIsClosed = false;
$query = "SELECT * FROM HB_auctions WHERE id=".$_SESSION["CURRENT_ITEM"]." and suspended=0";
$result = mysql_query ($query);
if ( mysql_num_rows($result ) == 0) {
    include "header.php";
    print "<table WIDTH=100% border=0 CELLPADDING=5>
                      <tr><td align=\"center\" class=errfont>".$ERR_122."</td></tr>
                      </table>";
    include "footer.php";
    exit;
}
$date_ends	    = mysql_result($result,$i,"ends");    
$ITEM = mysql_fetch_array($result);
$closed = intval(mysql_result($result,0,"closed"));
$page_title = stripslashes($ITEM['title']);
if ($closed==1) $AuctionIsClosed=1;

if ( mysql_result($result,0,"suspended") == 1 ) {
  $closed_or_suspended = 1;
  $ERR_SUSPENDED = $ERR_123;
}

if ( $closed_or_suspended ) {
  include "header.php";
  print "<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 BGCOLOR=#ffffff>
            <TR><TD><CENTER>".
              mysql_result($result,0,"title").
              "<br>$std_font $ERR_SUSPENDED 
              </FONT></CENTER></TD></TR>
            </TABLE>";
  include "footer.php";
  exit;
}

if($SETTINGS['adultonly']=='y' && !isset($_SESSION["HAPPYBID_LOGGED_IN"]) && $ITEM['adultonly']=='y'){
    Header("Location: index.php");
    exit;
}

$query = "select * from HB_bids where auction=".intval($id)." ORDER BY id DESC";
$result_numbids = mysql_query ($query);
if (!$result_numbids) {
    MySQLError($query);
    exit;
}
$num_bids = mysql_num_rows ($result_numbids);
if ($num_bids > 0 && !isset($_GET['history'])) {
    $TPL_BIDS_value = "<a href='".$SETTINGS[siteurl]."item.php?id=$id&history=view#history'>$MSG_105</a>";
} elseif (isset($_GET['history'])) {
    $TPL_BIDS_value = "<a href='".$SETTINGS[siteurl]."item.php?id=$id'>$MSG_507</a>";
}

/* get auction data  */
$query = "select * from HB_auctions where id=".intval($id);
$result = mysql_query($query);
if ( !$result ) {
    MySQLError($query);
    exit;
}

$user           = stripslashes(mysql_result ( $result, 0, "user" ));
$title          = stripslashes(mysql_result ( $result, 0, "title" ));
$date           = mysql_result ( $result, 0, "starts" );
$description    = stripslashes(mysql_result ( $result, 0, "description" ));
$pict_url       = mysql_result ( $result, 0, "pict_url" );
$category       = mysql_result ( $result, 0, "category" );
$minimum_bid    = mysql_result ( $result, 0, "minimum_bid" );
$reserve_price  = mysql_result ( $result, 0, "reserve_price" );
$buy_now        = mysql_result ( $result, 0, "buy_now" );
$buy_now_price  = mysql_result ( $result, 0, "buy_now" );
$auction_type   = mysql_result ( $result, 0, "auction_type" );
$location       = mysql_result ( $result, 0, "location" );
$customincrement = mysql_result ( $result, 0, "increment" );
$location_zip   = mysql_result ( $result, 0, "location_zip" );
$shipping       = mysql_result ( $result, 0, "shipping" );
$shipping_terms = mysql_result ( $result, 0, "shipping_terms" );
$payment        = mysql_result ( $result, 0, "payment" );
$international  = mysql_result ( $result, 0, "international" );
$ends           = mysql_result ( $result, 0, "ends" );
$current_bid    = mysql_result ( $result, 0, "current_bid" );
$phu = intval(mysql_result( $result,0,"photo_uploaded") &&($pict_url!=''));
$atype = intval(mysql_result($result,0,"auction_type"));
$iquantity = mysql_result ($result,0,"quantity");
$nowt = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
$difference = mktime(substr ($ends, 8, 2),
substr ($ends, 10, 2),
substr ($ends, 12, 2),
substr ($ends, 4, 2),
substr ($ends, 6, 2),
substr ($ends, 0, 4))- $nowt;
$_SESSION['CURRENTAUCTIONUSER'] = $user;
$_SESSION['CURRENTAUCTIONTITLE'] = $title;
#// Does the seller have a About me page
if($SETTINGS['aboutme'] == 'y') {
    $query = "SELECT user FROM HB_aboutmeusers WHERE user=".intval($user);
    $res_ab = @mysql_query($query);
    if(!$res_ab) {
        MySQLError($query);
        exit;
    } elseif(mysql_num_rows($res_ab) > 0) {
        $SELLERHASABOUTME = $user;
    } else {
        $SELLERHASABOUTME = FALSE;
    }
}

require("header.php");

$TPL_auction_type = $auction_types[$atype];
/*    if ($atype==2)
{ */
$TPL_auction_quantity = $iquantity;
$TPL_qty = "<SELECT NAME=qty SIZE=1>";
for ($i=1; $i<=$iquantity; $i++) {
    $TPL_qty .= "<OPTION VALUE=$i ";
    if ($i==1){$TPL_qty .= "SELECTED";}
    $TPL_qty .=  ">".$i." </OPTION>";
}
$TPL_qty .= "</SELECT>";
/*    } */

#// Added by Gian dec. 12 2002
#//
#// Auction view counter
$query = "SELECT counter as counter from HB_auccounter where auction_id=".intval($id);
$rcount=@mysql_query($query);
if(!$rcount) {
    MySQLError($query);
    exit;
}
if(mysql_num_rows($rcount)==0) {
    mysql_query("INSERT INTO HB_auccounter VALUES (".intval($id).",1)");
    $TPL_nr=1;
} else {
    $TPL_nr=mysql_result($rcount,0,"counter");
    mysql_query("UPDATE HB_auccounter set counter='".intval($TPL_nr+1)."' where auction_id=".intval($id));
}
//categories list
$c_name[] = array(); $c_id[] = array();
$TPL_cat_value = "";

$query = "SELECT cat_id,parent_id,cat_name FROM HB_categories WHERE cat_id=".intval($category);
$result = mysql_query($query);
if ( !$result ) {
    MySQLError($query);
    exit;
}
$result     = mysql_fetch_array ( $result );
$parent_id  = $result['parent_id'];
$cat_id     = $categories;

$j = $category;
$i = 0;
do {
    $query = "SELECT cat_id,parent_id,cat_name FROM HB_categories WHERE cat_id='$j'";
    $result = mysql_query($query);
    if ( !$result )    {
        MySQLError($query);
        exit;
    }
    $result = mysql_fetch_array ( $result );
    if ( $result ) {
        $parent_id  = $result['parent_id'];
        #//  Select the translated category name
        $cat_name = @mysql_result(mysql_query("SELECT cat_name FROM HB_cats_translated WHERE cat_id=".$result['cat_id']." AND lang='".$language."'"),0,"cat_name");
        
        $c_name[$i] = $cat_name;
        $c_id[$i]   = $result['cat_id'];
        $i++;
        $j = $parent_id;
    } else {
        // error message
        print "<p class=errfont>".$ERR_620."</p>";
        include "footer.php";
        exit;
    }
} while ( $parent_id != 0 );

for ($j=$i-1; $j>=0; $j--) {
    if ( $j == 0) {
        $TPL_cat_value .= "<a href='".$SETTINGS['siteurl']."browse.php?id=".$c_id[$j]."'>".$c_name[$j]."</a>";
    } else {
        $TPL_cat_value .= "<a href='".$SETTINGS['siteurl']."browse.php?id=".$c_id[$j]."'>".$c_name[$j]."</a> / ";
    }
}


#// Pictures Gellery
$K = 0;
if(file_exists($uploaded_path.$id)) {
    $dir = @opendir($uploaded_path.$id);
    if($dir) {
        while($file = @readdir($dir)) {
            if($file != "." && $file != "..") {
                $UPLOADED_PICTURES[$K] = $file;
                $K++;
            }
        }
        @closedir($dir);
    }
    $GALLERY_DIR = $id;
    
    $TPL_show_gallery = "";
    if(is_array($UPLOADED_PICTURES)) {
        $TPL_show_gallery .= "<table><tr>";
        while(list($k,$v) = each($UPLOADED_PICTURES)) {
            $TMP = @GetImageSize($uploaded_path.$GALLERY_DIR."/".$v);
            if ($TMP[2]>=1 && $TMP[2]<=3) {
                $WIDTH = $TMP[0];
                $HEIGHT = $TMP[1];
                $TPL_show_gallery .= "<td><a href=\"javascript:window_open('".$SETTINGS['siteurl']."view_gallery.php?img=$uploaded_path$GALLERY_DIR/$v','$k',$WIDTH+20,$HEIGHT+20,0,0)\"><img src='".$SETTINGS['siteurl']."getthumb.php?w=".$SETTINGS['thumb_show']."&fromfile=$uploaded_path"."$GALLERY_DIR/$v' border=0 WIDTH=".$SETTINGS['thumb_show']." HSPACE=10 /></a></td>";
            }
        }
        $TPL_show_gallery .= "</tr></table>";
    }
    if(count($UPLOADED_PICTURES) > 0) {
        $TPL_gallery = "<a href='#gallery'><img src=".$SETTINGS['siteurl']."images/gallery.gif border=0 alt='gallery' /></a>&nbsp;<a href='#gallery'>$MSG_694</a>";
    } else {
        $TPL_gallery = "";
    }
}

//-- Get RESERVE PRICE information
if ($reserve_price > 0) {
    $TPL_reserve_price = "$MSG_030 ";
    
    //-- Has someone reached the reserve price?
    if($current_bid < $reserve_price) {
        $TPL_reserve_price .= " ($MSG_514)";
    } else {
        $TPL_reserve_price .= " ($MSG_515) ";
    }
} else {
    $TPL_reserve_price = "$MSG_029";
}


//-- BUY NOW ++++++++++++++++++++++++++++++
$query= "select min(bid) AS minbid FROM HB_proxybid WHERE itemid=".intval($id);
$res = @mysql_query($query);
$minbid=mysql_result ( $res, 0, "minbid" );

if ($buy_now_price > 0 && ($num_bids==0 || ($reserve_price >0 && $current_bid < $reserve_price)) && !($minbid>0 && $minbid >= $reserve_price) && $difference > 0) {
    $buy_now_price = print_money($buy_now_price);
    $TPL_buy_now_price = "$buy_now_price  <a href='".$SETTINGS['siteurl']."buy_now.php?id=$id'><img border='0' align='absbottom' alt='$MSG_496' src='".$SETTINGS['siteurl']."images/buy_it_now.gif' /></a>";
} else {
    $TPL_buy_now_price = $MSG_029;
}

$TPL_id_value           = $id;
$TPL_title_value        = $title;
$description  = $description;
//print $phu;

/* get user's nick */
$query      = "SELECT id,nick,trusted,reg_date FROM HB_users WHERE id=".intval($user);

$result_usr = mysql_query ( $query );
if ( !$result_usr ) {
    print $ERR_001;
    exit;
}
$user_nick      = "";//mysql_result ( $result_usr, 0, "nick");
$user_id        = "";//mysql_result ( $result_usr, 0, "id");
$user_trusted   = "";//mysql_result ( $result_usr, 0, "trusted");
$tmp_reg_date   = "";//mysql_result ( $result_usr, 0, "reg_date");
if (mysql_get_client_info() < 4.1 || !strstr($tmp_reg_date,"-")){
  $day = substr($tmp_reg_date,6,2);
  $month = substr($tmp_reg_date,4,2);
  $year = substr($tmp_reg_date,0,4);
  $hours = substr($tmp_reg_date,8,2);
  $minutes = substr($tmp_reg_date,10,2);
} else {
  $day = substr($tmp_reg_date,8,2);
  $month = substr($tmp_reg_date,5,2);
  $year = substr($tmp_reg_date,0,4);
  $hours = substr($tmp_reg_date,11,2);
  $minutes = substr($tmp_reg_date,14,2);
}
$user_reg_date = ArrangeDateNoCorrection($day,$month,$year,$hours,$minutes);

$TPL_user_nick_value = $user_nick;
if($user_trusted == 'y'){
    $TPL_seller_trusted = "&nbsp;<img src=\"".$SETTINGS['siteurl']."images/trusted.gif\" alt=\"trusted\"/>";
}else{
    $TPL_seller_trusted = "";
}
$TPL_user_reg_date = $MSG_5508.$user_reg_date;

/* get bids for current item */
$query          = "select min(bid) AS minbid, bidder FROM HB_bids WHERE auction=".intval($id)." GROUP BY auction, bidder ORDER BY id DESC";
$result_bids = mysql_query($query);
if ( !$result_bids ) {
    print $ERR_001;
    exit;
}

if ( mysql_num_rows($result_bids ) > 0) {
    $min_bid       = mysql_result ( $result_bids, 0, "minbid" );
    $min_bidder_id = mysql_result ( $result_bids, 0, "bidder" );

    #// Does the seller have a About me page
    if($SETTINGS['aboutme'] == 'y')    {
        $query = "SELECT user FROM HB_aboutmeusers WHERE user=".intval($min_bid);
        $res_ab = @mysql_query($query);
        if(!$res_ab) {
            MySQLError($query);
            exit;
        } elseif(mysql_num_rows($res_ab) > 0) {
            $BIDDERHASABOUTME = $min_bidder_id;
        } else {
            $BIDDERHASABOUTME = FALSE;
        }
    }
}

if ( !mysql_num_rows($result_bids) ) {
    $num_bids = 0;
    $min_bid = 0;
} else {
    /* Get number of bids  */
    $num_bids = mysql_num_rows ( $result_numbids );

    /* Get bidder nickname */
    $query         = "select id,nick,trusted from HB_users where id=".intval($min_bidder_id);
    $result_bidder = mysql_query($query);
    if ( !$result_bidder ) {
        MySQLError($query);
        exit;
    }
    $min_bidder_id   = mysql_result ( $result_bidder, 0, "id" );
    $min_bidder_nick = mysql_result ( $result_bidder, 0, "nick" );
    $min_bidder_trusted = mysql_result ( $result_bidder, 0, "trusted" );
    if($min_bidder_trusted == 'y'){
        $TPL_bidder_trusted = "&nbsp;<img src=\"".$SETTINGS['siteurl']."images/trusted.gif\" alt=\"trusted\"/>";
    }else{
        $TPL_bidder_trusted = "";
    }

}

#// #####################################################################################################
#// If no bids placed, the current bid is the minimum bid

if($min_bid == 0) {
    $MIN_BID = $minimum_bid;
} else {
    $MIN_BID = $min_bid;
}

/* Get bid increment for current bid and calculate minimum bid */
$query = "SELECT increment FROM HB_increments WHERE".
"((low<=$MIN_BID AND high>=$MIN_BID) OR".
"(low<$MIN_BID AND high<$MIN_BID)) ORDER BY increment DESC";

$result_incr = mysql_query  ( $query );
if(mysql_num_rows($result_incr) != 0) {
    $increment   = mysql_result ( $result_incr, 0, "increment" );
}

if($atype == 2) {
    $increment = 0;
}

if($customincrement > 0) {
    $increment   = $customincrement;
}

if ($min_bid == 0 || $atype ==2) {
    $next_bid = $minimum_bid;
} else {
    $next_bid = $min_bid - $increment;
}

$min_bid = $MIN_BID;

if ( $pict_url ) {
    $TPL_pict_url_value  = "<a href='#image'><img src='".$SETTINGS['siteurl']."images/picture.gif' border=0 alt='image' /></a>&nbsp;"
    ."<a href='#image'>$MSG_108</a>"
    ."<img src='".$SETTINGS['siteurl']."images/transparent.gif' WIDTH=15 alt='' />";
}

/* Get current number of feedbacks */
$query          = "SELECT rated_user_id FROM HB_feedbacks WHERE rated_user_id=".intval($user_id);
$result         = mysql_query   ( $query );
$num_feedbacks  = mysql_num_rows ( $result );
$num_feedbacks_not_same_rater  = mysql_num_rows ( $result );
$query          = " SELECT rated_user_id FROM HB_feedbacks WHERE rated_user_id='$user_id'";
$result         = mysql_query   ( $query );

/* Get current total rate value for user */
$query         = "SELECT distinct count(*) total FROM HB_feedbacks WHERE rated_user_id=".$user_id." AND rate<>0";

$result        = mysql_query  ( $query );
if($result && mysql_num_rows($result) > 0) {
    $total_rate    = mysql_result ( $result, 0, "total" );
}

/* Get positive and negative feedbacks for user Edgar 18/09/2005 */
$query         = "SELECT distinct count(*) negative FROM HB_feedbacks WHERE rated_user_id='$user_id' and rate=-1";
$result        = mysql_query  ( $query );
if($result && mysql_num_rows($result) > 0) {
    $negative_feedbacks    = mysql_result ( $result, 0, "negative" );
}else $negative_feedbacks = 0;

$query         = "SELECT distinct count(*) positive FROM HB_feedbacks WHERE rated_user_id='$user_id' and rate=1";
$result        = mysql_query  ( $query );
if($result && mysql_num_rows($result) > 0) {
    $positive_feedbacks    = mysql_result ( $result, 0, "positive" );
}else $negative_feedbacks = 0;

$TPL_vendetor_value = "<a href='".$SETTINGS['siteurl']."profile.php?user_id=$user_id&auction_id=$id'><b>".$TPL_user_nick_value."</b></a>";

$i=0;
foreach ($memtypesarr as $k=>$l) {
    if($k >= $total_rate || $i++==(count($memtypesarr)-1)) {
        $TPL_rate_radio="<img src=\"".$SETTINGS['siteurl']."images/icons/".$l['icon']."\" alt=\"".$l['icon']."\" />";
        break;
    }
}
$TPL_num_feedbacks="( <A HREF='".$SETTINGS['siteurl']."feedback.php?id=$user_id&faction=show'>$total_rate</A> )";

#// Positive and negative feedback
$TPL_percent_positive_feedbacks=$num_feedbacks > 0 ? "(".ceil($positive_feedbacks*100/$total_rate)."%)" : "0%";
$TPL_percent_negative_feedbacks=$negative_feedbacks > 0 ? "&nbsp;&nbsp;&nbsp;<b>$MSG_5507 (".ceil($negative_feedbacks*100/$total_rate)."%)</B><br>" : "";

$TPL_tot_feedbacks="<a href=".$SETTINGS['siteurl']."feedback.php?id=$user_id&faction=show>(".$num_feedbacks.")</a>";
/* High bidder  */
if ( $min_bidder_id ) {
    $TPL_hight_bidder_id  = "<tr><td WIDTH='30%'><b>"
    .$MSG_117.":</b></td><td>"
    ."<a href='".$SETTINGS['siteurl']."profile.php?user_id=$min_bidder_nick'>$min_bidder_nick</a>";

    /* Get current number of feedbacks */
    $query           = "select rated_user_id from HB_feedbacks where rated_user_id=".intval($min_bidder_id);
    $result           = mysql_query ( $query );
    $num_feedbacks = mysql_num_rows($result);

    /* Get current total rate value for user */
    $query = "select rate_sum,nick,id from HB_users where nick='".addslashes($min_bidder_nick)."'";
    $result = mysql_query($query);

    $total_rate = mysql_result($result,0,"rate_sum");
    $nickname = mysql_result($result,0,"nick");
    $userid = mysql_result($result,0,"id");

    $i=0;
    foreach ($memtypesarr as $k=>$l) {
        if($k >= $total_rate || $i++==(count($memtypesarr)-1)) {
            $TPL_bidder_rate_radio="<img src=\"".$SETTINGS['siteurl']."images/icons/".$l['icon']."\" alt=/".$l['icon']."\" />";
            break;
        }
    }

    $TPL_hight_bidder_id ="<a href='".$SETTINGS['siteurl']."profile.php?user_id=$userid&auction_id=$id'><b>$min_bidder_nick</b></a>";
    $TPL_bidder_rate="<b>($total_rate)</b>";
    $TPL_bidder_feedbacks="<a href='".$SETTINGS['siteurl']."feedback.php?id=$userid&faction=show'>(".$num_feedbacks.")</a>";
}

if ($difference > 0) {
    $days_difference = floor($difference / 86400);
    $difference = $difference % 86400;
    $hours_difference = floor($difference / 3600);
    $difference = $difference % 3600;
    $minutes_difference = floor($difference / 60);
    $seconds_difference = $difference % 60;
    $TPL_difference_value = sprintf("%d%s %02dh:%02dm:%02ds",$days_difference,$MSG_126, $hours_difference,$minutes_difference,$seconds_difference);
    
    $year_ends = substr($date_ends,0,4);          $month_ends = substr($date_ends,4,2);
    $day_ends = substr($date_ends,6,2);           $hours_ends = substr($date_ends,8,2);
    $minutes_ends = substr($date_ends,10,2);      $seconds_ends = substr($date_ends,12,2);
    $TPL_date_ends = $month_ends."/".$day_ends."/".$year_ends." ".$hours_ends.":".$minutes_ends;
} else {
    $TPL_difference_value = "<SPAN CLASS=errfont>$MSG_911</SPAN>";
}

$TPL_num_bids_value  = $num_bids;
$TPL_currency_value1 = "<a href=javascript:window_open('".$SETTINGS['siteurl']."converter.php?AMOUNT=$minimum_bid','incre',650,250,30,30)>".print_money($minimum_bid)."</a>";
$TPL_currency_value2 = "<a     href=javascript:window_open('".$SETTINGS['siteurl']."converter.php?AMOUNT=$min_bid','incre',650,250,30,30)>".print_money($min_bid)."</a>";
if($difference > 0) {
    $TPL_currency_value3 = "<a href=javascript:window_open('".$SETTINGS['siteurl']."converter.php?AMOUNT=$increment','incre',650,250,30,30)>".print_money($increment)."</a><br />";
    $TPL_currency_value4 = "<a href=javascript:window_open('".$SETTINGS['siteurl']."converter.php?AMOUNT=$next_bid','incre',650,250,30,30)>".print_money($next_bid)."</a>";
} else {
    $TPL_currency_value3 = "--<br />";
    $TPL_currency_value4 = "--";
}

/* Bidding table */
$TPL_next_bid_value   = $next_bid;
$TPL_user_id_value    = $user_id;
$TPL_title_value      = $title;
$TPL_category_value   = $category;
$TPL_id_value         = $id;

/* Description & Image table */
$TPL_description_value = nl2br($description);

// see if it's an uploaded picture
if ( $phu ) {
    $pict_url = $uploaded_path.$pict_url;
    $img=@getimagesize($pict_url);
    $sizedata=$img[3];
    $TPL_pict_url = "<img src='".$SETTINGS['siteurl']."$pict_url' $sizedata border=0 alt=\"\" />";
} elseif ($pict_url!='') {
    $TPL_pict_url = "<img src='$pict_url' border=0  alt=\"\" />";
} else {
    $TPL_pict_url = "<b>$MSG_114</b>";
}

/* Get location description */
include $include_path."countries.inc.php";
while ( list($key, $val) = each ($countries) ) {
    if ( $val == $location ) {
        $location_name = $val;
    }
}
$TPL_location_name_value = $location_name;
$TPL_location_zip_value  = "(".$location_zip.")";

if ( $shipping == '1' ) {
    $TPL_shipping_value = $MSG_038;
} else {
    $TPL_shipping_value = $MSG_032;
}
$TPL_shipping_terms = nl2br(stripslashes($shipping_terms));

if ( $international ) {
    $TPL_international_value = ", $MSG_033";
} else {
    $TPL_international_value = ", $MSG_043";
}

/* Get Payment methods */
$payment_methods = explode("\n",$payment);
$i = 0;
$c = count($payment_methods);
$began = false;
while ($i<$c) {
    if (strlen($payment_methods[$i])!=0 ) {
        if ($began) {
            $TPL_payment_value .= ", ";
        } else {
            $began = true;
        }
        $TPL_payment_value .= trim($payment_methods[$i]);
    }
    $i++;
}

$TPL_date_string1   = ArrangeDateNoCorrection(substr($date,6,2),substr($date,4,2),substr($date,0,4),substr($date,8,2),substr($date,10,2));
$TPL_date_string2   = ArrangeDateNoCorrection(substr($ends,6,2),substr($ends,4,2),substr($ends,0,4),substr($ends,8,2),substr($ends,10,2));

include (phpa_include("template_item_php.html"));

if (isset($_GET['history']) && $num_bids > 0) {
    $i = 0;
    while ($bidrec=mysql_fetch_assoc($result_numbids)) {
        // --Get bidder's nickname
        $query = "select id,nick from HB_users where id=".$bidrec['bidder'];
        $result_bidder = mysql_query($query);
        if (!$result) {
            MySQLError($query);
            exit;
        }
        $bidrec['bidder_name'] = mysql_result ($result_bidder, 0, "nick");

        // -- Format bid date
        $bidrec['bidwhen']=ArrangeDateNoCorrection(    substr($bidrec['bidwhen'], 6, 2),
        substr($bidrec['bidwhen'], 4, 2),
        substr($bidrec['bidwhen'], 0, 4),
        substr($bidrec['bidwhen'], 8, 2),
        substr($bidrec['bidwhen'], 10, 2)).":".substr($bidrec['bidwhen'], 12, 2);
        $bidrecords[]=$bidrec;
    }
    include (phpa_include("template_bidhistory_php.html"));
}
require("footer.php");
?>
