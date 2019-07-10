<?

include "../includes/config.inc.php";
include "loggedin.inc.php";
include $include_path."countries.inc.php";
include $include_path.'auction_types.inc.php';

$username = $name;

//-- Data check
if(!$_REQUEST["id"]) {
  $URL = $_SESSION["RETURN_LIST"];
  unset($_SESSION["RETURN_LIST"]);
  header("Location: $URL");
  exit;
}

if($_POST['action'] == "Delete" && strstr(basename($_SERVER['HTTP_REFERER']),basename($_SERVER['PHP_SELF']))) {
  if(!$ERR) {
    //-- Get category
    $query = "select category,photo_uploaded,pict_url from HB_auctions where id='".$_POST["id"]."'";
    $res__ = mysql_query($query);
    if(!$res__) {
      print $ERR_001." $query<BR>".mysql_error();
      exit;
    } else {
      $cat_id = mysql_result($res__,0,"category");
      $photo_uploaded = mysql_result($res__,0,"photo_uploaded");
      $pict_url = mysql_result($res__,0,"pict_url");
    }

    //-- delete auction
    $sql="delete from HB_auctions WHERE id='".$_POST["id"]."'";
    $res=mysql_query ($sql);

    //-- Update counters
    mysql_query("update HB_counters set auctions=(auctions-1)");

    //-- delete bids
    $query = "SELECT count(auction) as BIDS from HB_bids WHERE auction='".$_POST["id"]."'";
    $res = mysql_query($query);
    if(!$res) {
      print "ERROR: $query<BR>".mysql_error();
      exit;
    }
    if(mysql_num_rows($res) > 0) {
      $BIDS = mysql_result($res,0,"BIDS");
      $sql="delete from HB_bids WHERE auction='".$_POST["id"]."'";
      $res=mysql_query ($sql);

      #// Delete entries from the proxybid table
      $sql="delete from HB_proxybid WHERE itemid='".$_POST["id"]."'";
      $res=mysql_query ($sql);
    } else {
      $BIDS = 0;
    }

    #// Delete file in counters
    mysql_query("DELETE HB_auccounter where auction_id=".$_POST["id"]);

    //-- Update counters
    mysql_query("update HB_bids set bids=(bids-$BIDS)");

    // update "categories" table - for counters
    $root_cat = $cat_id;
    do {
      // update counter for this category
      $query = "SELECT * FROM HB_categories WHERE cat_id=\"$cat_id\"";
      $result = mysql_query($query);

      if($result) {
        if (mysql_num_rows($result)>0) {
          $R_parent_id = mysql_result($result,0,"parent_id");
          $R_cat_id = mysql_result($result,0,"cat_id");
          $R_counter = intval(mysql_result($result,0,"counter"));
          $R_sub_counter = intval(mysql_result($result,0,"sub_counter"));
          
          $R_sub_counter--;
          if ( $cat_id == $root_cat )
          --$R_counter;
          
          if($R_counter < 0) $R_counter = 0;
          if($R_sub_counter < 0) $R_sub_counter = 0;
          
          $query = "UPDATE HB_categories SET counter='$R_counter', sub_counter='$R_sub_counter' WHERE cat_id=\"$cat_id\"";
          @mysql_query($query);
          
          $cat_id = $R_parent_id;
        }
      }
    } while ($cat_id!=0);

    #// ##############################################################################################
    #// Delete any image for this auction (uploaded picture and pictures gallery)

    #// Pictures gallery
    if(file_exists($image_upload_path.$_POST["id"])) {
      if($dir = @opendir($image_upload_path.$_POST["id"])) {
        while($file = readdir($dir)) {
          if($file != "." && $file != "..") {
            @unlink($image_upload_path.$_POST["id"]."/".$file);
          }
        }
        closedir($dir);
        @rmdir($image_upload_path.$_POST["id"]);
      }
    }

    #// Uploaded picture
    if($photo_uploaded)  {
      @unlink($image_upload_path.$pict_url);
    }

    $URL = $_SESSION["RETURN_LIST"];
    unset($_SESSION["RETURN_LIST"]);
    Header("location:  $URL?offset=".$_REQUEST["offset"]);
  }
}


if(!$_POST["action"]) {
  $query = "select a.id, u.nick, a.title, a.starts, a.description,
    c.cat_name, d.description as duration, a.suspended, a.current_bid,
    a.quantity, a.reserve_price, a.location,
    a.item_value, a.auction_type, a.minimum_bid, a.second_duration, a.bid_value from HB_auctions
    a, HB_users u, HB_categories c, HB_durations d
    WHERE a.id=\"".$_GET["id"]."\"";
    //u.id = a.user and d.days = a.duration and 
  $result = mysql_query($query);
  if(!$result) {
    print "Database access error: abnormal termination".mysql_error();
    exit;
  }

  $id = mysql_result($result,0,"id");
  $title = mysql_result($result,0,"title");
  $nick = mysql_result($result,0,"nick");
  $tmp_date = mysql_result($result,0,"starts");
  $duration = mysql_result($result,0,"duration");
  $category = mysql_result($result,0,"cat_name");
  $description = mysql_result($result,0,"description");
  $suspended = mysql_result($result,0,"suspended");
  $current_bid = mysql_result($result,0,"current_bid");
  $quantity = mysql_result($result,0,"quantity");
  $reserve_price = mysql_result($result,0,"reserve_price");
  $country = mysql_result($result, 0, "location");
  $item_value= mysql_result($result, 0, "item_value");
   //reset($auction_types);
  $auction_type= $auction_types[mysql_result($result, 0, "auction_type")];
  $min_bid= mysql_result($result, 0, "minimum_bid");
  $second_duration= mysql_result($result, 0, "second_duration");
  $bid_value= mysql_result($result, 0, "bid_value");

  $country_list="";
  while (list ($code, $descr) = each ($countries)) {
    $country_list .= "<option value=\"$code\"";
    if ($code == $country) {
      $country_list .= " selected";
    }
    $country_list .= ">$descr</option>\n";
  };

  $day = substr($tmp_date,6,2);
  $month = substr($tmp_date,4,2);
  $year = substr($tmp_date,0,4);
  if($SETTINGS[datesformat] == "USA") {
    $date = "$month/$day/$year";
  } else {
    $date = "$day/$month/$year";
  }
}

?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr> 
          <td width="30"><img src="images/i_auc.gif" ></td>
          <td class=white><?=$MSG_239?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_325?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
    <tr> 
      <td align="center" valign="middle">
		<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#546f95" ALIGN="CENTER">
			<TR>
			<TD ALIGN=CENTER class=title>
              <? print $MSG_325; ?>
            </TD>
          </TR>
        <TR>
            <TD ALIGN="CENTER">
            <TABLE WIDTH=100% CELLPADDING=4 CELLSPACING=0 BORDER=0 BGCOLOR="#FFFFFF">
              <TR>
								<TD ALIGN=CENTER COLSPAN=2> <BR><BR>
                </TD>
              </TR>
              
              
             
             
              <TR>
                <TD WIDTH="204">&nbsp;</TD>
                <TD WIDTH="486">
                  <? print $MSG_326; ?>
                </TD>
              </TR>
              <TR>
                <TD WIDTH="204">&nbsp;</TD>
                <TD WIDTH="486">
                  <FORM NAME=details ACTION="deleteauction.php" METHOD="POST">
                    <INPUT TYPE="hidden" NAME="id" VALUE="<? echo $_GET["id"]; ?>">
                    <INPUT TYPE="hidden" NAME="offset" VALUE="<? echo $_REQUEST["offset"]; ?>">
                    <INPUT TYPE="hidden" NAME="action" VALUE="Delete">
                    <INPUT TYPE="submit" NAME="act" VALUE="<? print $MSG_008; ?>">
                  </FORM>
                </TD>
              </TR>
            </TABLE>
          </TD>
        </TR>
      </TABLE>
    </TD>
  </TR>
</TABLE>
</BODY>
</HTML>