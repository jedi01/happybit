<?

require('./includes/config.inc.php');

#// Retrieve final value fees
#// If user is not logged in redirect to login page
if(!isset($_SESSION["HAPPYBID_LOGGED_IN"]))
{
	Header("Location: user_login.php");
	exit;
}

#// Get closed auctions with winners
$query = "SELECT			  
			w.auction,
			w.winner,
			w.bid			
		  FROM
			HB_winners w, HB_auctions a
		  WHERE
			w.auction=a.id AND
			   (a.closed='1' OR a.closed='-1') AND a.suspended=0 AND
			  w.winner='$_SESSION[HAPPYBID_LOGGED_IN]'
		  ORDER BY w.closingdate DESC";
$res = @mysql_query($query);
if(!$res)
{
	MySQLError($query);
	exit;
}
else
{
	while($row = mysql_fetch_array($res))
	{
		$query = "SELECT title,ends FROM HB_auctions WHERE id='$row[auction]'";
		$r = @mysql_query($query);
		if(!$r)
		{
			MySQLError($query);
			exit;
		}
		$AUCTIONS[$row[auction]] = stripslashes(mysql_result($r,0,"title"));
		$AUCTIONS_ENDS[$row[auction]] = stripslashes(mysql_result($r,0,"ends"));
		
		$BID[$row[auction]] = $row['bid'];
	}
}

require("header.php");
include phpa_include("template_buying_php.html");
include "./footer.php";

?>