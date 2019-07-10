<style type="text/css">
<!--
<?
	$sty= "font-family:".$FONTS[$SETTINGS["err_font"]].";font-size:".$FONTSIZE[$SETTINGS["err_font_size"]].";color:".$SETTINGS["err_font_color"].";";
	if($SETTINGS["err_font_bold"] == 'y') {
		$sty .= "font-weight: bold;";
	} if($SETTINGS["err_font_italic"] == 'y') {
		$sty .= "font-style: italic;";
	}
	echo ".errfont {".$sty."}\r\n";
	
	$sty= "font-family:".$FONTS[$SETTINGS["sml_font"]].";font-size:".$FONTSIZE[$SETTINGS["sml_font_size"]].";color:".$SETTINGS["sml_font_color"].";";
	if($SETTINGS["sml_font_bold"] == 'y') {
		$sty .= "font-weight: bold;";
	} if($SETTINGS["sml_font_italic"] == 'y') {
		$sty .= "font-style: italic;";
	}
	echo ".smlfont {".$sty."}\r\n";
	
	$sty= "font-family:".$FONTS[$SETTINGS["std_font"]].";font-size:".$FONTSIZE[$SETTINGS["std_font_size"]].";color:".$SETTINGS["std_font_color"];
	if($SETTINGS["std_font_bold"] == 'y') {
		$sty .= "font-weight: bold;";
	} if($SETTINGS["std_font_italic"] == 'y') {
		$sty .= "font-style: italic;";
	}
	echo ".stdfont {".$sty."}\r\n";
	
	echo "body {".(($SETTINGS['background'] && $SETTINGS['brepeat']!='no') ? " background:url(".phpa_uploaded().$SETTINGS['background'].");background-repeat:".$SETTINGS['brepeat'].";":"").$sty."}\r\n";
	
	echo "#container{ width:".$SETTINGS['pagewidth'].($SETTINGS['pagewidthtype']=='perc' ? "%":"px").";background-color:".$SETTINGS['bordercolor']."}\r\n";
	
	$sty= "font-family:".$FONTS[$SETTINGS["footer_font"]].";font-size:".$FONTSIZE[$SETTINGS["footer_font_size"]].";color:".$SETTINGS["footer_font_color"].";";
	if($SETTINGS["footer_font_bold"] == 'y') {
		$sty .= "font-weight: bold;";
	} if($SETTINGS["footer_font_italic"] == 'y') {
		$sty .= "font-style: italic;";
	}
	echo ".tltfont {".$sty."}\r\n";	
	
	echo ".titTable2 {".$sty.";border-color:".$SETTINGS["tlt_font_color"]." }\r\n";
	
	$sty= "font-family:".$FONTS[$SETTINGS["nav_font"]].";font-size:".$FONTSIZE[$SETTINGS["nav_font_size"]].";color:".$SETTINGS["nav_font_color"].";";
	if($SETTINGS["nav_font_bold"] == 'y') {
		$sty .= "font-weight: bold;";
	} if($SETTINGS["nav_font_italic"] == 'y') {
		$sty .= "font-style: italic;";
	}
	echo ".navfont {".$sty."}\r\n";	
	
	echo "th {background-color : ".$SETTINGS['tableheadercolor'].";}\r\n";
	
	echo "#barSec {background-color : ".$SETTINGS['tableheadercolor'].";}\r\n";
	
	echo ".titTable1 {background-color : ".$SETTINGS['tableheadercolor'].";}\r\n";
	
?>
a:link,a:visited {
	color : <?=$SETTINGS['linkscolor']?>;
}
-->
</style>