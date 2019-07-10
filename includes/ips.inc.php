<?
if(!defined('INCLUDED')) exit("Access denied");

	#// Check if the current IP address is present in the database and if yes,
	#// Determine which action to take.
	$_X = mysql_num_rows(mysql_query("SELECT id FROM HB_usersips WHERE ip='".$_SERVER["REMOTE_ADDR"]."' AND action='deny'"));
	if($_X > 0 && !strstr($_SERVER["PHP_SELF"],"admin/"))
	{
		Header("Location: iperror.php");
		exit;
	}


?>
