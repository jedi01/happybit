<?#//v.3.1.0
if(!defined('INCLUDED')) exit("Access denied");

#// EDIT THE FOLLOWING LINES *********************************************************
#// Add the languages you want to enable below in the following form:
#//
#//		"XX" => "Language",
#//
#// where 
#//		XX: is the two characters code of the language (i.e. IT for "italian", "FR" for french, ect
#//		Language: is the description of the language
#//
#// Default languages are English and Spanish
$LANGUAGES = array(
"EN" => "English",
"IT" => "Italiano",
"ES" => "Español"
);

#// END OF EDIT AREA *********************************************************


#// Retrieve available languages
if($dir = opendir($include_path))
{
	while (($file = readdir($dir)) !== false)
	{
		if(ereg("^messages\.([A-Z]{2})\.inc\.php$",$file,$regs))
		{
			$LANGUAGES[$regs[1]] = $regs[1];
		}
	}
	closedir($dir);
}

if(!function_exists(ShowFlags))
{
	Function ShowFlags()
	{
		GLOBAL $SETTINGS,$LANGUAGES;
		reset($LANGUAGES);

		$counter = 0;
		foreach($LANGUAGES as $lang => $value)
		{
			if($counter > 3)
			{
				print "<BR>";
				$counter = 0;
			}
			print "<A HREF=".$_SERVER['PHP_SELF']."?lan=$lang><IMG vspace=2 hspace=2 SRC=".$SETTINGS['siteurl']."includes/flags/".$lang.".gif BORDER=0 alt=\"$lang\"/></A>";
			$counter++;
		}
	}
}

if(!function_exists(ShowAdminFlags))
{
	Function ShowAdminFlags()
	{
		GLOBAL $SETTINGS,$LANGUAGES,$LANGUAGES;
		reset($LANGUAGES);
		
		if(count($LANGUAGES) <= 1) return;
		
		$counter = 0;
		foreach($LANGUAGES as $lang => $value)
		{
			print "<A TARGET=_top HREF=index.php?lan=$lang><IMG ALIGN=MIDDLE vspace=2 hspace=2 SRC=".$SETTINGS['siteurl']."includes/flags/".$lang.".gif BORDER=0></A>";
		}
	}
}
?>
