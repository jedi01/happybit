<?

include "../includes/config.inc.php";
include "loggedin.inc.php";
include "../includes/countries.inc.php";

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nav</title>
<style type="text/css">
body,td,th {
	font-family: Arial, Tahoma, Geneva, sans-serif;
	font-size: 16px;
	color: #999;
}
body {
	background-color: #EEEEEE;
	margin-left: 0px;
	margin-top: 12px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<center>
<div style="margin:0 auto; display:inline-block;">
<a href="http://happybid.co.uk" target="_blank" class="buttonadminnav">Website</a>
<div style="display: inline;float: left;margin-top: 12px;">--</div>
<a href="blist.php" target="content" class="buttonadminnav">Bid Feed</a>
<div style="display: inline;float: left;margin-top: 12px;">--</div>
<a href="listusers.php" target="content" class="buttonadminnav">Users</a>
<div style="display: inline;float: left;margin-top: 12px;">--</div>
<a href="sell.php" target="content" class="buttonadminnav">Add Auction</a>
<a href="listauctions.php" target="content" class="buttonadminnav">View Auctions</a>
<a href="listclosedauctions.php" target="content" class="buttonadminnav">Closed Auctions</a>
<a href="listsuspendedauctions.php" target="content" class="buttonadminnav">Suspended Auctions</a>
<div style="display: inline;float: left;margin-top: 12px;">--</div>
<a href="settings.php" target="content" class="buttonadminnav">Settings</a>
<a href="metatags.php" target="content" class="buttonadminnav">SEO</a>
<div style="display: inline;float: left;margin-top: 12px;">--</div>
<a href="http://happybid.co.uk/clickr/backend/login.php" target="content" class="buttonadminnav">Heatmaps</a>




</div>
</center>
</body>
</html>