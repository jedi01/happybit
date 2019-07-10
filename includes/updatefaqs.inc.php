<?
if(!defined('INCLUDED')) exit("Access denied");
$NOW = date("YmdHis",mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y")));

$query = "SELECT * FROM HB_faqs";
$res = @mysql_query($query);
while($row = mysql_fetch_array($res))
{
	reset($LANGUAGES);
	while(list($k,$v) = each($LANGUAGES)){
		$TR=@mysql_fetch_array(@mysql_query("SELECT * FROM HB_faqs_translated WHERE lang='".$k."' AND id=".$row['id']));
		if(!$TR){
			$query = "INSERT INTO HB_faqs_translated  VALUES (
					".$row['id'].",
					'$k',
					'".addslashes($row['question'])."',
					'".addslashes($row['answer'])."')";
		}
		mysql_query($query);
		unset($TR_name);
	}
}

?>