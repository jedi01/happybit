<?
if(!defined('INCLUDED')) exit("Access denied");
#// Retrieve banned free mail domains
$DOMAINS=@mysql_result(@mysql_query("SELECT banemail FROM L2B_usersettings"),0,"banemail");
$BANNEDDOMAINS = array_filter(explode("\n",$DOMAINS),chop);

Function BannedEmail($email,$domains){
	$dom = explode('@',$email);
	$domains = array_map(chop,$domains);
	if(in_array($dom[1],$domains)){
		return TRUE;
	}else{
		return FALSE;
	}

}
 ?>
