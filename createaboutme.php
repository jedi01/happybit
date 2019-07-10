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

if(!empty($_POST['Preview'])) {
	#// Data check
	if(empty($_POST['template'])) {
		$ERR = $MSG__0142;
	} elseif(empty($_POST['pagetitle']) ||
	empty($_POST['welcome']) ||
	empty($_POST['welcomemsg'])) {
		$ERR = $ERR_047;
	} elseif(!is_numeric($_POST['auctions']) && !empty($_POST['auctions'])) {
		$ERR = $MSG__0144;
	}elseif(!eregi("jpg|jpeg|gif|png",$_FILES['picture']['name'])){
		$ERR = $ERR_710;
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
			move_uploaded_file($_FILES['picture']['tmp_name'],$uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/_".$_FILES['picture']['name']);
			chmod($uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/_".$_FILES['picture']['name'],0666);
			$PICUREUPLOADED = $_FILES['picture']['name'];
		} else {
			$PICUREUPLOADED = '';
		}
		
		if(empty($PICUREUPLOADED) && !empty($_SESSION['picture'])) {
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
}

if(!empty($_POST['Publish'])) {
	#// Data check
	if(empty($_POST['template'])) {
		$ERR = $MSG__0142;
	} elseif(empty($_POST['pagetitle']) ||
	empty($_POST['welcome']) ||
	empty($_POST['welcomemsg'])) {
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
			} if(!file_exists($uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN'])) {
				umask();
				mkdir($uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN'], 0777);
			}
			move_uploaded_file($_FILES['picture']['tmp_name'],$uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/".$_FILES['picture']['name']);
			chmod($uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/".$_FILES['picture']['name'],0666);
			$PICUREUPLOADED = $_FILES['picture']['name'];
		} elseif (!empty($_SESSION['picture'])) {
			copy($uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/_".$_SESSION['picture'],
			$uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/".substr($_SESSION['picture'],0,strlen($_SESSION['picture'])));
			$PICUREUPLOADED = substr($_SESSION['picture'],0,strlen($_SESSION['picture']));
			
			#// Remove temp picture
			unlink($uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/_".$_SESSION['picture']);
		} else {
			$PICUREUPLOADED = '';
		}
		
		if(empty($PICUREUPLOADED) && !empty($_SESSION['picture'])) {
			$PICUREUPLOADED = $_SESSION['picture'];
		}
		
		#// Manage other data
		$query = "INSERT INTO HB_aboutmeusers  VALUES(
					  '".$_SESSION['HAPPYBID_LOGGED_IN']."',
					  '".addslashes($_POST['pagetitle'])."',
					  '".addslashes($_POST['welcome'])."',
					  '".addslashes($_POST['welcomemsg'])."',
					  '".addslashes($_POST['paragraph'])."',
					  '".addslashes($_POST['paragraphmsg'])."',
					  ".intval($_POST['auctions']).",
					  '".addslashes($PICUREUPLOADED)."',
					  ".intval($_POST['template']).")";
		$res = @mysql_query($query);
		if(!$res) {
			MySQLError($query);
			exit;
		}
		
		#// Redirect
		Header("Location: user_menu.php");
		exit;
	}
}

$_POST = $_SESSION;

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
include phpa_include("template_create_aboutme_php.html");
include "footer.php";

?>
