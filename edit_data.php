<?

include "./includes/config.inc.php";
include $include_path."countries.inc.php";

#// If user is not logged in redirect to login page
if(!isset($_SESSION["HAPPYBID_LOGGED_IN"])) {
	Header("Location: user_login.php");
	exit;
}

if($_POST['action'] == "update") {
	#// Check data
	if ($_POST['TPL_email']) {
		if (strlen($_POST['TPL_password'])<6 && strlen($_POST['TPL_password']) > 0) {
			$TPL_err=1;
			$TPL_errmsg=$ERR_011;
		} else if ($_POST['TPL_password']!=$_POST['TPL_repeat_password']) {
			$TPL_err=1;
			$TPL_errmsg=$ERR_109;
		} else if (strlen($_POST['TPL_email'])<5) {
			$TPL_err=1;
			$TPL_errmsg=$ERR_110;
		} elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$",$_POST['TPL_email'])) {
			$TPL_err = 1;
			$TPL_errmsg = $ERR_008;
		} elseif (strlen($_POST['TPL_zip'])<4) {
			$TPL_err=1;
			$TPL_errmsg=$ERR_616;
		} else {
			if($SETTINGS[datesformat] == "USA") {
				$_POST['TPL_birthdate'] = substr($_POST['TPL_birthdate'],6,4).
				substr($_POST['TPL_birthdate'],0,2).
				substr($_POST['TPL_birthdate'],3,2);
			} else {
				$_POST['TPL_birthdate'] = substr($_POST['TPL_birthdate'],6,4).
				substr($_POST['TPL_birthdate'],3,2).
				substr($_POST['TPL_birthdate'],0,2);
			}
			$sql="UPDATE HB_users SET email=\"".	AddSlashes($_POST['TPL_email'])
			."\", birthdate=\"".			AddSlashes($_POST['TPL_birthdate'])
			."\", phone=\"".			AddSlashes($_POST['TPL_phone'])
			."\", address=\"".				AddSlashes($_POST['TPL_address'])
			."\", city=\"".				AddSlashes($_POST['TPL_city'])
			."\", prov=\"".				AddSlashes($_POST['TPL_prov'])
			."\", country=\"".				AddSlashes($_POST['TPL_country'])
			."\", zip=\"".					AddSlashes($_POST['TPL_zip'])
			."\", reg_date=reg_date"
			." , nletter=\"".			AddSlashes($_POST['TPL_nletter']);
			
			if(strlen($_POST['TPL_password']) > 0) {
				$sql .= 	"\", password=\"".		md5($MD5_PREFIX.AddSlashes($_POST['TPL_password']));
			}
			
			$sql .= "\" WHERE nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
			$res=mysql_query ($sql);
			

			//$query = "select * from HB_users where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
			//$result = @mysql_query($query);
			//if(!$result) {
			//	MySQLError($query);
			//	exit;
			//} else {
			//	$USER = mysql_fetch_array($result);
			//	$TPL_nick 		= $USER['nick'];
			//	$TPL_name 		= $USER['name'];
			//	$TPL_zip 		= $USER['zip'];
			//	$TPL_email 		= $USER['email'];
			//	$TPL_address 	= $USER['address'];
			//	$TPL_country 	= $USER['country'];
			//	$TPL_city 		= $USER['city'];
			//	$TPL_prov 		= $USER['prov'];
			//	$TPL_phone 		= $USER['phone'];
			//	$TPL_nletter 	= $USER['nletter'];
			//	if($SETTINGS[datesformat] == "USA") {
			//		$TPL_birthdate	=  substr($USER['birthdate'],4,2)."/".
			//		substr($USER['birthdate'],6,2)."/".
			//		substr($USER['birthdate'],0,4);
			//	} else {
			//		$TPL_birthdate	=  substr($USER['birthdate'],6,2)."/".
			//		substr($USER['birthdate'],4,2)."/".
			//		substr($USER['birthdate'],0,4);
			//	}
			//	
			//	#// Build countries <SELECT>
			//	$country="";
			//	while (list ($code, $name) = each ($countries)) {
			//		$country .= "<option value=\"$name\"";
			//		if ($name == $TPL_country) {
			//			$country .= " SELECTED";
			//		}
			//		$country .= ">$name</option>\n";
			//	}
			//}
			//
			#// Redirect user to his/her admin page
			$TMP_MSG = $MSG_183;
			$_SESSION["TMP_MSG"]=$TMP_MSG;
			
			/*Header("Location: user_menu.php");
			exit;
			
			include "header.php";
			include "templates/template_updated.html";
			*/
			//include "header.php";
			//include phpa_include("template_change_details_php.html");
		}
	} else {
		$TPL_err=1;
		$TPL_errmsg=$ERR_112;
	}
} elseif(($_POST['action'] != "update" || $TPL_errmsg !=1)) {
	//#// Retrieve user's data
	//$query = "select * from HB_users where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
	//$result = @mysql_query($query);
	//if(!$result) {
	//	MySQLError($query);
	//	exit;
	//} else {
	//	$USER = mysql_fetch_array($result);
	//	$TPL_nick 		= $USER['nick'];
	//	$TPL_name 		= $USER['name'];
	//	$TPL_zip 		= $USER['zip'];
	//	$TPL_email 		= $USER['email'];
	//	$TPL_address 	= $USER['address'];
	//	$TPL_country 	= $USER['country'];
	//	$TPL_city 		= $USER['city'];
	//	$TPL_prov 		= $USER['prov'];
	//	$TPL_phone 		= $USER['phone'];
	//	$TPL_nletter 	= $USER['nletter'];
	//	if($SETTINGS[datesformat] == "USA") {
	//		$TPL_birthdate	=  substr($USER['birthdate'],4,2)."/".
	//		substr($USER['birthdate'],6,2)."/".
	//		substr($USER['birthdate'],0,4);
	//	} else {
	//		$TPL_birthdate	=  substr($USER['birthdate'],6,2)."/".
	//		substr($USER['birthdate'],4,2)."/".
	//		substr($USER['birthdate'],0,4);
	//	}
		
		//#// Build countries <SELECT>
		//$country="";
		//while (list ($code, $name) = each ($countries)) {
		//	$country .= "<option value=\"$name\"";
		//	if ($name == $TPL_country) {
		//		$country .= " SELECTED";
		//	}
		//	$country .= ">$name</option>\n";
		//}
	//}
	//echo "111 ";
	//include "header.php";
	//include phpa_include("template_change_details_php.html");
}

if($TPL_err==1) {	
	//include "header.php";
	//include phpa_include("template_change_details_php.html");
}


	#// Retrieve user's data
	$query = "select * from HB_users where nick='".$_SESSION['HAPPYBID_LOGGED_IN_USERNAME']."'";
	$result = @mysql_query($query);
	if(!$result) {
		MySQLError($query);
		exit;
	} else {
		$USER = mysql_fetch_array($result);
		$TPL_nick 		= $USER['nick'];
		$TPL_name 		= $USER['name'];
		$TPL_zip 		= $USER['zip'];
		$TPL_email 		= $USER['email'];
		$TPL_address 	= $USER['address'];
		$TPL_country 	= $USER['country'];
		$TPL_city 		= $USER['city'];
		$TPL_prov 		= $USER['prov'];;
		$TPL_nletter 	= $USER['nletter'];
		$TPL_phone 		= $USER['phone'];
		if($SETTINGS[datesformat] == "USA") {
			$TPL_birthdate	=  substr($USER['birthdate'],4,2)."/".
			substr($USER['birthdate'],6,2)."/".
			substr($USER['birthdate'],0,4);
		} else {
			$TPL_birthdate	=  substr($USER['birthdate'],6,2)."/".
			substr($USER['birthdate'],4,2)."/".
			substr($USER['birthdate'],0,4);
		}
		
		#// Build countries <SELECT>
		$country="";
		while (list ($code, $name) = each ($countries)) {
			$country .= "<option value=\"$name\"";
			if ($name == $TPL_country) {
				$country .= " SELECTED";
			}
			$country .= ">$name</option>\n";
		}
	}
	
	include "header.php";
	include phpa_include("template_change_details_php.html");
	
	include "footer.php";

	$TPL_err=0;
	$TPL_errmsg="";
?>
