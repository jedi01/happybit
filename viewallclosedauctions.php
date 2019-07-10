<?
    // Connect to sql server & inizialize configuration variables
    require('./includes/config.inc.php');
    require("header.php");


	$query = "SELECT
            a.title, a.id, a.pict_url,
            w.bid, w.winner, IF(w.closingdate IS NULL,a.ends,w.closingdate) AS closingdate, w.bid,
            u.nick
        FROM HB_auctions a
            LEFT OUTER JOIN HB_winners w ON a.id = w.auction
            LEFT OUTER JOIN HB_users u ON w.winner = u.id
        WHERE
            (auction_type = '1' AND closed = '1') OR
            ((auction_type = '2' OR auction_type = '3') AND closed = '2')            
        ORDER BY closingdate DESC limit 0, 100";
	    

	$res = mysql_query($query);
	if(!$res)
	{
		MySQLError($query);
		exit;
	}

	$TPL_closed_auctions_list = "<table width='100%' border='0' align='center' style='margin-top:8px;'>";
    $TPL_closed_auctions_list .= "<tr class='closedHP'>";
	
    $TPL_closed_auctions_list .= "<td ALIGN='center' class='reglabel' style='margin:none;'><b>PICTURE</b></td>";
    $TPL_closed_auctions_list .= "<td ALIGN='center' class='reglabel' style='margin:none;'><b>ITEM NAME</b></td>";
    $TPL_closed_auctions_list .= "<td ALIGN='center' class='reglabel' style='margin:none;'><b>END DATE</b></td>";
    $TPL_closed_auctions_list .= "<td ALIGN='center' class='reglabel' style='margin:none;'><b>LOWEST UNIQUE BID</b></td>";
    $TPL_closed_auctions_list .= "<td ALIGN='center' class='reglabel' style='margin:none;'><b>WINNER</b></td>";
    $TPL_closed_auctions_list .= "</tr>";
    
	while($row = mysql_fetch_array($res)) {
		$title = $row['title'];
        $closed_date = $row['closingdate'];
		$winner = ($row['winner'] != "") ? " Winner: ".$row['nick'] : "";
		$bid = number_format($row['bid'], 2);

		$F_date = FormatDate($closed_date);


        $TPL_closed_auctions_list .= "<tr><td colspan='5' nowrap height='4px'><td></tr><tr valign='centre'>";
        $TPL_closed_auctions_list .= "<td align='center'><a href=\"item.php?id=".$row['id']."\"  title='".$row['title']."' ><img alt='".$row['title']."' border='0' width='140px' style='border:1px solid #CCCCCC;' src='".$SETTINGS['siteurl']."uploaded/".$row["pict_url"]."' alt ='' /></a></td>";
 $TPL_closed_auctions_list .= "<td align='center'><a href=\"item.php?id=".$row['id']."\">".$title."</a></td>";
        $TPL_closed_auctions_list .= "<td align='center'>".$F_date."</td>";
        $TPL_closed_auctions_list .= "<td align='center'><font style='color:#FF00DE'><b>&pound;".$bid."</b></font></td>";
        $TPL_closed_auctions_list .= "<td align='center'><font style='color:#777777'><b>".$row['nick']."</b></font></td>";	
        $TPL_closed_auctions_list .= "</tr><tr><td colspan='5' nowrap height='4px'><td></tr><tr><td colspan='5' nowrap height='1px' style='background-color:#eeeeee;'><td></tr>";
        
	}
	$TPL_closed_auctions_list .= "</table>";

?>
<div class="content" id='main_content' style="font-size:20px;">
<div class="headerBar">
<? print $tlt_font.$MSG_204; ?>
</div>
<div>
<? print $TPL_closed_auctions_list; ?>
</div>
</div>
<?
	include phpa_include("template_user_menu_footer.html");
?>