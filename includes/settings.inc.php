<?#//v.3.2.2
if(!defined("INCLUDED")) exit("Access denied");
/***********************************************************************
* Don't edit the code below unless you really know what you are doing  *
************************************************************************/

/* -------------------- + Anti Hack Code + Frederic 15/04/2008 --------------- */
if (!function_exists(phpa_safe) ) {
     function phpa_safe() {
        $error = 0;
	$query_string = strtolower(rawurldecode($_SERVER['QUERY_STRING']));
	$bad_string = array("%20union%20", "/*", "*/union/*", "+union+", "load_file", "outfile", "document.cookie", "onmouse", "<script", "<iframe", "<applet", "<meta", "<style", "<form", "<img", "<body", "<link", "_GLOBALS", "_REQUEST", "_GET", "_POST", "include_path", "prefix", "http://", "https://", "ftp://", "smb://" );
	foreach ($bad_string as $string_value)
	{
	  if (strstr( $query_string,  $string_value ))
             $error = 1;
	}
	unset($query_string, $bad_string, $string_value);
	
	
	foreach ( $_GET as $secvalue)
	{
	if ( (eregi("<[^>]*script*\"?[^>]*>", $secvalue)) ||
	     (eregi("<[^>]*object*\"?[^>]*>", $secvalue)) ||
	     (eregi("<[^>]*iframe*\"?[^>]*>", $secvalue)) ||
	     (eregi("<[^>]*applet*\"?[^>]*>", $secvalue)) ||
	     (eregi("<[^>]*meta*\"?[^>]*>", $secvalue)) ||
	     (eregi("<[^>]*style*\"?[^>]*>", $secvalue)) ||
	     (eregi("<[^>]*form*\"?[^>]*>", $secvalue)) ||
	     (eregi("<[^>]*img*\"?[^>]*>", $secvalue)) ||
	     (eregi("<[^>]*onmouseover*\"?[^>]*>", $secvalue)) ||
	     (eregi("<[^>]*body*\"?[^>]*>", $secvalue)) ||
	     (eregi("\([^>]*\"?[^)]*\)", $secvalue)) || 
	     (eregi("ftp://", $secvalue)) || 
	     (eregi("https://", $secvalue)) || 
	     (eregi("http://", $secvalue)) )
		$error = 1;
	}
	
	$ss = $_SERVER['HTTP_USER_AGENT'];
	
	if ((eregi("libwww",$ss)) ||
	    (eregi("^lwp",$ss))  ||
	    (eregi("^Jigsaw",$ss)) ||
	    (eregi("^Wget",$ss)) ||
	    (eregi("^Indy\ Library",$ss)) ) 
	  $error = 1;
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	 if (!empty($_SERVER['HTTP_REFERER']))
	 {
		if (!ereg($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])) $error = 1;
	 }
	}
        if ( $error )
         {
          header("HTTP/1.1 403 Forbidden");
          exit("Access forbbiden");
         }
   }
}
phpa_safe();
/* -------------------- -End- Anti Hack Code + Frederic 15/04/2008 --------------- */

if(!function_exists(phpa_include)){
  function phpa_include($fileto) {
    global $SETTINGS,$prefix;
    if (!isset($SETTINGS['theme']) || empty($SETTINGS['theme'])) $SETTINGS['theme']='default';
    if((strstr($_SERVER['PHP_SELF'],"browse.php") || strstr($_SERVER['PHP_SELF'],"item.php")
      || strstr($_SERVER['PHP_SELF'],"browse_wanted.php") || strstr($_SERVER['PHP_SELF'],"wantedad.php")) && $fileto=='style.css'){ 
      $filename=$SETTINGS['siteurl']."themes/".$SETTINGS['theme']."/".$fileto;
    }else{
      $filename="themes/".$SETTINGS['theme']."/".$fileto;
      if (!file_exists($filename)) {
        if (!file_exists($P."themes/default/".$fileto)) {
          exit("Missing template: themes/default/".$fileto);
        } else {
          $filename=$P."themes/default/".$fileto;
        }
      }
    }
    return $filename;
  }
}

if(!function_exists(phpa_uploaded)){
  function phpa_uploaded($useprefix=true) {
    global $SETTINGS,$prefix;
    if (!isset($SETTINGS['theme']) || empty($SETTINGS['theme'])) $SETTINGS['theme']='default';
    $dirname="themes/".$SETTINGS['theme'];
    if (!is_dir($prefix.$dirname)) {
      if (!is_dir($prefix."themes/default")) {
        $dirname="uploaded";
      } else {
        $dirname="themes/default";
      }
    }
    return ($useprefix ? $prefix : "").$dirname."/";
  }
}
if(!function_exists(setsspan)){
  function setsspan($astring,$astyle) {
    return '<SPAN style="'.$astyle.'">'.$astring."</SPAN>";
  }
}
if(!function_exists(getUrlParams)){
  function getUrlParams($sep){
    $params = $_SERVER["PATH_INFO"];
    $params = substr($params,1);
    $params = explode(chr(47),$params);
  
    $tArr = Array();
    for($i=0; $i<count($params); $i++){
      if(trim($params[$i]) != ""){
        $temp = explode($sep, $params[$i]);
        if(trim($temp[1]) != "")
          $tArr[$temp[0]] = $temp[1];
      }
    }
    return $tArr;
  }
}

//--
$password_file = $include_path."passwd.inc.php";
include($password_file);
//-- Database connection

if(!mysql_connect($DbHost,$DbUser,$DbPassword)) {
  $NOTCONNECTED = TRUE;
}
if(!mysql_select_db($DbDatabase)) {
  $NOTCONNECTED = TRUE;
}
if(!strpos($_SERVER['argv'][0],"sendinvoices_cron.php") && !strpos($_SERVER['argv'][0],"cron.php") && !strpos($_SERVER['argv'][0],"sendinvoices_cron.php") && !strpos($_SERVER['argv'][0],"cron.php"))
  session_start();

#// RETRIEVE SETTINGS AND CREATE SESSION VARIABLES FOR THEM
include $include_path."fonts.inc.php";

$query = "select * from HB_settings";
$RES = @mysql_query($query);
if($RES) {
  $SETTINGS = mysql_fetch_array($RES);
  #// Retrieve fonts and colors settings
  $query = "SELECT * FROM HB_fontsandcolors";
  $R__ = mysql_query($query);
  if($R__) {
    $FONTSANDCOLORS = mysql_fetch_array($R__);
    while(list($k,$v) = each($FONTSANDCOLORS)) {
      $SETTINGS[$k] = $v;
    }
  }
  if(file_exists(realpath(phpa_uploaded()."settings.ini"))) {
	 realpath(phpa_uploaded()."settings.ini");
    $INI_SETTINGS=parse_ini_file(realpath(phpa_uploaded()."settings.ini"));
    $SETTINGS=array_merge($SETTINGS,$INI_SETTINGS);	
  }  
}
$_SESSION["SETTINGS"]=$SETTINGS;

if(!isset($prefix)) $prefix="";

include($include_path."currency.inc.php");
include($include_path."errors.inc.php");
#// Gian - sept 12 2002
include($include_path."https.inc.php");

?>
