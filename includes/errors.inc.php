<?#//v.3.0.0
if(!defined('INCLUDED')) exit("Access denied");

#// Errors handling functions
	
if(!function_exists(MySQLError))
{
	Function MySQLError($Q)
	{
		global 	$SESSION_NAME,
				$SESSION_ERROR,
				$ERR_0001;
		
		$SESSION_ERROR = $ERR_001."<br>".$Q."<br>".mysql_error();		
		$_SESSION["SESSION_ERROR"]=$SESSION_ERROR;
		print "<SCRIPT LANGUAGE=Javascript>document.location.href='../error.php'</SCRIPT>";
		
		return;
	}
}
?>
