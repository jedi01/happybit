<?

	
include "./includes/config.inc.php";
include $include_path."countries.inc.php";

if ($_POST[action] =="ok")
{
	if ($_POST[TPL_username])
	{
		$sql = "SELECT email,id FROM HB_users WHERE email='".addslashes($_POST[TPL_username])."'";

		$res=mysql_query ($sql);
		if ($res)
		{
			if (mysql_num_rows($res)>0)
			{
					//-- Generate a new random password and mail it to the user
					$EMAIL = mysql_result($res,0,"email");
					$ID = mysql_result($res,0,"id");

					$NEWPASSWD = substr(uniqid(md5(time())),0,6);

					#// Added on Jan 2004 for XL 2.0
					$USERLANG = @mysql_result(@mysql_query("SELECT language
															FROM HB_userslanguage
															WHERE user=".intval($ID)),0,"language");
					if(empty($USERLANG)) $USERLANG = $SETTINGS['defaultlanguage'];

					include $include_path."newpasswd.EN.inc.php";
					
					$headers = "From: ". $SETTINGS['sitename']. " <". $SETTINGS['adminmail']. ">\r\n" . "Reply-To: ". $SETTINGS['adminmail']. "\r\n" . "Return-path: ". $SETTINGS['adminmail'] ."\r\n" . "MIME-Version: 1.0\n" . "Content-Type: text/html; charset=utf-8";
					mail($to,$subject,$message,$headers);

					//-- Update database
					$query = "update HB_users set password='".md5($MD5_PREFIX.$NEWPASSWD)."'
								,reg_date=reg_date
								WHERE email='".$_POST["TPL_username"]."'";
					$res = mysql_query($query);
					if(!$res)
					{
						//print "An error occured while accessing the database: $query<BR>".mysql_error();
						exit;
					}

					include "header.php";
					include phpa_include("template_passwd_sent_php.html");
					include "footer.php";
					exit;
			}
			else
			{
				$TPL_err=1;
				$TPL_errmsg="Sorry, that email address does not exist";
			}
		}
		else
		{
			MySQLError($query);
			exit;
		}
	}
	else
	{
		$TPL_err=1;
		$TPL_errmsg=$ERR_112;
	}
}

if(!$_POST[action] || ($_POST[action] && $TPL_errmsg))
{
	include "header.php";
	include phpa_include("template_forgotpasswd_php.html");
}


	include "footer.php";
	$TPL_err=0;
	$TPL_errmsg="";
?>
