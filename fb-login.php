<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

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
$DbHost     = "localhost"; // The host where the MySQL server resides
$DbDatabase = "happybid_2017"; // The database you are going to use
$DbUser     = "happybid_adz"; // Username
$DbPassword = "E_@ASvXSwUPh"; // Password
$server_path= "/home/happybidco/public_html/"; 
if(!mysql_connect($DbHost,$DbUser,$DbPassword)) {
  $NOTCONNECTED = TRUE;
}
if(!mysql_select_db($DbDatabase)) {
  $NOTCONNECTED = TRUE;
}


$fb_app_id = "258503047593568";
$fb_app_secret = "c14286a9149f806a9b8b6658818f9d33";
$fb_toplevel = "http://happybid.co.uk/fb-login.php";

 

$app_id        = $fb_app_id;   
$app_secret    = $fb_app_secret;
$site_url    = $fb_toplevel;   

require_once 'autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;


// init app with app id and secret
FacebookSession::setDefaultApplication( $app_id,$app_secret );
// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper($site_url );

try {
   
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}

if ( isset( $session ) ) {

	try{
	   
		// Proceed knowing you have a logged in user who's authenticated.
		// graph api request for user data
		$request = new FacebookRequest( $session, 'GET', '/me?locale=en_US&fields=name,email,id,location,gender,first_name,last_name' );
		//$request = new FacebookRequest( $session, 'GET', '/me' );
		$response = $request->execute();
		
	  // get response
		$graphObject = $response->getGraphObject();
		$user_profile['id'] = $graphObject->getProperty('id');              // To Get Facebook ID
		$user_profile['name'] = $graphObject->getProperty('name'); // To Get Facebook full name
		$fbfirstname = $graphObject->getProperty('first_name'); // To Get Facebook full name
		$fbflastname = $graphObject->getProperty('last_name'); // To Get Facebook full name
		$user_profile['email'] = $graphObject->getProperty('email');
		$fgender = $graphObject->getProperty('gender');
		$facebook_location = $graphObject->getProperty('location');
		//mysqlc();
		if (isset($_COOKIE['bidreferral'])){
			$cookieRefID = $_COOKIE["bidreferral"];
		}
		else{
			$cookieRefID = 0;
		}
					 
		
		$password_hidden = rand_str();
		$finalPwd = md5($MD5_PREFIX . Addslashes ($password_hidden));
		$bonusBidsCredited = 1;
			   
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
			$query2 = mysql_query("INSERT INTO HB_users (referrer, nick, name, email, password, balance, oauth_provider, oauth_uid, regtime) VALUES ('$cookieRefID','$lowUsername','$name','$email','$finalPwd','$bonusBidsCredited', 'facebook', '$fb_ID', NOW())");

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
		//error_log( print_r($_SESSION['nick'], 1) );
		
		#// Update "last login" fields in users table
		$sql3 = "UPDATE HB_users SET lastlogin=NOW() WHERE id=".$_SESSION["id"]; 
		mysql_query($sql3);
;
		//@mysql_query("UPDATE HB_users SET lastlogin=NOW() WHERE id=".$_SESSION["id"]);

		
		if(mysql_num_rows($res) > 0)
		{
					$userIs = $_SESSION['nick'];
			$_SESSION["HAPPYBID_LOGGED_IN"] = mysql_result($res,0,"id");
			$_SESSION["HAPPYBID_LOGGED_EMAIL"] = mysql_result($res,0,"email");
			$_SESSION["HAPPYBID_LOGGED_NAME"] = mysql_result($res,0,"name");
			$_SESSION["HAPPYBID_LOGGED_ACCOUNT"] = mysql_result($res,0,"accounttype");
			$_SESSION["HAPPYBID_LOGGED_IN_USERNAME"] = $userIs;
		
			#// Update "last login" fields in users table
			//@mysql_query("UPDATE HB_users SET lastlogin='".date("Y-m-d H:i:s",$TIME)."',
			//			reg_date=reg_date
			//			WHERE id=".$_SESSION["HAPPYBID_LOGGED_IN"]);
			
			echo mysql_error ();

		}
		header('Location: index.php');  


	}catch(FacebookApiException $e){
	   
			error_log($e);
			$user = NULL;

	}
	header('Location: index.php'); 
	
}
else {
	
	$loginUrl=$helper->getLoginUrl(array('email','user_location'));
	header("Location: ".$loginUrl);
}	

?>