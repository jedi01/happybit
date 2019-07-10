<?

	require('./includes/config.inc.php');

	#// If the user is not logged in -> refirect
	if(empty($_SESSION['HAPPYBID_LOGGED_IN'])) {
		Header("Location: user_login.php");
		exit;
	}

	#// Retrieve template HTML code
	$query = "SELECT code FROM HB_aboutmetemplates WHERE id=".$_SESSION['template'];
	$res = @mysql_query($query);
	if(!$res) {
		MySQLError($query);
		exit;
	} elseif(mysql_num_rows($res) > 0) {
		$CODE = mysql_result($res,0,"code");
		$CODE = str_replace("{TITLE}",$_SESSION['pagetitle']." </FONT><A HREF=Javascript:history.back()>$MSG__0145</A>",$CODE);
		$CODE = str_replace("{WELCOME}",$_SESSION['welcome'],$CODE);
		$CODE = str_replace("{WELCOMEMSG}",$_SESSION['welcomemsg'],$CODE);
		$CODE = str_replace("{PARAGRAPH}",$_SESSION['paragraph'],$CODE);
		$CODE = str_replace("{PARAGRAPHMGS}",$_SESSION['paragraphmsg'],$CODE);
		$CODE = str_replace("{PICTURE}","<IMG SRC=".$uploaded_path."aboutmepictures/".$_SESSION['HAPPYBID_LOGGED_IN']."/_".$_SESSION['picture'].">",$CODE);

		if($_SESSION['auctions'] > 0) {
			$query = "SELECT title,id FROM HB_auctions WHERE closed=0 and user='".$_SESSION['HAPPYBID_LOGGED_IN']. "' ORDER BY starts ASC LIMIT ".$_SESSION['auctions'];
			$res = mysql_query($query);
			if(!$res) {
				MySQLError($query);
				exit;
			} elseif(mysql_num_rows($res) > 0) {
				while($row = mysql_fetch_array($res)) {
					$AUCTIONS .= "<A HREF=item.php?id=".$row['id'].">".$row['title']."</A><BR>";
				}
			}
			$CODE = str_replace("{YOURAUCTIONS}",$AUCTIONS,$CODE);
		} else {
			$CODE = str_replace("{YOURAUCTIONS}",'',$CODE);
		}
		print stripslashes($CODE);
	}

?>
