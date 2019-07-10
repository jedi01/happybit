<?
if(!defined('INCLUDED')) exit("Access denied");
$NOW = date("YmdHis",mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y")));

$query = "SELECT * FROM HB_categories";
$res = @mysql_query($query);
while($row = mysql_fetch_array($res))
{
	reset($LANGUAGES);
	while(list($k,$v) = each($LANGUAGES)){
		$TR_name=@mysql_result(@mysql_query("SELECT cat_name FROM HB_cats_translated WHERE lang='".$k."' AND cat_id=".$row['cat_id']),0,"cat_name");
		if(!empty($TR_name)){
			$query = "UPDATE HB_cats_translated SET cat_name'".addslashes($row['cat_name'])."' WHERE cat_id=".$row['cat_id']." AND lang'".$k."'";
		}else{
			$query = "INSERT INTO HB_cats_translated  VALUES (
					".$row['cat_id'].",
					'$k',
					'".addslashes($row['cat_name'])."')";
		}
		mysql_query($query);unset($TR_name);
	}
}

?>