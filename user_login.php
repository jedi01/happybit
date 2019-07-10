<?

	include "./includes/config.inc.php";
	include $include_path."countries.inc.php";

	if ($_POST["action"] != "login") {
		include "header.php";
		include phpa_include("template_user_login_php.html");
		include "footer.php";
		exit;
	}
	$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
	$NOW = date("YmdHis",$TIME);
	$NOWB = date("Ymd",$TIME);

	if ($_POST["action"] == "login") {
		$query = "select id,email,name,accounttype,suspended from HB_users where nick='".addslashes($_POST["username"])."' and password='".md5($MD5_PREFIX.$_POST["password"])."' and (suspended=0 OR suspended =2)";
		$res = mysql_query($query);
  //print $query;
	   	if(mysql_num_rows($res) == 0) {
			$TPL_err=1;
			$TPL_errmsg = $ERR_038;
			include "header.php";
			include phpa_include("template_user_login_php.html");
			include "footer.php";
			exit;
		}

		$suspended=	mysql_result($res,0,suspended);
		if( $suspended == 0) {
			#// Redirect if necessary
			if(isset($_SESSION["REDIRECT_AFTER_LOGIN"])) {
				$_SESSION["HAPPYBID_LOGGED_IN"] = mysql_result($res,0,"id");
				$_SESSION["HAPPYBID_LOGGED_IN_USERNAME"] = $_POST["username"];
				$_SESSION["HAPPYBID_LOGGED_EMAIL"] = mysql_result($res,0,"email");
				$_SESSION["HAPPYBID_LOGGED_ACCOUNT"] = mysql_result($res,0,"accounttype");
				$_SESSION["HAPPYBID_LOGGED_NAME"] = mysql_result($res,0,"name");

				#// UPdate "last login" fields in users table
				@mysql_query("UPDATE HB_users SET lastlogin='".date("Y-m-d H:i:s",$TIME)."',
							reg_date=reg_date
							WHERE id=".$_SESSION["HAPPYBID_LOGGED_IN"]);
	
				#// Remember me option
				if($_POST['rememberme'] == 1) {
					$remember_key=md5(time());
					$query = "INSERT INTO HB_rememberme VALUES(".mysql_result($res,0,"id").",'".addslashes($remember_key)."')";
					if(!@mysql_query($query)){
						MySQLError($query);
						exit;
					}
					setcookie("HAPPYBID_RM_ID",$remember_key,time()+(3600*24*365));
				}

				$URL = str_replace('\r','',str_replace('\n','',$_SESSION["REDIRECT_AFTER_LOGIN"]));
				unset($_SESSION["REDIRECT_AFTER_LOGIN"]);
				#// ===========================================================
				#// Added by Gian for IP banning
				#// Store user IP address in the database
				#// ===========================================================
				$query = "SELECT id FROM HB_usersips where USER='".$_SESSION["HAPPYBID_LOGGED_IN"]."' AND ip='".$_SERVER["REMOTE_ADDR"]."'";
				$RR = mysql_query($query);
				if(!$RR) {
					MySQLError($query);
					exit;
				} elseif(mysql_num_rows($RR) == 0) {
					$query = "INSERT INTO HB_usersips VALUES(
							  NULL,
							  '".$_SESSION["HAPPYBID_LOGGED_IN"]."',
							  '".$_SERVER["REMOTE_ADDR"]."',
							  'after','accept')";
					$res___ = @mysql_query($query);
					if(!$res___) {
						MySQLError($query);
						exit;
					}
				}
				#// ===========================================================
				Header("Location: $URL");
				exit;
			} else {
				$_SESSION["HAPPYBID_LOGGED_IN"] = mysql_result($res,0,"id");
				$_SESSION["HAPPYBID_LOGGED_IN_USERNAME"] = $_POST["username"];
				$_SESSION["HAPPYBID_LOGGED_ACCOUNT"] = mysql_result($res,0,"accounttype");
				$_SESSION["HAPPYBID_LOGGED_EMAIL"] = mysql_result($res,0,"email");
				$_SESSION["HAPPYBID_LOGGED_NAME"] = mysql_result($res,0,"name");

				#// UPdate "last login" fields in users table
				@mysql_query("UPDATE HB_users SET lastlogin='".date("Y-m-d H:i:s",$TIME)."',
							reg_date=reg_date
							WHERE id=".$_SESSION["HAPPYBID_LOGGED_IN"]);
				
				#// Remember me option
				if($_POST['rememberme'] == 1) {
					$remember_key=md5(time());
					$query = "INSERT INTO HB_rememberme VALUES(".mysql_result($res,0,"id").",'".addslashes($remember_key)."')";
					if(!@mysql_query($query)){
						MySQLError($query);
						exit;
					}
					setcookie("HAPPYBID_RM_ID",$remember_key,time()+(3600*24*365));
				}
				
				#// ===========================================================
				#// Added by Gian for IP banning
				#// Store user IP address in the database
				#// ===========================================================
				$query = "SELECT id FROM HB_usersips where USER='".$_SESSION["HAPPYBID_LOGGED_IN"]."' AND ip='".$_SERVER["REMOTE_ADDR"]."'";
				$RR = mysql_query($query);
				if(!$RR) {
					MySQLError($query);
					exit;
				} elseif(mysql_num_rows($RR) == 0) {
					$query = "INSERT INTO HB_usersips VALUES(
							  NULL,
							  '".$_SESSION["HAPPYBID_LOGGED_IN"]."',
							  '".$_SERVER["REMOTE_ADDR"]."',
							  'after','accept')";
					$res___ = @mysql_query($query);
					if(!$res___) {
						MySQLError($query);
						exit;
					}
				}
				#// ===========================================================
				Header("Location: index.php");
				exit;
			}
		} elseif($suspended == 2) {
				$TPL_err = 1;
	       		$TPL_errmsg = $ERR_713;
	    		include "header.php";
				include phpa_include("template_user_login_php.html");
				include "footer.php";
				exit;
        }
	}
if ($_SERVER["REQUEST_METHOD"]=="POST" && $_POST["action"]=="update") {
  if ($_POST["TPL_email"] && $_POST["TPL_address"] && $_POST["TPL_city"] && $_POST["TPL_country"] && $_POST["TPL_zip"] && $_POST["TPL_phone"] && $_POST["TPL_nletter"]) {
     if (strlen($_POST["TPL_password"])<6 && strlen($_POST["TPL_password"]) > 0) {
				$TPL_err=1;
				$TPL_errmsg=$ERR_011;
			} else if ($TPL_password!=$TPL_repeat_password) {
				$TPL_err=1;
				$TPL_errmsg=$ERR_109;
			} else if (strlen($TPL_email)<5) {
				$TPL_err=1;
				$TPL_errmsg=$ERR_110;
			} else if (strlen($TPL_zip)<5)  {
				$TPL_err=1;
				$TPL_errmsg=$ERR_616;
			} else if (strlen($TPL_phone)<3)  {
				$TPL_err=1;
				$TPL_errmsg=$ERR_617;
			} else {
				$TPL_birthdate = substr($TPL_birthdate,6,4).
									  substr($TPL_birthdate,0,2).
									  substr($TPL_birthdate,3,2);

				$sql="UPDATE HB_users SET email=\"".			AddSlashes($TPL_email)
								 ."\", birthdate=\"".	AddSlashes($TPL_birthdate)
								 ."\", address=\"".		AddSlashes($TPL_address)
								 ."\", city=\"".			AddSlashes($TPL_city)
								 ."\", prov=\"".			AddSlashes($TPL_prov)
								 ."\", country=\"".		AddSlashes($TPL_country)
								 ."\", zip=\"".			AddSlashes($TPL_zip)
								 ."\", phone=\"".			AddSlashes($TPL_phone)
								 ."\", reg_date=reg_date,"
								  ."\", nletter=\"".			AddSlashes($TPL_nletter);

				if(strlen($TPL_password) > 0) {
					$sql .= 	"\", password=\"".		md5($MD5_PREFIX.AddSlashes($TPL_password));
				}

				$sql .= "\" WHERE id='".			AddSlashes($TPL_id_hidden)."'";
				$res=mysql_query ($sql);

				include "header.php";
				include phpa_include("template_updated.html");

			}
		} else {
			$TPL_err=1;
			$TPL_errmsg=$ERR_112;
		}
	}

	include "footer.php";
	$TPL_err=0;
	$TPL_errmsg="";
?>
