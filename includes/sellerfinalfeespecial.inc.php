<?# //v.3.2.0
if(!defined('INCLUDED')) exit("Access denied");
# // SELLER FINAL FEE
$balance = true;
$finalfee = 0;
$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
$NOWB = date("Ymd",$TIME);
if ($SETTINGS['sellerfinalfee'] == 1) {
  $finalfee = 1;
  # // Calculate seller's FEE
  /**
  * NOTE: New recursive fee calculation
  */
  $FEE = 0;
}
if ($Auction['auction_type'] == '1')  
  $BASEAMOUNT = $Auction['current_bid'];
elseif($Auction['auction_type'] == '2') {
  $BASEAMOUNT = $WINNING_BID * $items_sold;
}else{
  $BASEAMOUNT = $fixed_price * $qty;
}
reset($SELLER_PERCENTAGE);
while (list($k, $v) = each($SELLER_PERCENTAGE)) {
  # // Fix fee
  if ($Auction['duration'] == $k) {
    $FEE = $SELLER_PERCENTAGE[$k];
  }
}
$query = "SELECT * from HB_special_category_fees
     WHERE cat_id=".$Auction['category'];
$res__ = mysql_query($query);
    
if ($res__ && mysql_num_rows($res__) > 0) {
  while ($row = mysql_fetch_array($res__)) {
    $SELLER_PERCENTAGE[$row['days']] = $row['finalfee'];
  }
}

// Set the value of the field 'closed' of the table HB_auctions. 
// Set 'closed' value to -1 (fee pending) for this auction but if fees free there is no pending fee
$statusclosed = $feesfree == 'y' ? '1' : '-1';

// Set the value of the field 'fee' of the table HB_winners. 
// Set 'fee' value to 1 (is there is fee) and 0 otherwise but if fees free there is no fee (value zero)
$statusfee = $feesfree == 'y' ? '0' : '1';

# // ######################################################
# // Add the temp invoice line to the database
# // ######################################################
if ($SETTINGS['invoicing'] == 'y') {
  $TODAY = $NOWB;
  $query = "INSERT INTO HB_tmpinvoice VALUES(
        NULL,
        ".$Seller['id'].",
        '$TODAY',
        '$MSG_5257',
        '$MSG_5257 ($MSG_168: ".$Auction['title'].")'," .
  doubleval($FEE) . ")";
  $res = @mysql_query($query);
  // If it is fixed price, does not close the auction
  if ($atype != 3) {
    $query = "UPDATE HB_auctions
          SET closed='1'
          WHERE id=".$Auction['id'];
    $res = @mysql_query($query);
  }
  # // Set the entry in the winners table as "suspended"
  # // FEE field values
  # // 1 - seller and winner still have to pay
  # // 2 - seller payed, winner still have to pay
  # // 3 - buyer payed, seller still have to pay
  # // 0 - seller and winnre payed
  $query = "UPDATE HB_winners
             SET   fee=".$statusfee."
          WHERE auction=".$Auction['id'];
  $res = @mysql_query($query);
  if($Seller['endemailmode']!='cum'){
    if ($atype != 3){ 
      include $include_path.'endauction_winner.inc.php';
    }
  }else{
    #// Save in the database to send later
    @mysql_query("INSERT INTO HB_pendingnotif VALUES (
            NULL,
            ".$Auction['id'].",
            ".$Seller['id'].",
            '$report_text',
            '".serialize($Auction)."',
            '".serialize($Seller)."',
            '".date("Ymd")."')");
  }
} else {
  # // ######################################################
  # // check for PREPAY FEES SETTINGS
  # // ######################################################
  if ($SETTINGS['feetype'] == "prepay") {
    # // Check if the seller has enough credit to be charged
    if ($Seller['balance'] == 0 || $Seller['balance'] < $FEE) {
      # // Set "closed" value to -1 (fee pending) for this auction
      if ($atype != 3) {
        $query = "UPDATE HB_auctions SET closed='".$statusclosed."' where id=".$Auction['id'];
        $res = @mysql_query($query);
      }
      # // Set the entry in the winners table as "suspended"
      # // FEE field values
      # // 1 - seller and winner still have to pay
      # // 2 - seller payed, winner still have to pay
      # // 3 - buyer payed, seller still have to pay
      # // 0 - seller and winnre payed
      $query = "UPDATE HB_winners
              SET fee=".$statusfee."
              WHERE auction=".$Auction['id'];
      $res = @mysql_query($query);
      # // ######################################################
      # // Send mail to the seller if zero balance in credit account
      include $include_path.'endauction_winner_nobalance.inc.php';
    }
    # // ######################################################
    # // check for CREDIT BALANCE FEES SETTINGS
    # // ######################################################
    if ($Seller['balance'] >= $FEE) {
      if (($finalfee == 1)) {
        # // Update seller's  balance
        $res = @mysql_query("UPDATE HB_users SET
          balance=balance-$FEE,reg_date=reg_date WHERE id=".$Seller['id']); 
        # // Update seller's account
        $TODAY = $NOWB;
        $DESCR = "<A HREF=item.php?id=".$Auction['id']." TARGET=_blank>$MSG_452</A>";
        $query = "INSERT INTO HB_accounts
             VALUES
             (NULL,
             ".$Seller['id'].",
             '$DESCR',
             '$TODAY',
             1,
             $FEE,
             ".$Seller['balance']."-$FEE,
             ".$Auction['id'].",'')";
        $res = mysql_query($query);
        if (!$res) print $query . "<BR>" . mysql_error();
        $ress = mysql_query("SELECT * FROM HB_winners WHERE auction=".$Auction['id']);
        $newfee = mysql_result($ress, 0, "fee");
        # // Update HB_winners table
        if ($newfee == 1 && ($SETTINGS['buyerfinalfee'] == 1)) {
          $NEWVALUE = 2;
        } else $NEWVALUE = 0;
        if ($newfee == 3) {
          $NEWVALUE = 0;
        }
        
        $query = "UPDATE HB_winners
            SET fee=$NEWVALUE
            WHERE auction=".$Auction['id']." 
            AND seller=".$Seller['id'];
        $finalfee = 0;
      }
    }
    if ($finalfee == 0) {
      # // ######################################################
      # // Send mail to the seller
      if($Seller['endemailmode']!='cum'){
        include $include_path.'endauction_winner.inc.php';
      }else{
        #// Save in the database to send later
        @mysql_query("INSERT INTO HB_pendingnotif VALUES (
                NULL,
                ".$Auction['id'].",
                ".$Seller['id'].",
                '$report_text',
                '".serialize($Auction)."',
                '".serialize($Seller)."',
                '".date("Ymd")."')");
      }
    }
  }
  # // ######################################################
  # // check for PAY FEES SETTINGS
  # // ######################################################
  if ($SETTINGS['feetype'] == "pay") {
    # // Set auction to "fee pending" status
    if ($atype != 3) {
      $query = "UPDATE HB_auctions
            SET closed='".$statusclosed."'
            WHERE id=".$Auction['id'];
      $res = @mysql_query($query);
    }
    # // Set the entry in the winners table as "suspended"
    # // FEE field values
    # // 1 - seller and winner still have to pay
    # // 2 - seller payed, winner still have to pay
    # // 3 - buyer payed, seller still have to pay
    # // 0 - seller and winnre payed
    $query = "UPDATE HB_winners
          SET fee=".$statusfee."
          WHERE auction=".$Auction['id'];
    $res = @mysql_query($query);
    # // ######################################################
    # // Send mail to the seller
    include $include_path.'endauction_winner_pay.inc.php';
  }
}
?>
