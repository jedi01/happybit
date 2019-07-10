<?

include "../includes/config.inc.php";
include "loggedin.inc.php";
include "../includes/countries.inc.php";

?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>
<?  

/************ SHOW BID HISTORY *******************/
$TPL_auctions_list_value = "";

			  		
	// prepare list of bids
	$sql = "SELECT
			b.id, b.bidder, b.bid, b.auction, b.bidwhen,u.nick,u.email
		FROM
			HB_bids b
		INNER JOIN 
			HB_users u ON b.bidder=u.id
		ORDER BY
			b.id DESC";
	
	$result = mysql_query($sql);
	$idcheck= "";
	if ($result) {
		$tplv = "";
		$bgColor = "#EBEBEB";
		$bgColorWon = "#61DA0F";
		$bgColorUnique = "#FF8A00";
		$bgColorNone = "";
		while ($row=mysql_fetch_array($result)) {
	
			$bid = $row['bid'];
			//$bidwhen_date = date("Y-m-d h:i:s");
			$hour = substr($row["bidwhen"],8,2)+$SETTINGS['timecorrection'];
			
			$h_time = mktime($hour,date("i"),date("s"),date("m"), date("d"),date("Y"));
			$ampm = date("A",$h_time);
			
			if($hour>24) $hour-=24;
			
			if($hour>12)
			{
				$hour-=12;
			}
			
			if(strlen($hour)==1)$hour = "0".$hour;
				
						
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
							substr($row["bidwhen"],12,2).
							" ".
							$ampm;
			$stamp = substr($row["bidwhen"],0,14);
			
$date = "$bidwhen_date";
$agotime = nicetime($stamp); // 2 days ago
							
//			$bidwhen_date = date("Ymd h:i:s A",$row["bidwhen"]);
			
			if($bgColor == "#EBEBEB") {
				$bgColor = "#FFFFFF";
			} else {
				$bgColor = "#EBEBEB";
			}

			$tplv .= "<tr VALIGN=MIDDLE BGCOLOR=\"$bgColor\">"; 			
			if($won_bid == $bid) {
				$tplv .= "<td align='center' BGCOLOR='".$bgColorWon."'><font color='#000000'>&pound;".$bid."</font></td>";	
			}elseif(in_array($bid,$unique)){
				$tplv .= "<td align='center' BGCOLOR='".$bgColorUnique."'><font color='#000000'>&pound;".$bid."</td>";	
			}else{
				$tplv .= "<td align='center' BGCOLOR='".$bgColorNone."'><font color='#000000'>&pound;".$bid."</td>";	
			}
			$tplv .= "<td align='center'>".$row['nick']."</td>"; 
			$tplv .= "<td align='center'>".$row['email']."</td>"; 
			$tplv .= "<td align='center'>".$row['auction']." - <a href='auction_users_bids.php?aid=".$row['auction']."'>History</a> - <a href='/item.php?id=".$row['auction']."' target='_blank'>View</a></td>"; 
			$tplv .= "<td align='center'>".$bidwhen_date."</td>"; 
			$tplv .= "<td align='center'>".$agotime."</td>"; 
			$tplv .= "</tr>";
		}
		$TPL_auctions_list_value = $tplv;	
	} else {
		$auctions_count = 0;
		$TPL_auctions_list_value = "<tr ALIGN=CENTER><td COLSPAN=6>&nbsp;</td></tr>";  
	}	
/************ EOF: SHOW BID HISTORY *******************/
?>
<?php
function nicetime($date)
{
    if(empty($date)) {
        return "No date provided";
    }
    
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", 

"decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
    
    $now             = time();
    $unix_date         = strtotime($date);
    
       // check validity of date
    if(empty($unix_date)) {    
        return "Bad date";
    }

    // is it future date or past date
    if($now > $unix_date) {    
        $difference     = $now - $unix_date;
        $tense         = "ago";
        
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
    
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
    
    $difference = round($difference);
    
    if($difference != 1) {
        $periods[$j].= "s";
    }
    
    return "$difference $periods[$j] {$tense}";
}

?>
<div style="text-align: right;width: 1170px;margin-top: 20px;font-weight: bold;margin-bottom: -50px;">
Current Time: <?php echo date("d/m/y - H:i:s", time()); ?>
</div>
<div style="text-align:right; width:1170px; margin-top:60px; margin-bottom:-30px;">
</div>
    <TABLE WIDTH=80% HEIGHT=20 BORDER=0 CELLPADDING=0 CELLSPACING=0 style="line-height:20px;text-align:center; font-size:12px;">
        <TR valign=top>
            <TD colspan=6 Height=20 ><?php $auction ?></TD>
        </TR>
        <TR valign=top>
            <TD colspan=6 Height=10 >&nbsp;</TD>
        </TR>
        <TR valign=top>
            <TD colspan=6>
                <TABLE WIDTH=100% BORDER=1 style="border-collapse:collapse; font-size:12px;" CELLPADDING=4 CELLSPACING=0>
                    <TR>
                        <TH align=CENTER style="font-size:14px;">Bid</TH>
						<TH align=CENTER style="font-size:14px;">User</TH>
                        <TH align=CENTER style="font-size:14px;">Email</TH>
                        <TH align=CENTER style="font-size:14px;">Auction</TH>
                        <TH align=CENTER style="font-size:14px;">Date/Time</TH>
                    </TR>
                    <?
                    if($TPL_auctions_list_value != ""){ 
                        print $TPL_auctions_list_value; 
                    }else{
                    ?>
                    <TR>
                        <TD colspan=2>No bids found</TD>
                    </TR>
                    <? } ?>
                </TABLE>
            </TD>
        </TR>
    </TABLE>
<BR><BR><BR>
</center>
</BODY>
</HTML>