<?

include './includes/config.inc.php';
include $include_path.'countries.inc.php';
include "header.php";
$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
$NOW = date("YmdHis",$TIME);

if(empty($_GET[page]) && $_GET[PAGE]){
  $page = $_GET[PAGE];
}
/*
 * Recursive categories tree visit;
 * It returns a list of all not-labeled subcategories
 */
function getsubtree($catsubtree,$i) {
	global $catlist;	
	$res=mysql_query("select * FROM HB_categories WHERE parent_id=".intval($catsubtree[$i]));
	while($row=mysql_fetch_assoc($res)) {
		// get info about this parent
		$catlist[]=$row['cat_id'];
		$catsubtree[$i+1]=$row['cat_id'];
		getsubtree($catsubtree,$i+1);
	}
}

if(empty($_GET)) {
	unset($_SESSION['category']);
	unset($_SESSION['catlist']);
}

if ($_GET["title"]) {
 	if ($desc) 	$wher .= "((au.description like '%".addslashes($_GET["title"])."%') ";
 	else $wher .= "((1=0) ";
  	if ($_GET["title"]) $wher .= " OR (au.title like '%".addslashes($_GET["title"])."%' OR au.id=".intval($_GET["title"]).")) AND ";
	else $wher .= ") AND";
}
if ($_GET["seller"]) {
	$query = "select id from HB_users where nick ='".addslashes($_GET["seller"])."'";
	$res = mysql_query($query);
	if(!$res) {
		print "Error: $query<br />".mysql_error();
		exit;
	}
	
	if(mysql_num_rows($res) > 0) {
		$SELLER_ID = mysql_result($res,0,"id");
		$wher .= "(au.user=$SELLER_ID) AND ";
	} else {
		$wher .= "(au.user like '%-------------%') AND ";
	}
}
if ($_GET["buyitnow"]=='y') {
	$wher .= "(au.buy_now > 0) AND ";
}
if ($_GET["buyitnowonly"]=="y") {
	$wher .= "(au.bn_only='y') AND ";
}
if ($_GET["zipcode"]) {
	$wher .= "(au.location_zip like '%".addslashes($_GET["zipcode"])."%') AND ";
}
if ($_GET["closed"]) $wher .= "(au.closed IN ('0','1')) AND ";
else $wher .="(au.closed = '0') AND ";
if ($_GET["category"]) {
		$catlist=array();
		$catsubtree[0]=$_GET["category"];
		$catlist[]=$catsubtree[0];
		getsubtree($catsubtree,0);
		$catalist="(";
		$catalist.=join(",",$catlist);
		$catalist.=")";	
	$wher .= "(au.category IN $catalist) AND ";
}
if ($maxprice) $wher .= "(au.minimum_bid<=".doubleval($maxprice)."  ) AND ";
if ($minprice) $wher .= "(au.minimum_bid>=".doubleval($minprice).")AND ";
if ($type && ($type=='1' || $type == '2')) $wher .= "(au.auction_type='$type') AND ";
if ($ending && ($ending=='1' || $ending=='2' || $ending=='4' || $ending=='6')) {
	$data=date('YmdHms',$TIME+($ending*86400));
	$wher .="(au.ends<=$data) AND";
}
if ($_GET["country"]) $wher .= "(au.location='".addslashes($_GET["country"])."') AND ";
if (is_array($payment)) {
	reset($payment);
	$pri=false;
	foreach($payment as $key=>$val) {
		if (!$pri) $ora .= "AND ((au.payment like '%".addslashes($val)."%')";
		else $ora .= " or (au.payment like '%".addslashes($val)."%')";
		$pri=true;
	}
	$ora .= ") ";
}
if ($SortProperty=='starts'){$by='au.starts DESC';}
else if ($SortProperty=='min_bid'){$by='au.minimum_bid';}
else if ($SortProperty=='max_bid'){$by='au.minimum_bid DESC';}
else {$by='au.ends ASC';}

if ((!empty($wher) || !empty($ora)) && isset($_GET['go'])) {
	/* retrieve records corresponding to passed page number */
	$page = (int)$page;
        if (intval($page)==0)  $page = 1;
	$lines = (int)$lines;
	if ($lines==0)	$lines = 50;
	
	/* determine limits for SQL query */
	$left_limit = ($page-1)*$lines;
	
	/* get total number of records */
	$query="select count(*) as total FROM HB_auctions au
			WHERE (au.suspended='0') 
			AND ($wher au.private='n' $ora)
			AND	au.starts<=".$NOW." 
			ORDER BY $by";
	$sql = mysql_query($query);
	if ($sql) {
		$hash = mysql_fetch_array($sql);
		$total = (int)$hash['total'];
	} else
	$total = 0;
	
	/* get number of pages */
	$pages = (int)($total/$lines);
	if (($total % $lines)>0)
	++$pages;
	
	/* get records corresponding to this page*/
	$query="select au.* FROM HB_auctions au
			WHERE (au.suspended='0') 
			AND ($wher au.private='n' $ora)
			AND	au.starts<=".$NOW." 
			ORDER BY $by LIMIT ".intval($left_limit).",".intval($lines);
  $sql2 = mysql_query($query);
	// to be sure about items format, I've unified the call
	if(@mysql_num_rows($sql2) > 0) {
		include $include_path."browseitems.inc.php";
		$TPL_auctions_list_value=browseItems($sql2);
		$auctions_count=count($TPL_auctions_list_value);
		
		$TPL_auctions_total_value .= "".
		"<br />".
		"$MSG_290 $total<br />".
		"$MSG_289 $pages ($lines $MSG_291)<br />".
		"$MSG_25_0229";
		parse_str ($_SERVER['QUERY_STRING'], $newpage);
		// reconstruction of the query, with added parameters
		$hrefp="adsearch.php?";
		foreach($newpage as $k=>$v) {
			if(!is_array($v) && $v!='page') $hrefp.=$k.'='.$v.'&';
			else {
				foreach($v as $vk=>$vv) {
					if(!is_array($vv)) $hrefp.=$k.'['.$vk.']='.$vv.'&';
					else {
						foreach($vv as $vvk=>$vvv) {
							$hrefp.=$k.'['.$vk.']['.$vvk.']='.$vvv.'&';
						}
					}
				}
			}
		}
		for ($i=1; $i<=$pages; ++$i) {
			$TPL_auctions_total_value .=
			($page==$i)	?
			" $i "	:
			"<a href=\"$hrefp"."page=$i\">$i</a> ";
		}

    $PAGE  = $page;
    $PAGES = $pages;
		
		$TPL_auctions_total_value .="";
		if ($auctions_count==0) {
			$TPL_auctions_total_value = ""."$ERR_114";
		}
		include phpa_include("template_browse_php.html");
		include "footer.php";
		exit;
	}else{
		$ERR = $ERR_122;
	}
//added parameters for number of pages in the template browse
	$id = "&";
	foreach($_GET as $k => $v){
      if($k!='PAGE' && $k!='page' && $k!='id'){
	  $id .= $k."=".$v."&";
	  }
	}
	
}
// -------------------------------------- payment
$qurey = "select * from HB_payments";
$res_payment = mysql_query($qurey);
if(!$res_payment) {
	MySQLError($qurey);
	exit;
}
$num_payments = mysql_num_rows($res_payment);
$TPL_payments_list="";
$i = 0;
while($i < $num_payments) {
	$payment_descr = mysql_result($res_payment,$i,"description");
	$TPL_payments_list.="<input type=checkbox name=\"payment[]\" value=\"$payment_descr\"";
	if($payment_descr == $payment[$i]) {
		$TPL_payments_list .= " checked=true";
	}
	$TPL_payments_list .= " />$payment_descr<br />";
	$i++;
}
// -------------------------------------- category
$TPL_categories_list= "<select name=\"category\" onChange='javascript:document.adsearch.submit()'><option></option>\n";
$result = mysql_query("select * FROM HB_categories_plain");
if($result) {
	while($row=mysql_fetch_array($result)) {
		#//  Select the translated category name
		$spaces=substr_count($row['cat_name'],'&nbsp;');
		unset($tmp);
		while($spaces>0){
			$tmp .= "&nbsp;";
			$spaces--;
		}
		$row['cat_name'] = $tmp.@mysql_result(mysql_query("SELECT cat_name FROM HB_cats_translated WHERE cat_id=".$row['cat_id']." AND lang='".$language."'"),0,"cat_name");
		$TPL_categories_list.="		<option value=\"".$row['cat_id']."\" ".(($row['cat_id']==$_GET["category"])?" selected=true":"").">".$row['cat_name']."</option>\n";
	}
}
$TPL_categories_list.="</select>\n";
// Variant fields construction
$cattree=array();
// -------------------------------------- country
$TPL_countries_list="<select name=\"country\">\n";
reset($countries);
foreach($countries as $key=>$val) {
	$TPL_countries_list.=
	"        <option value=\"".
	$val.
	"\" ".
	(($val==$_GET["country"])?" selected=true":"")
	.">".$val."</option>\n";
}
$TPL_countries_list.="</select>\n";
include phpa_include("template_advanced_search.html");
include "footer.php";
?>
