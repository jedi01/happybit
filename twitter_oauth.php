<?php
include "./includes/config.inc.php";
require("twitteroauth/twitteroauth.php");  
session_start();  

$tw_consumer_key = $SETTINGS['twitter_consumer'];
$tw_consumer_secret = $SETTINGS['twitter_secret'];
$tw_login_url = $SETTINGS['siteurl'] . "twitter-login.php";

// TwitterOAuth instance, with two new parameters we got in twitter_login.php  
$twitteroauth = new TwitterOAuth($tw_consumer_key, $tw_consumer_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);  
// Let's request the access token  
$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']); 
// Save it in a session var 
$_SESSION['access_token'] = $access_token; 
// Let's get the user's info 
$user_info = $twitteroauth->get('account/verify_credentials'); 
// Print user's info  

if(!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){  
    // We've got everything we need  

if(isset($user_info->error)){  
    // Something's wrong, go back to square 1  
    //echo $user_info->error;
    header('Location: http://www.asos-discounts.com/twitter-login.php'); 
} else { 
    // Let's find the user by its ID  
 $query = mysql_query("SELECT * FROM HB_users WHERE oauth_provider = 'twitter' AND oauth_uid = ". $user_info->id);  
    $result = mysql_fetch_array($query); 
 
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

    // If not, let's add it to the database  
    if(empty($result)){  
                
if (isset($_COOKIE['bidreferral'])){
                   $cookieRefID = $_COOKIE["bidreferral"];
                }else
                     {
                        $cookieRefID = 0;
                     }
$bonusBidsCredited = $SETTINGS['bonus_signup_bids'];


$queryUN = mysql_query("SELECT * FROM HB_users WHERE nick = '".$user_info->screen_name."'");
$lowUsername = $user_info->screen_name;
$addID = 1;

while($row = mysql_fetch_array($queryUN)){
    if ($addID==1){
    $username = $row['nick'];
    $lowUsername = strtolower($username);  
    }
    $lowUsername = $username . $addID++;
    $queryUN = mysql_query("SELECT * FROM HB_users WHERE nick = '".$lowUsername."'");
    $username = $row['nick'];
}


 $query = mysql_query("INSERT INTO HB_users (id, referrer, nick, name, password, balance, oauth_provider, oauth_uid, oauth_token, oauth_secret) VALUES (NULL, '$cookieRefID','$lowUsername','{$user_info->name}','$finalPwd','$bonusBidsCredited','twitter',{$user_info->id},'{$access_token['oauth_token']}','{$access_token['oauth_token_secret']}')");  
echo mysql_error ();
        $query = mysql_query("SELECT * FROM HB_users WHERE id = " . mysql_insert_id());  

        $result = mysql_fetch_array($query);   

    } else {  
        // Update the tokens  
        $query = mysql_query("UPDATE HB_users SET oauth_token = '{$access_token['oauth_token']}', oauth_secret = '{$access_token['oauth_token_secret']}' WHERE oauth_provider = 'twitter' AND oauth_uid = {$user_info->id}");  
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

}

} else {  
    // Something's missing, go back to square 1  
    header('Location: twitter-login.php');  
}  


?>