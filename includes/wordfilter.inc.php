<?
if(!defined('INCLUDED')) exit("Access denied");



Function Filter($txt)
{
	#//
	$query = "SELECT * FROM HB_filterwords";
	$res__ = @mysql_query($query);
	if(!$res__)
	{
		MySQLError($query);
		exit;
	}
	elseif(mysql_num_rows($res__) > 0)
	{
		while($word = mysql_fetch_array($res__))
		{
			$txt = str_replace($word[word],"",$txt);
		}
	}

	return $txt;
}
?>