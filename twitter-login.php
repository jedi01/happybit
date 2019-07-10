<?php
require('./includes/config.inc.php');
require("twitteroauth/twitteroauth.php");  
session_start();  

$tw_consumer_key = $SETTINGS['twitter_consumer'];
$tw_consumer_secret = $SETTINGS['twitter_secret'];
$tw_oauth_url = $SETTINGS['siteurl'] . "twitter_oauth.php";

// The TwitterOAuth instance  
$twitteroauth = new TwitterOAuth($tw_consumer_key, $tw_consumer_secret);  
// Requesting authentication tokens, the parameter is the URL we will be redirected to  
$request_token = $twitteroauth->getRequestToken($tw_oauth_url);  
  
// Saving them into the session  
$_SESSION['oauth_token'] = $request_token['oauth_token'];  
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];  
  
// If everything goes well..  
if($twitteroauth->http_code==200){  
    // Let's generate the URL and redirect  
    $url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']); 
    header('Location: '. $url); 
} else { 
    // It's a bad idea to kill the script, but we've got to know when there's an error.  
    die('Something wrong happened.');  
}  


?>