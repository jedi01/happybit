<?
if(!defined('INCLUDED')) exit("Access denied");
if(!function_exists(GetBrowserPlatoform)) {
	function GetBrowserPlatoform($USER_AGENT) {
		GLOBAL $BROWSERS, $OS;
		
		$PLATFORM = '';
		$VERSION= '';
		$BROWSER = '';
		
		$SPLITTED = explode("(",$USER_AGENT);
		#// Browser --
		while(list($k,$v) = each($BROWSERS)) {
			if(eregi("$k",$SPLITTED[1],$st_regs)) {
				$BROWSER= $v;
				$VERSION= $st_regs[2];
				break 1;
			}
		}
		if($BROWSER == "") {
			reset($BROWSERS);
			while(list($k,$v) = each($BROWSERS)) {
				if(eregi("$k",$SPLITTED[0],$st_regs)) {
					$BROWSER= $v;
					$VERSION= $st_regs[2];
					break 1;
				}
			}
		}
		
		
		/* System detection */
		while(list($k,$v) = each($OS)) {
			if(eregi("$k",$USER_AGENT,$st_regs) || eregi("$v",$USER_AGENT,$st_regs)) {
				$PLATFORM= $v;
				break 1;
			}
		}
		
		if ($BROWSER!= '' || $PLATFORM != '') {
			$RETURN[0] = $BROWSER;
			$RETURN[1] = $PLATFORM;
		}
		if($BROWSER == "") $RETURN[0] = "Unknown";
		if($PLATFORM == "") $RETURN[1]= "Unknown";
		
		return($RETURN);
	}
}
include $prefix."includes/browsers.inc.php";
include $prefix."includes/platforms.inc.php";

?>