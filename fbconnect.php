<?
include "./includes/config.inc.php";

$fb_app_id = $SETTINGS['fb_app_id'];
$fb_app_secret = $SETTINGS['fb_app_secret'];
$fb_toplevel = $SETTINGS['siteurl'];


if(!isset($_SESSION['user']))   
{   
    $app_id        = $fb_app_id;   
    $app_secret    = $fb_app_secret;
    $site_url    = $fb_toplevel . "fb-login.php";   

	try{
		include_once "src/facebook.php";
	}catch(Exception $e){
		error_log($e);
	}
	// Create our application instance
	$facebook = new Facebook(array(
		'appId'		=> $app_id,
		'secret'	=> $app_secret,
		));

	// Get User ID
	$user = $facebook->getUser();


$_SESSION['email2'] = $user_profile2['email'];


	// We may or may not have this data based 
	// on whether the user is logged in.
	// If we have a $user id here, it means we know 
	// the user is logged into
	// Facebook, but we don’t know if the access token is valid. An access
	// token is invalid if the user logged out of Facebook.
	//print_r($user);
	if($user){
		// Get logout URL
		$logoutUrl = $facebook->getLogoutUrl();
	}else{
		// Get login URL
	$loginUrl = $facebook->getLoginUrl(array(
			'scope'	=> 'email',
			'redirect_uri'	=> $site_url,
'display' => 'popup'
			));
	}

	if($user){

		try{
		// Proceed knowing you have a logged in user who's authenticated.

		$user_profile = $facebook->api('/me');
		//mysqlc();
		

 if (isset($_COOKIE['bidreferral'])){
                   $cookieRefID = $_COOKIE["bidreferral"];
                }else
                     {
                        $cookieRefID = 0;
                     }
                     
function rand_str($length = 14, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')
{
    // Length of character list
    $chars_length = (strlen($chars) - 1);

    // Start our string
    $string = $chars{rand(0, $chars_length)};
    
    // Generate random string
    for ($i = 1; $i < $length; $i = strlen($string))
    {
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};
        
        // Make sure the same two characters don't appear next to each other
        if ($r != $string{$i - 1}) $string .=  $r;
    }
    
    // Return the string
    return $string;
}
$password_hidden = rand_str();
$finalPwd = md5($MD5_PREFIX . Addslashes ($password_hidden));
$bonusBidsCredited = $SETTINGS['bonus_signup_bids'];
       
		$name = $user_profile['name'];
		$email = $user_profile['email'];
		$fb_ID = $user_profile['id'];
        $username = substr($email, 0, strpos($email, '@'));
        echo mysql_error ();


		$query = mysql_query("SELECT * FROM HB_users WHERE oauth_provider = 'facebook' AND oauth_uid = " . $user_profile['id']);
        $result = mysql_fetch_array($query);
		echo mysql_error ();	
		if(empty($result)){

 
$queryUN = mysql_query("SELECT * FROM HB_users WHERE nick = '".$username."'");
$addID = 1;
$lowUsername = $username;
while($row = mysql_fetch_array($queryUN)){
    if ($addID==1){
    $username = $row['nick'];
    $lowUsername = strtolower($username);  
    }
    $lowUsername = $username . $addID++;
    $queryUN = mysql_query("SELECT * FROM HB_users WHERE nick = '".$lowUsername."'");
    $username = $row['nick'];
}


        $query2 = mysql_query("INSERT INTO HB_users (referrer, nick, name, email, password, balance, oauth_provider, oauth_uid) VALUES ('$cookieRefID','$lowUsername','$name','$email','$finalPwd','$bonusBidsCredited', 'facebook', '$fb_ID')");

//send email
$TPL_password_hidden = $finalPwd;
$TPL_id_hidden=mysql_insert_id();
$signupType = 1;
include $include_path."user_confirmation_needapproval.inc.php";
//send email end

      $query = mysql_query("SELECT * FROM HB_users WHERE id = " . mysql_insert_id());  
      $result = mysql_fetch_array($query);
      echo mysql_error ();

			$_SESSION['user'] = $user_profile['email'];
                        $_SESSION['userem'] = $user_profile['email'];
			$_SESSION['fbid'] = $user_profile['id'];
		}
		else
		{
			$row = mysql_fetch_array($query);
			$_SESSION['user'] = $row['email'];
                        $_SESSION['userem'] = $row['email'];
			$_SESSION['fbid'] = $user_profile['id'];
		}

    $_SESSION['id'] = $result['id']; 
    $_SESSION['nick'] = $result['nick']; 
    $_SESSION['oauth_uid'] = $result['oauth_uid']; 
    $_SESSION['oauth_provider'] = $result['oauth_provider']; 
    $_SESSION['oauth_token'] = $result['oauth_token']; 
    $_SESSION['oauth_secret'] = $result['oauth_secret']; 
$query = "select id,name,email,accounttype from HB_users where 
					nick='".$_SESSION["nick"]."' and suspended=0";
echo mysql_error ();
		$res = mysql_query($query);
		//print $query;
		if(mysql_num_rows($res) > 0)
		{
                        $userIs = $_SESSION['nick'];
			$_SESSION["HAPPYBID_LOGGED_IN"] = mysql_result($res,0,"id");
			$_SESSION["HAPPYBID_LOGGED_EMAIL"] = mysql_result($res,0,"email");
			$_SESSION["HAPPYBID_LOGGED_NAME"] = mysql_result($res,0,"name");
			$_SESSION["HAPPYBID_LOGGED_ACCOUNT"] = mysql_result($res,0,"accounttype");
			$_SESSION["HAPPYBID_LOGGED_IN_USERNAME"] = $userIs;
			
			#// Update "last login" fields in users table
			@mysql_query("UPDATE HB_users SET lastlogin='".date("Y-m-d H:i:s",$TIME)."',
						reg_date=reg_date
						WHERE id=".$_SESSION["HAPPYBID_LOGGED_IN"]);
			
			echo mysql_error ();

		}	
header('Location: index.php');  
    

		}catch(FacebookApiException $e){
				error_log($e);
				$user = NULL;

			}
header('Location: index.php'); 
		
	}

	
}
?>