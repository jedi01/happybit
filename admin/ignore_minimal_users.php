<?

include "../includes/config.inc.php";
include "loggedin.inc.php";
include "../includes/countries.inc.php";

$auction_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";


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
    $act = isset($_GET['act']) ? $_GET['act'] : "";
    if(($act != "") && ($act == "ignore")){
        $sql = "UPDATE HB_auctions SET ignore_minimal_users = 1 WHERE id=".intval($auction_id)."";
        $res = mysql_query($sql);
    }else if(($act != "") && ($act == "unignore")){
        $sql = "UPDATE HB_auctions SET ignore_minimal_users = 0 WHERE id=".intval($auction_id)."";
        $res = mysql_query($sql);        
    }
    //echo mysql_error();
        
    $sql = "SELECT ignore_minimal_users FROM HB_auctions WHERE id=".intval($auction_id)."";
    $res = mysql_query($sql);
    $ignore_minimal_users = "";
    if($row=mysql_fetch_assoc($res)) {
        $ignore_minimal_users = $row['ignore_minimal_users'];
    }
    //echo mysql_error();
    
    
?>
<br><br><br>
<center>
<?
  if($ignore_minimal_users == "1"){
    echo "<h3>Enable minimum number of participants for starting auction option</h3><br />";
    echo "<input type='button' onclick='document.location.href=\"ignore_minimal_users.php?act=unignore&id=".$auction_id."\"' value='Submit'>";    
  }else{
    echo "<h3>Disable minimum number of participants option</h3><br />";
    echo "<input type='button' onclick='document.location.href=\"ignore_minimal_users.php?act=ignore&id=".$auction_id."\"' value='Submit'>";    
  }
?>
</center>    

</BODY>
</HTML>