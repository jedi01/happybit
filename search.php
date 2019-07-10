<?

require('./includes/config.inc.php');
$NOW = date("YmdHis",mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y")));


if (!ini_get('register_globals')) {
   $superglobales = array($_POST, $_GET);
   foreach ($superglobales as $superglobal) {
       extract($superglobal, EXTR_SKIP);
   }
}

$q = trim($_GET['q']);



$query = "".$q;
$query = "".$query; // set $query variable if it's not set yet
$searchQuery = $query;
$qquery = ereg_replace("%","\\%",$query);
$qquery = ereg_replace("_","\\_",$qquery);

if ( strlen($query)==0 ) {
	include "header.php";
	include phpa_include("template_empty_search.html");
	include "footer.php";
	exit;
}

/* generate query syntax for searching in auction */
$search_words = explode (" ", $qquery);

/* query part 1 */
$qp1 = "";
$qp = "";

$qp1 .=
" (title LIKE '%".
addslashes($qquery).
"%' OR id=".intval($q).")  ";

$qp .= " (cat_name LIKE '%".addslashes($qquery)."%') ";

$addOR = true;
while ( list(,$val) = each($search_words) ) {
	$val = ereg_replace("%","\\%",$val);
	$val = ereg_replace("_","\\_",$val);
	if ($addOR) {
		$qp1 .= " OR ";
		$qp .= " OR ";
	}
	$addOR = true;
	
	$qp1 .=
	" (title LIKE '%".
	addslashes($val).
	"%')  ";
	
	$qp .= "(cat_name LIKE '%".addslashes($qquery)."%') ";
}
//	die($qp1);
//	print $qp."<BR>";

$sql_count = "SELECT count(*) FROM HB_auctions 
				WHERE ( $qp1 ) 
				AND ( closed='0')  
				AND ( suspended='0') 
				AND private='n' 
				AND	starts<=".$NOW." 
				ORDER BY ends";
$sql = "SELECT * FROM HB_auctions 
			WHERE ( $qp1 ) 
			AND ( closed='0')  
			AND ( suspended ='0') 
			AND private='n' 
			AND	starts<=".$NOW." 
			ORDER BY ends";
$sql_count_cat = "SELECT count(*) FROM HB_categories 
					WHERE ( $qpc1 ) ORDER BY cat_name ASC";
$sql_cat = "SELECT * FROM HB_categories WHERE ".$qp." ORDER BY cat_name ASC";
//	print $sql_cat."<BR>";

/* get categories whose names fit the search criteria */

$result = mysql_query($sql_cat);
$subcat_count = 0;
if ($result) {
	/* query succeeded - display list of categories */
	$need_to_continue = 1;
	$cycle = 1;
	
	$TPL_main_value = "";
	while ($row=mysql_fetch_array($result)) {
		++$subcat_count;
		if ($cycle==1 ) { $TPL_main_value.="<TR ALIGN=LEFT>\n"; }
		$sub_counter = (int)$row[sub_counter];
		$cat_counter = (int)$row[counter];
		if ($sub_counter!=0) {
			$count_string = "(".$sub_counter.")";
		} else {
			if ($cat_counter!=0) {
				$count_string = "(".$cat_counter.")";
			} else {
				$count_string = "";
			}
		}		
		#//  Select the translated category name
		$row[cat_name] = @mysql_result(mysql_query("SELECT cat_name FROM HB_cats_translated WHERE cat_id=".$row['cat_id']." AND lang='".$language."'"),0,"cat_name");
		
		$TPL_main_value .= "	<TD WIDTH=\"33%\"><A HREF=\"".$SETTINGS['siteurl']."browse.php?id=".$row[cat_id]."\">".$row[cat_name]."</A>".$count_string."</FONT></TD>\n";
		
		++$cycle;
		if ($cycle==4) { $cycle=1; $TPL_main_value.="</TR>\n"; }
	}
	
	if ( $cycle>=2 && $cycle<=3 ) {
		while ( $cycle<4 ) {
			$TPL_main_value .= "	<TD WIDTH=\"33%\">&nbsp;</TD>\n";
			++$cycle;
		}
		$TPL_main_value .= "</TR>\n";
	}
} else {
	print mysql_error();
}

/* get list of auctions of this category */
$auctions_count = 0;

/* retrieve records corresponding to passed page number */
$page = (int)$_GET[page];
if ($page==0)	$page = 1;
$lines = (int)$lines;
if ($lines==0)	$lines = 50;

/* determine limits for SQL query */
$left_limit = ($page-1)*$lines;

/* get total number of records */
$rsl = mysql_query ( $sql_count );
if ($rsl) {
	$hash = mysql_fetch_array($rsl);
	$total = (int)$hash[0];
} else {
	$total = 0;
}

/* get number of pages */
$pages = (int)($total/$lines);
if (($total % $lines)>0)
++$pages;

$result = mysql_query ( $sql." LIMIT $left_limit,$lines" );

// to be sure about items format, I've unified the call
include $include_path."browseitems.inc.php";
$TPL_auctions_list_value=browseItems($result);
$auctions_count=count($TPL_auctions_list_value);

$TPL_auctions_total_value .= "<BR>".
"$MSG_290 $total<BR>".
"$MSG_289 $pages ($lines $MSG_291)<BR>".
"Pages: ";

for ($i=1; $i<=$pages; ++$i) {
	$TPL_auctions_total_value .=
	($page==$i)	?
	" $i "	:
	" <A HREF=\"search.php?id=$id&page=$i&q=".urlencode($searchQuery)."\">$i</A> ";
}

$TPL_auctions_total_value .="</FONT>";
if ($auctions_count==0) {
	$TPL_auctions_total_value = "$ERR_114";
}


if ($auctions_count==0) {
	$TPL_auctions_list_value=array();
	$TPL_auctions_total_value = "<TR ALIGN=CENTER><TD COLSPAN=5> $MSG_198 <BR><BR></FONT></TD></TR>".$TPL_auctions_total_value;
}

include "header.php";
if ( $subcat_count>0 ) {
	include phpa_include("template_browse_php.html");
} else {
	include phpa_include("template_auctions_no_cat.html");
}

include "footer.php";
?>