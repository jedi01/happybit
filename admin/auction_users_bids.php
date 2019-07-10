<?

include "../includes/config.inc.php";
include "loggedin.inc.php";
include "../includes/countries.inc.php";

$auction_id = isset($_REQUEST['aid']) ? $_REQUEST['aid'] : "";
$user_id = isset($_REQUEST['uid']) ? $_REQUEST['uid'] : "";

?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<STYLE TYPE="text/css">
body {
scrollbar-face-color: #aaaaaa;
scrollbar-shadow-color: #666666;
scrollbar-highlight-color: #aaaaaa;
scrollbar-3dlight-color: #dddddd;
scrollbar-darkshadow-color: #444444;
scrollbar-track-color: #cccccc;
scrollbar-arrow-color: #ffffff;
}</STYLE>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>
<?  

/************ SHOW BID HISTORY *******************/
$TPL_auctions_list_value = "";
// Show selected user bids

if($auction_id != ""){
	
	// find won bid
	$sql = "SELECT bid, bidder, COUNT(bid) AS bid_count FROM HB_bids WHERE auction=".intval($auction_id)." GROUP BY bid HAVING bid_count = 1 ORDER BY bid ASC ";
	$result_check_winner = mysql_query($sql);
	if ($row = mysql_fetch_array($result_check_winner)){
		$won_bid = $row['bid'];
	}else{
		$won_bid = "";
	}
	
	// find other unique bids
	$unique = array();	
	while ($row = mysql_fetch_array($result_check_winner)){
		$unique[] = $row['bid'];
	}
			  		
	// prepare list of bids
	$sql = "SELECT
			b.id, b.bidder, b.bid, b.auction, b.bidwhen,u.nick,u.email
		FROM
			HB_bids b
		INNER JOIN 
			HB_users u ON b.bidder=u.id
		WHERE
			b.auction = '".intval($auction_id)."'
		ORDER BY
			b.bid ASC";
	
	$result = mysql_query($sql);
	$idcheck= "";
	if ($result) {
		$tplv = "";
		$bgColor = "#EBEBEB";
		$bgColorWon = "#61DA0F";
		$bgColorUnique = "#FF8A00";
		$bgColorNone = "#cd0000";
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
//			$bidwhen_date = date("Ymd h:i:s A",$row["bidwhen"]);
			
			if($bgColor == "#EBEBEB") {
				$bgColor = "#FFFFFF";
			} else {
				$bgColor = "#EBEBEB";
			}

			$tplv .= "<tr VALIGN=MIDDLE BGCOLOR=\"$bgColor\">"; 			
			if($won_bid == $bid) {
				$tplv .= "<td align='center' BGCOLOR='".$bgColorWon."'><font color='#ffffff'><b>".$bid."</b></font></td>";	
			}elseif(in_array($bid,$unique)){
				$tplv .= "<td align='center' BGCOLOR='".$bgColorUnique."'><font color='#ffffff'><b style='color:#000000'>".$bid."</b></td>";	
			}else{
				$tplv .= "<td align='center' BGCOLOR='".$bgColorNone."'><font color='#ffffff'><b>".$bid."</b></td>";	
			}
			$tplv .= "<td align='center'>".$row['nick']."</td>"; 
			$tplv .= "<td align='center'>".$row['email']."</td>"; 
			$tplv .= "<td align='center'>".$bidwhen_date."</td>";
			$tplv .= "</tr>";
		}
		$TPL_auctions_list_value = $tplv;	
	} else {
		$auctions_count = 0;
		$TPL_auctions_list_value = "<tr ALIGN=CENTER><td COLSPAN=6>&nbsp;</td></tr>";  
	}	
}
/************ EOF: SHOW BID HISTORY *******************/
?>
<?
$query = "SELECT * FROM HB_auctions WHERE id=" . intval($auction_id);
$res = mysql_query($query);
if (!$res)
{
	print '' . $query . "<BR>" . mysql_error();
	exit();
}
 else 
{
	if (mysql_num_rows($res) == 0)
	{
		print $MSG__0165;
	}
	 else 
	{
		$AUCTION = mysql_fetch_array($res);
	}
}
?>
<div style="font-size:18px; font-weight:bold; margin-top:12px; text-align:center; display:inline-block; width:700px;">
<?php
echo stripslashes($AUCTION["title"]);
?>
</div>
<div style="font-size:16px; font-weight:bold; margin-top:4px; margin-bottom:8px; text-align:center; display:inline-block; width:700px;">
<script>
    document.write('<a href="' + document.referrer + '" class="buttonadminblue" style="float:none;">Go Back</a>');
</script>
<a href="/item.php?id=<?php echo $_GET["aid"]; ?>" target="_blank" class="buttonadminblue" style="float:none;">View Auction</a>
</div>
<CENTER>
    <TABLE WIDTH=80% HEIGHT=20 BORDER=0 CELLPADDING=0 CELLSPACING=0 style="line-height:20px;text-align:center; font-size:12px;">
        <TR valign=top>
          <TD colspan=6 Height=20 >
            <div style="background-color:#61DA0F; color:#FFFFFF;"><strong>Lowest Unique Bid</strong></div>
            <div style="background-color:#FF8A00; color:#000000;"><strong>Unique But Not Lowest</strong></div>
            <div style="background-color:#cd0000; color:#FFFFFF;"><strong>Not Unique</strong></div>
          </TD>
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