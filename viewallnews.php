<?
	// Connect to sql server & inizialize configuration variables
	require('./includes/config.inc.php');
	require("header.php");

	$query = "SELECT * from HB_news where suspended=0 order by new_date";
	$res = mysql_query($query);
	if(!$res)
	{
		MySQLError($query);
		exit;
	}
	
	$TPL_all_news .= "<ul>";
	while($new = mysql_fetch_array($res))
	{
		$new['title'] = stripslashes($new['title']);
		$new['content']=(strlen($new['content'])>320)? substr(stripslashes($new['content']),0,320)."...":stripslashes($new['content']);
		$TPL_all_news .= "<li>
			<span style='font:bold 14px arial;'>&nbsp;<A HREF=\"viewnew.php?id=$new[id]\">$new[title]</A></span><br/><br/>
			".$new['content']."<br/><br/>
			<b>".FormatDate($new[new_date])."</b><br/><br/><br/>
			</li>";
	}
	$TPL_all_news .= "</ul>";

	include phpa_include("template_view_allnews_php.html");
	include phpa_include("template_user_menu_footer.html");

?>