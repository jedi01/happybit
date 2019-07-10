<?

require('./includes/config.inc.php');

#// If the user is not logged in -> refirect
if(empty($_SESSION['HAPPYBID_LOGGED_IN'])) {
	Header("Location: user_login.php");
	exit;
}

#// Check if About me is enabled
if($SETTINGS['aboutme'] == 'n') {
	Header("Location: user_menu.php");
}

if(!empty($_POST['Preview']) && basename($_SERVER['HTTP_REFERER']) != basename($_SERVER['PHPSELF'])) {

	#// Check if the user already have a picture loaded to avoid a flow error
	$query = "SELECT picture FROM HB_aboutmeusers WHERE user=".intval($_SESSION['HAPPYBID_LOGGED_IN']);
	$res = @mysql_query($query);
	if(!$res) {
		MySQLError($query);
		exit;
	} elseif(@mysql_num_rows($res) > 0) {
		$ABOUTME = mysql_fetch_array($res);
		$_SESSION['picture'] = $ABOUTME['picture'];
	}

	#// Data check
	if(empty($_POST['template'])) {
		$ERR = $MSG__0142;
	} elseif(empty($_POST['pagetitle']) || empty($_POST['welcome']) || empty($_POST['welcomemsg'])) {
		$ERR = $ERR_047;
	} elseif(!is_numeric($_POST['auctions']) && !empty($_POST['auctions'])) {
		$ERR = $MSG__0144;
	} elseif(!eregi("jpg|jpeg|gif|png",$_FILES['picture']['name']) && !$_SESSION['picture']){
		$ERR = $ERR_710;
	} else {
		#// Handle image
		if(!empty($_FILES['picture']['tmp_name']) && $_FILES['picture']['tmp_name'] != 'none') {
			#// Create irectory if it does not exists
			if(!file_exists($uploaded_path."aboutmepictures")) {
				umask();
				mkdir($uploaded_path."aboutmepictures", 0777);
			}
			if(!file_exists($uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN'])) {
				umask();
				mkdir($uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN'], 0777);
			}
			move_uploaded_file($_FILES['picture']['tmp_name'],$uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/_".$_FILES['picture']['name']);
			chmod($uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/_".$_FILES['picture']['name'],0666);
			$PICUREUPLOADED = $_FILES['picture']['name'];
		} elseif(empty($_SESSION['picture'])) {
			$PICUREUPLOADED = '';
		} else {
			$PICUREUPLOADED = htmlspecialchars($_SESSION['picture']);
		}
		
		$_SESSION['pagetitle'] 		= htmlspecialchars($_POST['pagetitle']);
		$_SESSION['welcome'] 		= htmlspecialchars($_POST['welcome']);
		$_SESSION['welcomemsg'] 	= htmlspecialchars($_POST['welcomemsg']);
		$_SESSION['paragraph'] 		= htmlspecialchars($_POST['paragraph']);
		$_SESSION['paragraphmsg'] 	= htmlspecialchars($_POST['paragraphmsg']);
		$_SESSION['picture'] 		= htmlspecialchars($PICUREUPLOADED);
		$_SESSION['auctions'] 		= intval($_POST['auctions']);
		$_SESSION['template'] 		= intval($_POST['template']);
		
		#// Redirect to to preview page
		Header("Location: previewaboutme.php");
		exit;
	}
} elseif(!empty($_POST['Publish']) && basename($_SERVER['HTTP_REFERER']) != basename($_SERVER['PHPSELF'])) {
	#// Data check
	if(empty($_POST['template'])) {
		$ERR = $MSG__0142;
	} elseif(empty($_POST['pagetitle']) ||	empty($_POST['welcome']) ||	empty($_POST['welcomemsg'])) {
		$ERR = $ERR_047;
	} elseif(!is_numeric($_POST['auctions']) && !empty($_POST['auctions'])) {
		$ERR = $MSG__0144;
	} else {
		#// Handle image (if any)
		if(!empty($_FILES['picture']['tmp_name']) && $_FILES['picture']['tmp_name'] != 'none') {
			#// Create irectory if it does not exists
			if(!file_exists($uploaded_path."aboutmepictures")) {
				umask();
				mkdir($uploaded_path."aboutmepictures", 0777);
			}
			if(!file_exists($uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN'])) {
				umask();
				mkdir($uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN'], 0777);
			}
			move_uploaded_file($_FILES['picture']['tmp_name'],$uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/".$_FILES['picture']['name']);
			chmod($uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/".$_FILES['picture']['name'],0666);
			$PICUREUPLOADED = $_FILES['picture']['name'];
		} elseif(!empty($_SESSION['picture'])) {
			copy($uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/_".$_SESSION['picture'],
			$uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/".substr($_SESSION['picture'],0,strlen($_SESSION['picture'])));
			$PICUREUPLOADED = substr($_SESSION['picture'],0,strlen($_SESSION['picture']));
			
			#// Remove temp picture
			unlink($uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/_".$_SESSION['picture']);
		} elseif(empty($_SESSION['picture'])) {
			$PICUREUPLOADED = '';
		} else {
			$PICUREUPLOADED = $_SESSION['picture'];
		}
		
		#// Manage other data
		$query = "UPDATE HB_aboutmeusers  SET
					  pagetitle='".addslashes($_POST['pagetitle'])."',
					  welcome='".addslashes($_POST['welcome'])."',
					  welcomemsg='".addslashes($_POST['welcomemsg'])."',
					  paragraph='".addslashes($_POST['paragraph'])."',
					  paragraphmsg='".addslashes($_POST['paragraphmsg'])."',
					  auctions=".intval($_POST['auctions']).",
					  picture='".addslashes($PICUREUPLOADED)."',
					  template=".intval($_POST['template'])."
					  WHERE user=".intval($_SESSION['HAPPYBID_LOGGED_IN']);
		$res = @mysql_query($query);
		if(!$res) {
			MySQLError($query);
			exit;
		}
		
		#// Redirect
		Header("Location: user_menu.php");
		exit;
	}
} elseif(!empty($_POST['Delete']) && basename($_SERVER['HTTP_REFERER']) != basename($_SERVER['PHPSELF'])) {
	#// Data check
	#// Handle image (if any)
	if(!empty($_SESSION['picture'])) {
		@unlink($uploaded_path."aboutmepictures/".intval($_SESSION['HAPPYBID_LOGGED_IN'])."/".substr($_SESSION['picture'],0,strlen($_SESSION['picture'])));
		#// Remove temp picture if then
		@unlink($uploaded_path."aboutmepictures/".intval($_SESSION['HAPPYBID_LOGGED_IN'])."/_".$_SESSION['picture']);
	} 	
	#// Manage other data
	$query = "DELETE FROM HB_aboutmeusers WHERE user=".intval($_SESSION['HAPPYBID_LOGGED_IN']);
	$res = @mysql_query($query);
	if(!$res) {
		MySQLError($query);
		exit;
	}
	
	#// Redirect
	Header("Location: user_menu.php");
	exit;
} elseif(isset($_SESSION['template'])) {
	$ABOUTME = $_SESSION;
} else {
	#// Check if the user already have a About me page
	$query = "SELECT * FROM HB_aboutmeusers WHERE user=".intval($_SESSION['HAPPYBID_LOGGED_IN']);
	$res = @mysql_query($query);
	if(!$res) {
		MySQLError($query);
		exit;
	} elseif(@mysql_num_rows($res) > 0) {
		$ABOUTME = mysql_fetch_array($res);
		$_SESSION['picture'] = $ABOUTME['picture'];
		#// Create a tmp image for preview
		@copy($uploaded_path."aboutmepictures/".intval($_SESSION['HAPPYBID_LOGGED_IN'])."/".htmlspecialchars($_SESSION['picture']),$uploaded_path."aboutmepictures/".intval($_SESSION['HAPPYBID_LOGGED_IN'])."/_".htmlspecialchars($_SESSION['picture']));
	}
}

#// Retrieve templates from the database
$query = "SELECT * FROM HB_aboutmetemplates";
$res_ = @mysql_query($query);
if(!$res_) {
	MySQLError($query);
	exit;
} elseif(@mysql_num_rows($res_) > 0) {
	while($row = mysql_fetch_array($res_)) {
		$TEMPLATE[$row['id']] = $row;
	}
}

include "header.php";
include phpa_include("template_editaboutme_php.html");
include "footer.php";
?>
