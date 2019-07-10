<?

require("includes/config.inc.php");
include("fbconnect.php");
include "header.php";

mysql_query("INSERT INTO mike_test (id) VALUES ('$user_profile')");

include "footer.php";
?>