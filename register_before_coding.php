<?
include "./includes/config.inc.php";

include $include_path."countries.inc.php";
include $include_path."checkage.inc.php";
include $include_path."cc.inc.php";
include $include_path."banemails.inc.php";




$is_pre_registration = (isset($_REQUEST['pre_registration']) && $_REQUEST['pre_registration'] == "1") ? "1" : "";

$TIME = mktime(date("H")+$SETTINGS['timecorrection'],date("i"),date("s"),date("m"), date("d"),date("Y"));
$NOW = date("YmdHis",$TIME);
$NOWB = date("YmdHis",$TIME);
// --
if (!isset($_POST['auction_id']) && !isset($_GET['auction_id'])) {
    $auction_id = $_SESSION["CURRENT_ITEM"];
} else {
    $_SESSION["CURRENT_ITEM"]=intval($auction_id);
}
if (empty($_POST['action'])) {
    $action = "first";
}
#// Retrieve users signup settings
$query = "SELECT * FROM HB_usersettings";
$res_s = @mysql_query($query);
if(!$res_s){
    MySQLError($query);
    exit;
}else{
    $REQUESTED_FIELDS = unserialize(mysql_result($res_s,0,"requested_fields"));
    $MANDATORY_FIELDS = unserialize(mysql_result($res_s,0,"mandatory_fields"));
}



if ($_POST['action'] == "first") {

    if (empty($_POST['accounttype']) && $SETTINGS['accounttype'] == 'sellerbuyer') {
        $TPL_err = 1;
        $TPL_errmsg = $MSG_25_0137;
    } elseif (empty($_POST['TPL_name'])) {
        $TPL_err = 1;
        $TPL_errmsg = $ERR_5029;
    } elseif (empty($_POST['TPL_nick'])) {
        $TPL_err = 1;
        $TPL_errmsg = $ERR_5030;
    } elseif (empty($_POST['TPL_password'])) {
        $TPL_err = 1;
        $TPL_errmsg = $ERR_5031;
    } elseif (empty($_POST['TPL_repeat_password'])) {
        $TPL_err = 1;
        $TPL_errmsg = $ERR_5032;
    } elseif (empty($_POST['TPL_email'])) {
        $TPL_err = 1;
        $TPL_errmsg = $ERR_5033;
    } elseif (empty($_POST['TPL_address'])) {
        $TPL_err = 1;
        $TPL_errmsg = $ERR_5034;
    } elseif (empty($_POST['TPL_city'])) {
        $TPL_err = 1;
        $TPL_errmsg = $ERR_5035;
    } elseif (empty($_POST['TPL_prov'])) {
        $TPL_err = 1;
        $TPL_errmsg = $ERR_5036;
    } elseif (empty($_POST['TPL_country'])) {
        $TPL_err = 1;
        $TPL_errmsg = $ERR_5037;
    } elseif (empty($_POST['TPL_zip'])) {
        $TPL_err = 1;
        $TPL_errmsg = $ERR_5038;
    } elseif (empty($_POST['TPL_phone'])) {
        $TPL_err = 1;
        $TPL_errmsg = $ERR_5039;
    } elseif (empty($_POST['TPL_birthdate'])) {
        $TPL_err = 1;
        $TPL_errmsg = $ERR_5040;
    } else {
        // -- Explode birthdate into DAY MONTH YEAR
        if(!empty($_POST[TPL_birthdate])){
            $DATE = explode("/", $_POST['TPL_birthdate']);
            if($SETTINGS[datesformat] == "USA") {
                $birth_day = $DATE[1];
                $birth_month = $DATE[0];
                $birth_year = $DATE[2];
            } else {
                $birth_day = $DATE[0];
                $birth_month = $DATE[1];
                $birth_year = $DATE[2];
            }
            $DATE = "$birth_year$birth_month$birth_day";
        }else{
            $DATE = 0;
        }
        
        $VALIDCARD = ValidateCC($_POST[TPL_cc]);
        if ($VALIDCARD != "" && $SETTINGS['userscreditcard'] == 'y' && $Https['https'] == 'yes') {
            $TPL_err = 1;
            $TPL_errmsg = $$VALIDCARD;
        } elseif ((!ereg("^[0-9]{2}$", $_POST['TPL_exp_month']) || !ereg("^[0-9]{2}$", $_POST['TPL_exp_year'])) && $SETTINGS['userscreditcard'] == 'y' && $Https['https'] == 'yes') {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_5012;
        } elseif (empty($_POST['TPL_card_owner']) && $SETTINGS['userscreditcard'] == 'y' && $Https['https'] == 'yes') {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_5013;
        } elseif (empty($_POST['TPL_card_zip']) && $SETTINGS['userscreditcard'] == 'y' && $Https['https'] == 'yes') {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_5015;
        } elseif (strlen($_POST['TPL_nick']) < 6) {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_107;
        } else if (strlen ($_POST['TPL_password']) < 6) {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_108;
        } else if ($_POST['TPL_password'] != $_POST['TPL_repeat_password']) {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_109;
        } else if (strlen($_POST['TPL_email']) < 5) { // Primitive mail check
        $TPL_err = 1;
        $TPL_errmsg = $ERR_110;
        } else if (!ereg("^[0-9]{2}/[0-9]{2}/[0-9]{4}$", $_POST['TPL_birthdate'])  && $MANDATORY_FIELDS['birthdate']=='y') { // Birthdate check
        $TPL_err = 1;
        $TPL_errmsg = $ERR_043;
        } elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$", $_POST['TPL_email'])) {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_008;
        } else if (!CheckAge($birth_day, $birth_month, $birth_year) && $MANDATORY_FIELDS['birthdate']=='y') {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_113;
        }elseif(BannedEmail($_POST['TPL_email'],$BANNEDDOMAINS)){
            $TPL_err = 1;
            $TPL_errmsg = $MSG_30_0054;
        } else {
            $sql = "SELECT nick FROM HB_users WHERE nick=\"" . AddSlashes ($_POST['TPL_nick']) . "\"";
            $res = mysql_query ($sql);
            if (mysql_num_rows($res) == 0) {
                $id = md5(uniqid(rand()));
                $id = eregi_replace("[a-f]", "", $id);
                
                $TPL_id_hidden = $id;
                $TPL_nick_hidden = $_POST['TPL_nick'];
                $TPL_password_hidden = $_POST['TPL_password'];
                $TPL_name_hidden = $_POST['TPL_name'];
                $TPL_email_hidden = $_POST['TPL_email'];
            } else {
                $TPL_err = 1;
                $TPL_errmsg = $ERR_111; // Selected user already exists
            }
            
            $sql = "SELECT email FROM HB_users WHERE email=\"" . AddSlashes ($_POST['TPL_email']) . "\"";
            $res = mysql_query ($sql);
            if (mysql_num_rows($res) == 0) {
                $id = md5(uniqid(rand()));
                // $id = eregi_replace("[a-f]","",$id);
                $TPL_id_hidden = $id;
                $TPL_nick_hidden = $_POST['TPL_nick'];
                $TPL_password_hidden = $_POST['TPL_password'];
                $TPL_name_hidden = $_POST['TPL_name'];
                $TPL_email_hidden = $_POST['TPL_email'];
            } else {
                $TPL_err = 1;
                $TPL_errmsg = $ERR_115; // E-mail already used
            }
            
            if ($TPL_err == 0) {
                $TODAY = $NOWB;
                # // #################################################################
                # // Users suspended field
                # // VALUES:
                # //        9 - sign up fee due
                # //         8 - no fee due, waiting for user's confirmation
                # //            1 - suspended by the administrator via admin utility
                # //
                $SUSPENDED = 8;
                if (!empty($_POST[TPL_cc])) {
                    $CC = $_POST[TPL_cc];
                } else {
                    $CC = '';
                }
                if($SETTINGS['accounttype'] == 'sellerbuyer') {
                    $selected_accounttype = $_POST['accounttype'];
                } else {
                    $selected_accounttype = 'unique';
                }
                
                if($is_pre_registration != ""){
                    $user_pre_registration = "1";
                }else{
                    $user_pre_registration = "0";
                    //, is_pre_registration
                    //, ".intval($user_pre_registration)."
                }
                
                $sql = "INSERT INTO HB_users (id,
                        nick, password, name, address, city, prov,
                        country, zip, phone, nletter,email, reg_date,
                        rate_sum,  rate_num, birthdate,suspended,
                        creditcard,exp_month,exp_year,card_owner,card_zip,accounttype)
                          VALUES (NULL, \"" . Addslashes ($TPL_nick_hidden) . "\", \""
                      . md5($MD5_PREFIX . Addslashes ($TPL_password_hidden)) . "\", \""
                      . Addslashes ($TPL_name_hidden) . "\", \""
                        . AddSlashes ($_POST['TPL_address']) . "\", \""
                        . AddSlashes ($_POST['TPL_city']) . "\", \""
                        . AddSlashes ($_POST['TPL_prov']) . "\", \""
                        . AddSlashes ($_POST['TPL_country']) . "\", \""
                        . AddSlashes ($_POST['TPL_zip']) . "\", \""
                        . AddSlashes ($_POST['TPL_phone']) . "\", \""
                        . AddSlashes ($_POST['TPL_nletter']) . "\", \""
                        . AddSlashes ($_POST['TPL_email']) . "\",
                      '$TODAY',
                      0,
                      0,
                      '$DATE',
                      '$SUSPENDED',
                      ENCODE(\"$CC\",\"$MD5_PREFIX\"),
                        '$_POST[TPL_exp_month]','$_POST[TPL_exp_year]','$_POST[TPL_card_owner]','$_POST[TPL_card_zip]','$selected_accounttype')";
                $res = mysql_query ($sql);
                if ($res == 0) {
                    $TPL_err = 1;
                    $TPL_errmsg = mysql_error (); //"Error updating users data";
                } else {
                    $TPL_id_hidden=mysql_insert_id();
                    # // ===========================================================
                    # // Added by Gian for IP banning
                    # // Store user IP address in the database
                    # // ===========================================================
                    $query = "INSERT INTO HB_usersips VALUES(
                              NULL,
                              ".intval($TPL_id_hidden).",
                              '".$_SERVER["REMOTE_ADDR"]."',
                              'first','accept')";
                    $res___ = @mysql_query($query);
                    if (!$res___) {
                        MySQLError($query);
                        exit;
                    }
                    # // ===========================================================
                    /**
                    * Update column users in table HB_counters
                    */
                    $query = "UPDATE HB_counters SET inactiveusers=inactiveusers+1";
                    $counteruser = mysql_query($query);
                    if (!$counteruser) {
                        MySQLError($query);
                        exit;
                    }
                    # // ===========================================================
                    /**
                    * Set up the language of this user in table HB_userslanguage
                    */
                    $language = $SETTINGS['defaultlanguage'];
                    $_SESSION['language'] = $language;
                    $userlanguage = mysql_query("INSERT INTO HB_userslanguage VALUES(
                                         '".$TPL_id_hidden."',
                                         '$language')");
                    if (!$userlanguage) {
                        MySQLError($query);
                        exit;
                    }
                    # // Send confirmation e-mail message depending on the peyment settings
                    #// and the signup confirmation settings
                    //if ($SETTINGS['signupfee'] != 1) {
 //                       if(($SETTINGS['usignupconfirmation'] == 'y' && $SETTINGS['accounttype'] == 'unique') || 
 //                          (($SETTINGS['sbsignupconfirmation'] == 's' || $SETTINGS['sbsignupconfirmation'] == 'sb') && $_POST['accounttype'] == 'seller') ||
 //                          (($SETTINGS['sbsignupconfirmation'] == 'b' || $SETTINGS['sbsignupconfirmation'] == 'sb') && $_POST['accounttype'] == 'buyer')) {
                            #Suspend user
                    $query = "UPDATE HB_users SET suspended=0,reg_date=reg_date WHERE id=$TPL_id_hidden";
                    $RES__ = @mysql_query($query);
                    if (!$RES__) {
                        echo "KLSDHD";
                        //MySQLError($query);
                        exit;
                    } else {
                        # Send e-mail to the user and the admin                    
                        include $include_path."user_confirmation_needapproval.inc.php";                        
                    }
//                        }else{
//                            include $include_path."user_confirmation.inc.php";
 //                       }
                    //}
                }
            } // if($TPL_err == 0)
        }
    }
}


include "header.php";
if (($action == "first" && count($_POST) == 0) || ($_POST['action'] == "first" && $TPL_err)) {
    $country = "";
    foreach ($countries as $key=>$name) {
        $country .= "<option value=\"$name\"";
        if ($name == $_POST['TPL_country']) {
            $country .= " selected";
        } elseif ($SETTINGS['defaultcountry'] == $name && !isset($TPL_err)) {
            $country .= " selected";
        }
        $country .= ">$name</option>\n";
    }
    include phpa_include("template_register_php.html");
}

if ($_POST['action'] == "first" && !$TPL_err) {
    # //
    include phpa_include("template_registered_php.html");
}
include "footer.php";
$TPL_err = 0;
$TPL_errmsg = "";
?>