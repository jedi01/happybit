<?

	include "includes/config.inc.php";
	$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
	$NOW = date("YmdHis",$TIME);
	if($_POST['action'] && $_POST['username'] && $_POST['password'])
	{
		$query = "select id,name,email,accounttype from HB_users where 
					nick='".addslashes($_POST['username'])."' and password='".md5($MD5_PREFIX.$_POST["password"])."' and suspended=0";
		$res = mysql_query($query);
		//print $query;;
		if(mysql_num_rows($res) > 0)
		{
			$_SESSION["HAPPYBID_LOGGED_IN"] = mysql_result($res,0,"id");
			$_SESSION["HAPPYBID_LOGGED_EMAIL"] = mysql_result($res,0,"email");
			$_SESSION["HAPPYBID_LOGGED_NAME"] = mysql_result($res,0,"name");
			$_SESSION["HAPPYBID_LOGGED_ACCOUNT"] = mysql_result($res,0,"accounttype");
			$_SESSION["HAPPYBID_LOGGED_IN_USERNAME"] = $_POST["username"];
			
			#// Update "last login" fields in users table
			@mysql_query("UPDATE HB_users SET lastlogin='".date("Y-m-d H:i:s",$TIME)."',
						reg_date=reg_date
						WHERE id=".$_SESSION["HAPPYBID_LOGGED_IN"]);
			
			#// Remember me option
			if($_POST['rememberme'] == 1) {
				$remember_key=md5(time());
				$query = "INSERT INTO HB_rememberme VALUES(".intval(mysql_result($res,0,"id")).",'".addslashes($remember_key)."')";
				if(!@mysql_query($query)){
					MySQLError($query);
					exit;
				}
				setcookie("HAPPYBID_RM_ID",$remember_key,time()+(3600*24*365));
			}
		}else{
			$_SESSION['loginerror'] = $ERR_038;
		}
	}else{
		$_SESSION['loginerror'] = $ERR_038;
	}

	#// ===========================================================
	#// Added by Gian for IP banning
	#// Store user IP address in the database
	#// ===========================================================
	$query = "SELECT id FROM HB_usersips where USER='".$_SESSION["HAPPYBID_LOGGED_IN"]."' AND ip='".$_SERVER["REMOTE_ADDR"]."'";
	//print $query;
	$RR = mysql_query($query);
	if(!$RR)
	{
		MySQLError($query);
		exit;
	}
	elseif(mysql_num_rows($RR) == 0)
	{
		$query = "INSERT INTO HB_usersips VALUES(
				  NULL,
				  '".$_SESSION["HAPPYBID_LOGGED_IN"]."',
				  '".$_SERVER["REMOTE_ADDR"]."',
				  'after','accept')";
		$res___ = @mysql_query($query);
		if(!$res___)
		{
			MySQLError($query);
			exit;
		}
	}
	#// ===========================================================



	//Header("Location: $_SERVER['HTTP_REFERER']");
	Header("Location: $Https[httpsurl]"."index.php");
	exit;
?>
