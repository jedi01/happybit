<?

require('../includes/config.inc.php');
include "loggedin.inc.php";
include "../includes/countries.inc.php";

$auction_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
$user_id = isset($_REQUEST['uid']) ? $_REQUEST['uid'] : "";


?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<STYLE TYPE="text/css">
body {
scrollbar-face-color: #aaaaaa;
scrollbar-shadow-color: #666666;
scrollbar-highlight-color: #aaaaaa;
scrollbar-3dlight-color: #dddddd;
scrollbar-darkshadow-color: #444444;
scrollbar-track-color: #cccccc;
scrollbar-arrow-color: #ffffff;
}</STYLE>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
$action=isset($_REQUEST['action'])?$_REQUEST['action']:"";
$aid=isset($_REQUEST['aid'])?$_REQUEST['aid']:"";
$bid_value=isset($_POST['bid_value']) ? $_POST['bid_value'] :"";
$number_of_bids=isset($_POST['number_of_bids']) ? $_POST['number_of_bids'] :"";
if ($action=='clone' && (int)$aid>0 && (int)$number_of_bids>0 && (int)$bid_value>0 ) {

    $query = "INSERT INTO HB_auctions(
                user,
                title,
                starts,
                second_starts,
                description,
                pict_url,
                category,
                minimum_bid,  
                reserve_price,
                buy_now,
                auction_type,
                minimum_users,
                ignore_minimal_users,
                duration,
                second_duration,
                increment,
                location,
                location_zip,
                shipping,
                payment,
                international,
                ends,
                second_ends,
                current_bid,
                closed,
                photo_uploaded,
                quantity,
                suspended,
                canceled,
                private,
                relist,
                relisted,
                num_bids,
                sold,
                shipping_terms,
                bn_only,
                adultonly,
                is_main_auction,
                item_value, 
                bid_value)
            (SELECT
                user,
                title,
                starts,
                second_starts,
                description,
                pict_url,
                category,
                minimum_bid,  
                reserve_price,
                buy_now,
                auction_type,
                minimum_users,
                ignore_minimal_users,
                duration,
                second_duration,
                increment,
                location,
                location_zip,
                shipping,
                payment,
                international,
                ENDS,
                second_ends,
                current_bid,
                closed,
                photo_uploaded,
                quantity,
                suspended,
                canceled,
                private,
                relist,
                relisted,
                num_bids,
                sold,
                shipping_terms,
                bn_only,
                adultonly,
                is_main_auction,
                item_value, 
                bid_value  
            FROM HB_auctions
            WHERE id = '".$aid."')";
        $res = @mysql_query($query);

        $time = mktime(substr($_POST["a_starts"], 8, 2), substr($_POST["a_starts"], 10, 2), substr($_POST["a_starts"], 12, 2), substr($_POST["a_starts"], 4, 2), substr($_POST["a_starts"], 6, 2), substr($_POST["a_starts"], 0, 4));
        $a_starts = date("YmdHis", strtotime($_POST["a_starts"]));

		//$a_ends = strtotime($_POST["a_starts"]) + $_POST["duration"] * 24 * 60 * 60+$_POST["duration_hours"]*60*60+$_POST["duration_minutes"]*60;
        //$a_ends = date("YmdHis", $a_ends); // we want auction end time will be at first second
		
        $last_id=mysql_insert_id();
        $query="UPDATE HB_auctions SET
            starts='".$a_starts."',
            bid_value='".$bid_value."',
			number_of_bids='".$number_of_bids."',
            closed=0,
            suspended=0,
            is_main_auction=0
            WHERE id='".$last_id."'";
        
        
        $res = @mysql_query($query);
        echo "<center><div class='default_class_ok_message'>Clone was created successfully</div></center>";
        
        echo "<script>
            window.opener.location='listallauctions.php';
            setTimeout('window.close()',2000);
            </script>";
    } else {

################################################################################
## +---------------------------------------------------------------------------+
## | 1. Creating & Calling:                                                    | 
## +---------------------------------------------------------------------------+
##  *** define a relative (virtual) path to datagrid.class.php file and "pear" 
##  *** directory (relatively to the current file)
##  *** RELATIVE PATH ONLY ***

  define ("DATAGRID_DIR", "../datagrid/");                     /* Ex.: "datagrid/" */ 
  define ("PEAR_DIR", "../datagrid/pear/");                    /* Ex.: "datagrid/pear/" */

  require_once(DATAGRID_DIR.'datagrid.class.php');
  require_once(PEAR_DIR.'PEAR.php');
  require_once(PEAR_DIR.'DB.php');
#
#  *** creating variables that we need for database connection 
  $DB_USER=$DbUser;            /* usually like this: prefix_name             */
  $DB_PASS=$DbPassword;                /* must be already enscrypted (recommended)   */
  $DB_HOST=$DbHost;       /* usually localhost                          */
  $DB_NAME=$DbDatabase;          /* usually like this: prefix_dbName           */

  ob_start();
#  *** (example of ODBC connection string)
#  *** $result_conn = $db_conn->connect(DB::parseDSN('odbc://root:12345@test_db'));
#  *** (example of Oracle connection string)
#  *** $result_conn = $db_conn->connect(DB::parseDSN('oci8://root:12345@localhost:1521/mydatabase)); 
#  *** (example of PostgreSQL connection string)
#  *** $result_conn = $db_conn->connect(DB::parseDSN('pgsql://root:12345@localhost/mydatabase)); 
#  === (Examples of connections to other db types see in "docs/pear/" folder)
  $db_conn = DB::factory('mysql');  /* don't forget to change on appropriate db type */
  $result_conn = $db_conn->connect(DB::parseDSN('mysql://'.$DB_USER.':'.$DB_PASS.'@'.$DB_HOST.'/'.$DB_NAME));
  if(DB::isError($result_conn)){ die($result_conn->getDebugInfo()); }  
#  *** put a primary key on the first place 
  $sql = "SELECT
              a.id,
              a.title,
              CASE
                WHEN a.auction_type=1 THEN 'Classic'
                WHEN a.auction_type=2 THEN 'Extended'
                WHEN a.auction_type=3 THEN 'Extended Reverse'
              END AS type,
              CONCAT(SUBSTRING(a.starts,1,4),'/',SUBSTRING(a.starts,5,2),'/',SUBSTRING(a.starts,7,2),' ',SUBSTRING(a.starts,9,2),':',SUBSTRING(a.starts,11,2)) AS starts,
              CONCAT(SUBSTRING(a.ends,1,4),'/',SUBSTRING(a.ends,5,2),'/',SUBSTRING(a.ends,7,2),' ',SUBSTRING(a.ends,9,2),':',SUBSTRING(a.ends,11,2)) AS ends,
              a.closed,
              a.suspended,
              'Users offers' AS users_link,
                'Create clone' AS clone_link
            FROM HB_auctions a";

#  *** set needed options and create a new class instance 
  $debug_mode = false;        /* display SQL statements while processing */    
  $messaging = false;          /* display system messages on a screen */ 
  $unique_prefix = "all_";    /* prevent overlays - must be started with a letter */
  $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
#  *** set data source with needed options
  $default_order_field = "title";
  $default_order_type = "ASC";
  $dgrid->dataSource($db_conn, $sql, $default_order_field, $default_order_type);	    
#
#
## +---------------------------------------------------------------------------+
## | 2. General Settings:                                                      | 
## +---------------------------------------------------------------------------+
##  *** set encoding and collation (default: utf8/utf8_unicode_ci)
// $dg_encoding = "utf8";
// $dg_collation = "utf8_unicode_ci";
// $dgrid->setEncoding($dg_encoding, $dg_collation);
##  *** set interface language (default - English)
##  *** (en) - English     (de) - German     (se) - Swedish   (hr) - Bosnian/Croatian
##  *** (hu) - Hungarian   (es) - Espanol    (ca) - Catala    (fr) - Francais
##  *** (nl) - Netherlands/"Vlaams"(Flemish) (it) - Italiano  (pl) - Polish
##  *** (ch) - Chinese     (sr) - Serbian    (bg) - Bulgarian (pb) - Brazilian Portuguese
##  *** (ar) - Arabic      (tr) - Turkish    (cz) - Czech
 $dg_language = "en";
 $dgrid->setInterfaceLang($dg_language);
##  *** set direction: "ltr" or "rtr" (default - "ltr")
 $direction = "ltr";
 $dgrid->setDirection($direction);
##  *** set layouts: "0" - tabular(horizontal) - default, "1" - columnar(vertical), "2" - customized 
/// $layouts = array("view"=>"0", "edit"=>"1", "details"=>"1", "filter"=>"1"); 
/// $dgrid->setLayouts($layouts);
/// $details_template = "<table><tr><td>{field_name_1}</td><td>{field_name_2}</td></tr>...</table>";
/// $dgrid->setTemplates("","",$details_template);
##  *** set modes for operations ("type" => "link|button|image") 
##  *** "byFieldValue"=>"fieldName" - make the field to be a link to edit mode page
 $modes = array(
     "add"	   =>array("view"=>false, "edit"=>false, "type"=>"link"),
     "edit"	   =>array("view"=>false, "edit"=>false,  "type"=>"link", "byFieldValue"=>""),
     "cancel"  =>array("view"=>false, "edit"=>false,  "type"=>"link"),
     "details" =>array("view"=>false, "edit"=>false, "type"=>"link"),
     "delete"  =>array("view"=>false, "edit"=>false,  "type"=>"image")
 );
 $dgrid->setModes($modes);
//##  *** allow scrolling on datagrid
// $scrolling_option = false;
// $dgrid->allowScrollingSettings($scrolling_option);  
##  *** set scrolling settings (optional)
/// $scrolling_width = "90%";
/// $scrolling_height = "100%";
/// $dgrid->setScrollingSettings($scrolling_width, $scrolling_height);
##  *** allow mulirow operations
//  $multirow_option = true;
//  $dgrid->allowMultirowOperations($multirow_option);
/// $multirow_operations = array(
///     "delete"  => array("view"=>true),
///     "details" => array("view"=>true),
///     "my_operation_name" => array("view"=>true, "flag_name"=>"my_flag_name", "flag_value"=>"my_flag_value", "tooltip"=>"Do something with selected", "image"=>"image.gif")
/// );
/// $dgrid->setMultirowOperations($multirow_operations);  
##  *** set CSS class for datagrid
##  *** "default" or "blue" or "gray" or "green" or "pink" or your own css file 
/// $css_class = "default";
/// $dgrid->setCssClass($css_class);
##  *** set variables that used to get access to the page (like: my_page.php?act=34&id=56 etc.) 
 $http_get_vars = array("id");
 $dgrid->setHttpGetVars($http_get_vars);
##  *** set other datagrid/s unique prefixes (if you use few datagrids on one page)
##  *** format (in which mode to allow processing of another datagrids)
##  *** array("unique_prefix"=>array("view"=>true|false, "edit"=>true|false, "details"=>true|false));
/// $anotherDatagrids = array("abcd_"=>array("view"=>true, "edit"=>true, "details"=>true));
/// $dgrid->setAnotherDatagrids($anotherDatagrids);  
##  *** set DataGrid caption
 //$dg_caption = "Il tuo Offerte";
 //$dgrid->setCaption($dg_caption);
##
##
## +---------------------------------------------------------------------------+
## | 3. Printing & Exporting Settings:                                         | 
## +---------------------------------------------------------------------------+
##  *** set printing option: true(default) or false 
 $printing_option = false;
 $dgrid->allowPrinting($printing_option);
#  *** set exporting option: true(default) or false and relative (virtual) path
#  *** to export directory (relatively to datagrid.class.php file).
#  *** Ex.: "" - if we use current datagrid folder
 $exporting_option = false;
 $exporting_directory = "";               
 $dgrid->allowExporting($exporting_option, $exporting_directory);
##
##
## +---------------------------------------------------------------------------+
## | 4. Sorting & Paging Settings:                                             | 
## +---------------------------------------------------------------------------+
##  *** set sorting option: true(default) or false 
 $sorting_option = true;
 $dgrid->allowSorting($sorting_option);               
##  *** set paging option: true(default) or false 
 $paging_option = true;
 $rows_numeration = false;
 $numeration_sign = "N #";
 $dgrid->allowPaging($paging_option, $rows_numeration, $numeration_sign);
##  *** set paging settings
 $bottom_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", "page_size"=>true, "page_size_align"=>"right");
 //$top_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", "page_size"=>true, "page_size_align"=>"right");
 $top_paging = array();
 $pages_array = array("10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100");
 $default_page_size = 10;
 $paging_arrows = array("first"=>"|&lt;&lt;", "previous"=>"&lt;&lt;", "next"=>"&gt;&gt;", "last"=>"&gt;&gt;|");
 $dgrid->setPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
##
##
## +---------------------------------------------------------------------------+
## | 5. Filter Settings:                                                       | 
## +---------------------------------------------------------------------------+
##  *** set filtering option: true or false(default)
 //$filtering_option = true;
 //$show_search_type = true;
 //$dgrid->allowFiltering($filtering_option, $show_search_type);
##  *** set aditional filtering settings
// $fill_from_array1 = array("2"=>"Revolution", "3"=>"Revolution Rebuy");  /* as "value"=>"option" */
// $fill_from_array2 = array("1"=>"pending", "2"=>"open", "3"=>"closed");  /* as "value"=>"option" */
// $filtering_fields = array(
/////     "Caption_2"=>array("table"=>"tableName_2", "field"=>"fieldName_2", "source"=>"self"|$fill_from_array, "show_operator"=>false|true, "default_operator"=>"=|<|>|like|%like|like%|%like%|not like", "order"=>"ASC|DESC (optional)", "type"=>"textbox|dropdownlist|calendar", "case_sensitive"=>false|true, "comparison_type"=>"string|numeric|binary", "on_js_event"=>""),
/////     "Caption_3"=>array("table"=>"tableName_3", "field"=>"fieldName_3", "source"=>"self"|$fill_from_array, "show_operator"=>false|true, "default_operator"=>"=|<|>|like|%like|like%|%like%|not like", "order"=>"ASC|DESC (optional)", "type"=>"textbox|dropdownlist|calendar", "case_sensitive"=>false|true, "comparison_type"=>"string|numeric|binary", "on_js_event"=>""),
// );
// $dgrid->setFieldsFiltering($filtering_fields);
##
## 
## +---------------------------------------------------------------------------+
## | 6. View Mode Settings:                                                    | 
## +---------------------------------------------------------------------------+
##  *** set view mode table properties
 $vm_table_properties = array("width"=>"80%");
 $dgrid->setViewModeTableProperties($vm_table_properties);  
##  *** set columns in view mode
##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
##  ***      "barchart" : number format in SELECT SQL must be equal with number format in max_value
 $vm_colimns = array(
    "title"     =>array("header"=>"Title",    "type"=>"label", "align"=>"left", "width"=>"",        "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true,  "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
    "type"      =>array("header"=>"Type",      "type"=>"label", "align"=>"left", "width"=>"",        "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true,  "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
    "starts"    =>array("header"=>"Starts",    "type"=>"label", "align"=>"center", "width"=>"",      "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true,  "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
    "ends"      =>array("header"=>"Ends",   "type"=>"label", "align"=>"center", "width"=>"",      "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true,  "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
    "closed"    =>array("header"=>"Closed", "type"=>"label", "align"=>"center", "width"=>"",      "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true,  "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
    "suspended" =>array("header"=>"Suspended",   "type"=>"label", "align"=>"center", "width"=>"",      "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true,  "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),    
    "users_link"=>array("header"=>"&nbsp;",    "type"=>"link",  "align"=>"center", "width"=>"100px", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>false, "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"id", "field_data"=>"users_link", "rel"=>"", "title"=>"", "target"=>"", "href"=>"auction_users.php?aid={0}"),
    "clone_link"=>array("header"=>"&nbsp;",    "type"=>"link",  "align"=>"center", "width"=>"100px", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>false, "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"id", "field_key_1"=>"title","field_data"=>"clone_link", "rel"=>"", "title"=>"", "target"=>"", "href"=>"javascript:open_email_text({0},\"{1}\")"),
    //"nick"    =>array("header"=>"Utente",   "type"=>"label", "align"=>"center", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true,  "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
    //"offers"  =>array("header"=>"Offerte", "type"=>"label", "align"=>"center", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>false, "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
    //"offers_link" =>array("header"=>"&nbsp;", "type"=>"link",       "align"=>"center", "width"=>"150px", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>false, "tooltip_type"=>"floating|simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"user_id", "field_key_1"=>"auction_id", "field_data"=>"offers_link", "rel"=>"", "title"=>"", "target"=>"", "href"=>"users_signed_bids.php?uid={0}&aid={1}"),
    //"offers_link"=>array("header"=>"&nbsp;", "type"=>"linktoview", "align"=>"center", "width"=>"150px", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
     
     //"FieldName_3"=>array("header"=>"Name_C", "type"=>"linktoview", "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower", "summarize"=>"true|false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
     //"FieldName_3"=>array("header"=>"Name_C", "type"=>"linktoedit", "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower", "summarize"=>"true|false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),

     //"FieldName_4"=>array("header"=>"Name_D", "type"=>"link",       "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower", "summarize"=>"true|false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"field_name_0"|"field_key_1"=>"field_name_1"|..., "field_data"=>"field_name_2", "rel"=>"", "title"=>"", "target"=>"_new", "href"=>"{0}"),
     //"FieldName_5"=>array("header"=>"Name_E", "type"=>"link",       "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower", "summarize"=>"true|false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"field_name_0"|"field_key_1"=>"field_name_1"|..., "field_data"=>"field_name_2", "rel"=>"", "title"=>"", "target"=>"_new", "href"=>"mailto:{0}"),
     //"FieldName_6"=>array("header"=>"Name_F", "type"=>"link",       "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower", "summarize"=>"true|false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"field_name_0"|"field_key_1"=>"field_name_1"|..., "field_data"=>"field_name_2", "rel"=>"", "title"=>"", "target"=>"_new", "href"=>"http://mydomain.com?act={0}&act={1}&code=ABC"),

     //"FieldName_7"=>array("header"=>"Name_G", "type"=>"password",   "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower", "summarize"=>"true|false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
     //"FieldName_8"=>array("header"=>"Name_H", "type"=>"barchart",   "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower", "summarize"=>"true|false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field"=>"field_name", "maximum_value"=>"value"),
 );
 $dgrid->setColumnsInViewMode($vm_colimns);
##  *** set auto-genereted columns in view mode
  //$auto_column_in_view_mode = true;
  //$dgrid->setAutoColumnsInViewMode($auto_column_in_view_mode);
##
##
## +---------------------------------------------------------------------------+
## | 7. Add/Edit/Details Mode Settings:                                        | 
## +---------------------------------------------------------------------------+
##  *** set add/edit mode table properties
// $em_table_properties = array("width"=>"70%");
// $dgrid->setEditModeTableProperties($em_table_properties);
////##  *** set details mode table properties
//// $dm_table_properties = array("width"=>"60%");
//// $dgrid->setDetailsModeTableProperties($dm_table_properties);
////##  ***  set settings for add/edit/details modes
//  $table_name  = "HB_bids";
//  $primary_key = "id";
//  $condition   = "bidder = ".$user_id;
//  $condition   = "";
//  $dgrid->setTableEdit($table_name, $primary_key, $condition);
##  *** set columns in edit mode
##  *** first letter:  r - required, s - simple (not required)
##  *** second letter: t - text(including datetime), n - numeric, a - alphanumeric,
##                     e - email, f - float, y - any, l - login name, z - zipcode,
##                     p - password, i - integer, v - verified, c - checkbox, u - URL
##  *** third letter (optional): 
##          for numbers: s - signed, u - unsigned, p - positive, n - negative
##          for strings: u - upper,  l - lower,    n - normal,   y - any
##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
##  *** Ex.: type = textbox|textarea|label|date(yyyy-mm-dd)|datedmy(dd-mm-yyyy)|datetime(yyyy-mm-dd hh:mm:ss)|datetimedmy(dd-mm-yyyy hh:mm:ss)|time(hh:mm:ss)|image|password|enum|print|checkbox
##  *** make sure your WYSIWYG dir has 777 permissions
/// $fill_from_array = array("0"=>"No", "1"=>"Yes", "2"=>"Don't know", "3"=>"My be"); /* as "value"=>"option" */
 //$em_columns = array(
 //    "bid"    =>array("header"=>"Bid", "type"=>"textbox", "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
 //    "pict_url" =>array("header"=>"Imaggine", "type"=>"image",  "req_type"=>"st", "width"=>"220px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"uploaded/", "max_file_size"=>"10M", "image_width"=>"70px", "image_height"=>"70px", "file_name"=>"", "host"=>"local"),
///     "FieldName_2"  =>array("header"=>"Name_B", "type"=>"textarea",  "req_type"=>"rt", "width"=>"210px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "edit_type"=>"simple|wysiwyg", "resizable"=>"false", "rows"=>"7", "cols"=>"50"),
///     "FieldName_3"  =>array("header"=>"Name_C", "type"=>"label",     "req_type"=>"rt", "width"=>"210px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
///     "FieldName_4"  =>array("header"=>"Name_D", "type"=>"date",      "req_type"=>"rt", "width"=>"187px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "calendar_type"=>"popup|floating"),
///     "FieldName_5"  =>array("header"=>"Name_E", "type"=>"datetime",  "req_type"=>"st", "width"=>"187px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "calendar_type"=>"popup|floating"),
///     "FieldName_6"  =>array("header"=>"Name_F", "type"=>"time",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
///     "FieldName_7"  =>array("header"=>"Name_G", "type"=>"image",     "req_type"=>"st", "width"=>"220px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"uploads/", "max_file_size"=>"100000|100K|10M|1G", "image_width"=>"Xpx", "image_height"=>"Ypx", "file_name"=>"Image_Name", "host"=>"local|remote"),
///     "FieldName_8"  =>array("header"=>"Name_H", "type"=>"password",  "req_type"=>"rp", "width"=>"210px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
///     "FieldName_9"  =>array("header"=>"Name_I", "type"=>"enum",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "source"=>"self"|$fill_from_array, "view_type"=>"dropdownlist(default)|radiobutton", "radiobuttons_alignment"=>"horizontal|vertical", "multiple"=>false, "multiple_size"=>"4"),
///     "FieldName_10" =>array("header"=>"Name_J", "type"=>"print",     "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
///     "FieldName_11" =>array("header"=>"Name_K", "type"=>"checkbox",  "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "true_value"=>1, "false_value"=>0),
///     "FieldName_12" =>array("header"=>"Name_L", "type"=>"file",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"uploads/", "max_file_size"=>"100000|100K|10M|1G", "file_name"=>"File_Name", "host"=>"local|remote"),
///     "FieldName_13" =>array("header"=>"Name_M", "type"=>"link",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"field_name_0"|"field_key_1"=>"field_name_1"|..., "field_data"=>"field_name_2", "target"=>"_new", "href"=>"http://mydomain.com?act={0}&act={1}&code=ABC"),
///     "FieldName_14" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>"default_value", "visible"=>"true", "unique"=>false|true),
///     "validator"    =>array("header"=>"Name_N", "type"=>"validator", "req_type"=>"rv", "width"=>"210px", "title"=>"", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "visible"=>"true", "on_js_event"=>"", "for_field"=>"", "validation_type"=>"password|email"),
///     "delimiter"    =>array("inner_html"=>"<br />"),
 //);
 //$dgrid->setColumnsInEditMode($em_columns);
##  *** set auto-genereted columns in edit mode
/// $auto_column_in_edit_mode = true;
///  $dgrid->setAutoColumnsInEditMode($auto_column_in_edit_mode);
##  *** set foreign keys for add/edit/details modes (if there are linked tables)
##  *** Ex.: "condition"=>"TableName_1.FieldName > 'a' AND TableName_1.FieldName < 'c'"
##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
/// $foreign_keys = array(
///     "ForeignKey_1"=>array("table"=>"TableName_1", "field_key"=>"FieldKey_1", "field_name"=>"FieldName_1", "view_type"=>"dropdownlist(default)|radiobutton|textbox", "radiobuttons_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"My_Field_Name", "order_type"=>"ASC|DESC", "on_js_event"=>""),
///     "ForeignKey_2"=>array("table"=>"TableName_2", "field_key"=>"FieldKey_2", "field_name"=>"FieldName_2", "view_type"=>"dropdownlist(default)|radiobutton|textbox", "radiobuttons_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"My_Field_Name", "order_type"=>"ASC|DESC", "on_js_event"=>"")
/// ); 
/// $dgrid->setForeignKeysEdit($foreign_keys);
##
##
## +---------------------------------------------------------------------------+
## | 8. Bind the DataGrid:                                                     | 
## +---------------------------------------------------------------------------+
##  *** bind the DataGrid and draw it on the screen
  $dgrid->bind();        
  ob_end_flush();
    }
##
################################################################################   
?>

<?
  //if($user_id != ""){
  //  echo "<center><a class='default_class_a' href='users_signed.php?id=".$auction_id."'>Parte posteriore</a></center>";    
  //}else{
  //  echo "<center><a class='default_class_a' href='listauctions.php'>Parte posteriore</a></center>";    
  //}
?>
<script>
function open_email_text(id,title) {
	window.open("clone.php?id="+id+"&title="+title,"","scrollbars=yes,menubar=yes,height=200,width=400,resizable=yes,toolbar=no,location=no,status=no");
}
</script>
</BODY>
</HTML>