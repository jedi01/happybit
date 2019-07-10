<?

require('../includes/config.inc.php');
include "loggedin.inc.php";
  $limit = 20;
if(!$_GET[offset]) {
  $offset = 0;
} else {
  $offset = $_GET[offset];
}

$_SESSION['RETURN_LIST'] = 'listauctions.php';
$_SESSION['RETURN_LIST_OFFSET'] = intval($_GET['offset']);

// search (filter) records by users nick, payment date or payment type 
$search_nick = isset($_POST['search_text']) ? $_POST['search_text'] : "";
$search_type = isset($_POST['search_type']) ? $_POST['search_type'] : "";
$search_date = isset($_POST['search_date']) ? $_POST['search_date'] : "";

$search_user_id = "";
if(isset($_GET['id'])){  
  $search_user_id = isset($_GET['id']) ? $_GET['id'] : "";  
}

?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<script>
function validDate( strValue ) {
  var objRegExp = /^\d{4}(\/)\d{1,2}\1\d{1,2}$/
 
  //check to see if in correct format
  if(!objRegExp.test(strValue))
    return false; //doesn't match pattern, bad date

  return true;
}

    function submitSearch(){
        str_date = document.getElementById('search_date').value;
        if(!validDate(str_date) && str_date!=""){
            alert("The date must be in yyyy/mm/dd format!");
            return false;
        }
        document.getElementById('search').submit();
    }
</script>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="images/bac_barint.gif">
                <table width="100%" border="0" cellspacing="5" cellpadding="0">
                    <tr>
                        <td width="30"><img src="images/i_auc.gif" ></td>
                        <td class=white><?=$MSG_239?>&nbsp;&gt;&gt;&nbsp;<?=$MSG_31_0019; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="middle">
                <br />
                <? if($search_user_id == ""){ ?>
                <form name="search" id="search" action= "payments_history.php" method="post">
                    <input type=hidden name=search value="1">
                    <table width=90% border=0 cellpadding=0 cellspacing=0>
                        <tr>
                            <td align=left>
                                Nick <input type="text" name="search_text" id="search_text" value="<?=$search_nick;?>" style="width:80px;">
                            </td>
                            <td align=left>
                                Payment type <select name="search_type" id="search_type">
                                                <option value="" <?=(($search_type=="")?"selected":"")?>>All types</option>
                                                <option value="Account" <?=(($search_type=="Account")?"selected":"")?>>Account</option>
                                                <option value="Bank" <?=(($search_type=="Bank")?"selected":"")?>>Bank</option>
                                                <option value="PayPal" <?=(($search_type=="PayPal")?"selected":"")?>>PayPal</option>
                                            </select>
                            </td>
                            <td align=left>
                                Date <input type="text" name="search_date" id="search_date" style="width:80px;" value="<?=(($search_date!="")?$search_date:"")?>"> yyyy/mm/dd
                            </td>
                            <td align=right>
                                &nbsp;&nbsp;&nbsp;<input type="button" name="search" value="Search" onclick="submitSearch()" >
                            </td>
                        </tr>
                    </table>
                </form>
                <? } ?>
            </td>
        </tr>
        <tr>
            <td align="center" valign="middle">
                <TABLE WIDTH="750" BORDER="1" CELLSPACING="2" CELLPADDING="1" BGCOLOR="#546f95" ALIGN="CENTER" style="border-collapse:collapse;">
                    <TR>
                        <TD colspan=6 align="center" class=title><? print $MSG_31_0019; ?></TD>
                    </TR>
                    <TR BGCOLOR="#FFCC00">
                        <TD ALIGN=CENTER> <B> UserName </B>  </TD>
                        <TD ALIGN=CENTER> <B> Amount </B>  </TD>
                        <TD ALIGN=CENTER> <B> Payment Data </B>  </TD>
                        <TD ALIGN=CENTER> <B> Payment Type </B>  </TD>
                        <TD ALIGN=CENTER> <B> Description </B>  </TD>
                        <!--<TD ALIGN=CENTER> <B> id </B>  </TD>-->
                        <!--<TD ALIGN=CENTER> <B> user_id </B>  </TD>-->
                    </TR>             
                    <?                    
                    $query = "SELECT
                                a.id, a.user_id, a.amount, a.bonus, a.payment_date, a.payment_type,  a.description,
                                b.nick
                            FROM HB_payments a
                                INNER JOIN HB_users b ON a.user_id = b.id
                            WHERE 1=1
                            ".(($search_nick != "") ? " AND b.nick LIKE '".$search_nick."%' " : "")."
                            ".(($search_user_id != "") ? " AND b.id = ".intval($search_user_id)." " : "")."
                            ".(($search_type != "") ? " AND a.payment_type = '".$search_type."' " : "")."
                            ".(($search_date != "") ? " AND DATE_FORMAT(a.payment_date,'%Y/%m/%d') = DATE_FORMAT('".$search_date."', '%Y/%m/%d') " : "")."
                            ORDER BY a.payment_date DESC ";
                            
                    $limit_query = "SELECT
                                a.id,
                                a.user_id,
                                a.amount,
                                DATE_FORMAT(a.payment_date,'%Y/%m/%d %H:%i %p') AS payment_date,
                                a.payment_type,
                                a.description,
                                b.nick
                            FROM HB_payments a
                                INNER JOIN HB_users b ON a.user_id = b.id                            
                            WHERE 1=1
                            ".(($search_nick != "") ? " AND b.nick LIKE '".$search_nick."%' " : "")."
                            ".(($search_user_id != "") ? " AND b.id = ".intval($search_user_id)." " : "")."                        
                            ".(($search_type != "") ? " AND a.payment_type = '".$search_type."' " : "")."
                            ".(($search_date != "") ? " AND DATE_FORMAT(a.payment_date,'%Y/%m/%d') = DATE_FORMAT('".$search_date."', '%Y/%m/%d') " : "")."
                            ORDER BY payment_date DESC
                            LIMIT $offset, $limit";
                    //echo $limit_query;
                    $result = mysql_query($query);
                    $total_payments = mysql_num_rows($result);

                    $result = mysql_query($limit_query);
                    $num_payments = mysql_num_rows($result);
                    $i = 0;
                    $bgcolor = "#FFFFFF";
                    while($i < $num_payments){                        
                        if($bgcolor == "#FFFFFF"){
                            $bgcolor = "#EEEEEE";
                        }else{
                            $bgcolor = "#FFFFFF";
                        }
                        $id = mysql_result($result,$i,"id");
                        $user_id = mysql_result($result,$i,"user_id");
                        $amount = mysql_result($result,$i,"amount");
                        //$bonus = mysql_result($result,$i,"bonus");
                        $payment_date = mysql_result($result,$i,"payment_date");
                        $payment_type = mysql_result($result,$i,"payment_type");
                        $description = strip_tags(stripslashes(mysql_result($result,$i,"description")));
                        $user_name = mysql_result($result,$i,"nick");                    
                   ?>     
                    <TR BGCOLOR="#ffffff">
                        <TD align="center"><?=$user_name ;?></TD>
                        <TD align="center" ><?=$amount ;?></TD>
                        
                        <TD align="center" ><?=$payment_date ;?></TD>
                        <TD align="center" ><?=$payment_type ;?></TD>
                        <TD align="center"><?=$description ;?></TD>
                        <!--//<TD><?=$id ;?></TD>-->
                        <!--//<TD><?=$user_id ;?></TD>-->
                    </TR>
                    <?
                    $i++;
                    }?>
                </TABLE>
                <TABLE WIDTH=600 BORDER=0 CELLPADDING=4 CELLSPACING=0 ALIGN=CENTER>
                    <TR ALIGN=CENTER BGCOLOR=#FFFFFF>
                        <TD>
                            <SPAN CLASS="navigation">
                            <?
                            $num_pages = ceil($total_payments / $limit);
                            $i = 0;
                            while($i < $num_pages ){ 
                                $of = ($i * $limit);                            
                                if($of != $offset){
                                    print "<A HREF=\"payments_history.php?id=$search_user_id&offset=$of\" CLASS=\"navigation\">".($i + 1)."</A>";
                                    if($i != $num_pages) print " | ";
                                }else{
                                    print $i + 1;
                                    if($i != $num_pages) print " | ";
                                }                            
                                $i++;
                            }
                            ?>
                            </SPAN>
                        </TD>
                    </TR>
                    <!--<TR>
                        <TD>
                            <center><a class='default_class_a' href='javascript:history.go(-1)'>Parte posteriore</a></center>
                        </TD>
                    </TR>                    -->
                </TABLE>
            </td>
        </tr>
    </table>
</BODY>
</HTML>

