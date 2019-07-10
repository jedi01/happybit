<?

require('./includes/config.inc.php');
include $include_path."auctionstoshow.inc.php";

if(!empty($_GET['user_id'])) {
  $user_id = $_GET['user_id'];
}

if(intval($_REQUEST[user_id] == 0)){
  include "header.php";
  print "
  <tr>
    <td><br/><br/><font class=errorfont>$ERR_100<br/><br/></font></td>
  </tr>";
  include "footer.php";
  exit;
}
$TPL_auction_list_header = $MSG_220;

/* get numner of active auctions for this user */
$query = "select count(id) as auctions FROM HB_auctions
              WHERE user='".addslashes($user_id)."'
              AND closed='1'";
 if($SETTINGS['adultonly']=='y' && !isset($_SESSION["HAPPYBID_LOGGED_IN"])){
   $query .= "AND adultonly='n' ";
 }

$result = mysql_query($query);
if(!$result){
  print "$ERR_001<br />$query<br />".mysql_error();
  exit;
}
$num_auctions = mysql_result($result,0,"auctions");
#// Handle pagination
$TOTALAUCTIONS = $num_auctions;
if(!isset($PAGE) || $PAGE == 1 || $PAGE == "") {
  $OFFSET = 0;
  $PAGE = 1;
} else {
  $OFFSET = ( $PAGE - 1) * $LIMIT;
}
$PAGES = ceil($TOTALAUCTIONS / $LIMIT);  
if(!$PAGES) $PAGES = 1;
/* get active auctions for this user */
$qs = "SELECT * FROM HB_auctions
    WHERE user='".addslashes($_GET['user_id'])."'
    AND closed='1'";
     if($SETTINGS['adultonly']=='y' && !isset($_SESSION["HAPPYBID_LOGGED_IN"])){
       $qs .= "AND adultonly='n' ";
     }
    $qs .= " ORDER BY ends DESC  LIMIT $OFFSET, $LIMIT";
$result = mysql_query ($qs);

if ($result)
{
  $tplv = "";
  $bgColor = "#EBEBEB";
  while ($row=mysql_fetch_array($result))  {

    $bid = $row[current_bid];
    $starting_price = $row[minimum_bid];

    /* prepare some data */
    $date = $row["starts"];
    $y =  substr ($date, 0, 4);
    $m =  substr ($date, 4, 2);
    $d =  substr ($date, 6, 2);
    $h =  substr ($date, 8, 2);
    $min =  substr ($date, 10, 2);
    $sec =  substr ($date, 12, 2);

    $ends_date = strval($row["ends"]);
    $ends_y =  substr ($ends_date, 0, 4);
    $ends_m =  substr ($ends_date, 4, 2);
    $ends_d =  substr ($ends_date, 6, 2);
    $ends_h =  substr ($ends_date, 8, 2);
    $ends_min =  substr ($ends_date, 10, 2);
    $ends_sec =  substr ($ends_date, 12, 2);

    if($bgColor == "#EBEBEB"){
      $bgColor = "#FFFFFF";
    }else{
      $bgColor = "#EBEBEB";
    }

    $tplv .= "<tr ALIGN=CENTER VALIGN=MIDDLE BGCOLOR=\"$bgColor\">";

		/* image icon */
		$tplv .= "<td>";
		if ( strlen($row[pict_url])>0 ) {
			if (intval($row["photo_uploaded"])!=0){
				$row['pict_url'] = $SETTINGS['siteurl']."getthumb.php?w=".$SETTINGS['thumb_show']."&fromfile=$uploaded_path".$row['pict_url'];
			}
			$tplv .= "<a href=\"".$SETTINGS['siteurl']."item.php?id=".$row['id']."\"><img src=\"".$row['pict_url']."\" width=".$SETTINGS['thumb_show']." border=0 alt=\"image\" /></A>";
		}
		else {
			$tplv .= "&nbsp;";
		}
    $tplv .= "</TD>";

    /* this subastas title and link to details */
    $difference = time()-mktime($h,$min,$sec,$m,$d,$y);
    $tplv .=
    "<td ALIGN=LEFT><a href=\"item.php?id=".$row[id]."\">".
    htmlspecialchars($row[title]).
    "</a>";
		if($row['buy_now'] > 0 && $row['bn_only']=='n' && ($row['current_bid'] == 0 || ($row['reserve_price']>0 && $row['current_bid']<$row['reserve_price']))) {
			$tplv .= "&nbsp;&nbsp;&nbsp;(<A HREF=".$SETTINGS['siteurl']."buy_now.php?id=".$row['id']."><IMG ALIGN=MIDDLE SRC=\"".$SETTINGS['siteurl']."images/buy_it_now.gif\" BORDER=0></A>&nbsp;
			<A HREF=javascript:window_open('".$SETTINGS['siteurl']."converter.php?AMOUNT=".$row['buy_now']."','incre',650,200,30,30)>".print_money($row['buy_now'])."</A>".")";
		}elseif($row['buy_now'] > 0 && $row['bn_only']=='y' && ($row['current_bid'] == 0 || ($row['reserve_price']>0 && $row['current_bid']<$row['reserve_price']))) {
			$tplv .= "&nbsp;&nbsp;&nbsp;(<A HREF=".$SETTINGS['siteurl']."buy_now.php?id=".$row['id']."><IMG ALIGN=MIDDLE SRC=\"".$SETTINGS['siteurl']."images/bn_only.png\" BORDER=0></A>&nbsp;
				<A HREF=javascript:window_open('".$SETTINGS['siteurl']."converter.php?AMOUNT=".$row['buy_now']."','incre',650,200,30,30)>".print_money($row['buy_now'])."</A>".")";
		}
    $tplv .= "</td>";

    /* current bid of this subastas */
    if($bid == 0)
    {
      $bid = $starting_price;
    }
    $bid = "<A HREF=javascript:window_open('converter.php?AMOUNT=".$bid."','incre',650,200,30,30)>".print_money($bid)."</A>";

    $tplv .=
    "<td>".
    "<table CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=\"100%\">".
    "<tr VALIGN=TOP><td ALIGN=LEFT>".
    "</td><td ALIGN=CENTER>".
    "$bid".
    "</td></tr></table>".
    "</td>";

    /* number of bids for this subastas */
		$tmp_res = mysql_query ( "SELECT bid FROM HB_bids WHERE auction='".$row[id]."'" );
		if ( $tmp_res )
    $num_bids = mysql_num_rows($tmp_res);
    else
    $num_bids = 0;
		$rpr = (int)$row[reserved_price];
		if ($rpr!=0)
		$reserved_price = " <img src=\"images/r.gif\" alt=\"\" /> ";
		else
		$reserved_price = "";
		$tplv .= "<td>$reserved_price$num_bids</td>";


    /* time left till the end of this subastas */
    $difference = mktime($ends_h,$ends_min,$ends_sec,$ends_m,$ends_d,$ends_y)-time();
    $days_difference = intval($difference / 86400);
    $difference = $difference - ($days_difference * 86400);

    $hours_difference = intval($difference / 3600);

    $difference = $difference - ($hours_difference * 3600);
    $minutes_difference = intval($difference / 60);

    $difference = $difference - ($minutes_difference * 60);
    $seconds_difference = $difference;

    $hours_difference = str_replace("-","",$hours_difference);
    $minutes_difference = str_replace("-","",$minutes_difference);
    $seconds_difference = str_replace("-","",$seconds_difference);

    if(strlen($hours_difference) == 1){
      $hours_difference = "0".$hours_difference;
    }

    if(strlen($minutes_difference) == 1){
      $minutes_difference = "0".$minutes_difference;
    }

    if(strlen($seconds_difference) == 1){
      $seconds_difference = "0".$seconds_difference;
    }

    $tplv .= "<td>$days_difference $MSG_126 <br />$hours_difference:$minutes_difference:$seconds_difference</FONT></td>";


    $tplv .= "</tr>";
    ++$auctions_count;
  }
  $TPL_auctions_list_value = $tplv;
  $num_pages = ceil($num_auctions / $LIMIT);
  //-- Build navigation line
  $TPL_auctions_pagenav="$MSG_290 $num_auctions<br />";
  $TPL_auctions_pagenav.="$MSG_289 $num_pages ($limit $MSG_291)<br />";
  if($num_pages)
    $TPL_auctions_pagenav.="$MSG_5117 ";
  $i = 0;
  while($i < $num_pages ){

    $of = ($i * $limit);

    if($of != $offset){
      $TPL_auctions_pagenav.="<a href=\"".basename($_SERVER["PHP_SELF"])."?offset=$of&amp;user_id=$user_id\" CLASS=\"navigation\">".($i + 1)."</a>";
      if($i < ($num_pages-1)) $TPL_auctions_pagenav.=" | ";
    }else{
      $TPL_auctions_pagenav .= ($i + 1);
      if($i < ($num_pages-1)) $TPL_auctions_pagenav.=" | ";
    }
    $i++;
  }
}
else
$auctions_count = 0;

if ($auctions_count==0)
{
  $TPL_auctions_list_value = "    <tr ALIGN=CENTER><td COLSPAN=5>$MSG_910</td></tr>";;
}

/* get this user's nick */
$query = "SELECT * FROM HB_users WHERE id='".htmlspecialchars($user_id) . "'";
$result = mysql_query ( $query );
if ($result)
{
  if (mysql_num_rows($result)>0)
  $TPL_user_nick = mysql_result ($result,0,"nick");
  else
  $TPL_user_nick = "";
  if(@mysql_result ($result,0,"trusted") == 'y'){
    $TPL_user_trusted = "&nbsp;<img src=\"images/trusted.gif\" alt=\"trusted\" />";
  }else{
    $TPL_user_trusted = "";
  }
}
else
$TPL_user_nick = "";

include "header.php";
include phpa_include("template_auctions_closed.html");
include "footer.php";
exit;
?>
