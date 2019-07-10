<?

include "loggedin.inc.php";

function rebuild_table_file($table)
{
	switch($table) {
		case "levels" :
		$output_filename = "../includes/levels.inc.php";
		$field_name = array("id","max","level","icon");
		$sort_field = 1;
		$array_name = "levels";
		$output = "<?\n";
		$output.= "$" . $array_name . " = array(\n";
		break;
		case "membertypes" :
		$output_filename = "../includes/membertypes.inc.php";
		$field_name = array("id","feedbacks","membertype","icon");
		$sort_field = 1;
		$array_name = "membertypes";
		$output = "<?\n";
		$output.= "$" . $array_name . " = array(\n";
		break;
		case "questions" :
		$output_filename = "../includes/questions.inc.php";
		$field_name = array("id","ord","q_text","q_type","q_resp");
		$array_name = "questions";
		$sort_field = 0;
		$output = "<?\n";
		$output.= "$" . $array_name . " = array(\n";
		break;
		default :
		break;
	}
	
	$sqlqry = "SELECT " . join(",",$field_name) . " FROM HB_" . $table . " ORDER BY " .$field_name[$sort_field] . ";";
	$result = mysql_query ($sqlqry);
	
	if ($result)
	$num_rows = mysql_num_rows($result);
	else {
		echo mysql_error();
		$num_rows = 0;
	}
	
	$i = 0;
	while($i < $num_rows) {
		reset($field_name);
		if(count($field_name) > 1) {
			$fldn=each($field_name);
			$output.="\"" . mysql_result($result,$i, $fldn[value]) . "\" => array(\n";
			$j=1;
			do {
				$output .= "\"" . $fldn[value] . "\"=>\"" . mysql_result($result,$i, $fldn[value]) . "\",";
				$fldn=each($field_name);
				$j++;
			}while ($j<count($field_name));
			$output .= "\"" . $fldn[value] . "\"=>\"" . mysql_result($result,$i, $fldn[value]) . "\")";
		} else {
			$fldn=each($field_name);
			$output .= "\"" . mysql_result($result,$i, $fldn[value]) . "\"";
		}
		$i++;
		if ($i < $num_rows)
		$output .= ",\n";
		else
		$output .= "\n";
	}
	
	$output .= ");\n?>\n";
	
	$handle = fopen ( $output_filename , "w" );
	fputs ( $handle, $output );
	fclose ($handle);
}
?>