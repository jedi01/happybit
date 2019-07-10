<?
require('./includes/config.inc.php');

#// Process delete
if($_GET["action"] == "delete") {
  unlink($image_upload_path.session_id()."/".$_SESSION["UPLOADED_PICTURES"][intval($_GET["img"])]);
  unset($_SESSION["UPLOADED_PICTURES"][intval($_GET["img"])]);
  unset($_SESSION["UPLOADED_PICTURES_SIZE"][intval($_GET["img"])]);
}

#// Create Gallery
#// PROCESS UPLOADED FILE
if(!empty($_POST["creategallery"])) {
  #//
  $_SESSION["GALLERY_UPDATED"] = true;

  print "<SCRIPT Language=Javascript>window.close()</SCRIPT>";
  exit;
}

#// PROCESS UPLOADED FILE
if($_POST["uploadpicture"] == $MSG_681) {
  if(!empty($_FILES["userfile"]["tmp_name"]) && $_FILES["userfile"]["tmp_name"] != "none") {
    if(!is_array($_SESSION["UPLOADED_PICTURES"])) $_SESSION["UPLOADED_PICTURES"] = array();
    if(!is_array($_SESSION["UPLOADED_PICTURES_SIZE"])) $_SESSION["UPLOADED_PICTURES_SIZE"] = array();

    if($_FILES["userfile"]["size"] > ($SETTINGS["maxpicturesize"] * 1024)) {
      $ERR = $ERR_709."&nbsp;".$SETTINGS["maxpicturesize"]."&nbsp;Kbytes";
    } elseif(!strpos($_FILES["userfile"]["type"],"gif") &&
         !strpos($_FILES["userfile"]["type"],"png") &&
         !strpos($_FILES["userfile"]["type"],"jpeg")) {
      $ERR = $ERR_710." (".$_FILES["userfile"]["type"].")";
    } elseif(in_array($_FILES["userfile"]["name"],$_SESSION["UPLOADED_PICTURES"])) {
      $ERR = $MGS_2__0054." (".$_FILES["userfile"]["name"].")";
    } else {
      #// Create a TMP directory for this session (if not already created)
      umask();
      if(!file_exists($image_upload_path.session_id())) {
        umask();
        mkdir($image_upload_path.session_id(),0777);
      }
      #// Move uploaded file into TMP directory
      move_uploaded_file($_FILES["userfile"]["tmp_name"],
                 $image_upload_path.session_id()."/".$_FILES["userfile"]["name"]);
      chmod($image_upload_path.session_id()."/".$_FILES["userfile"]["name"],0666);
      $fname = $image_upload_path.session_id()."/".$_FILES["userfile"]["name"];
      //include("resize.php");
      #//Populate arrays
      array_push($_SESSION["UPLOADED_PICTURES"],$_FILES["userfile"]["name"]);
      array_push($_SESSION["UPLOADED_PICTURES_SIZE"],filesize($fname));
    }
  }
}

?>
<HTML>
<HEAD>
<TITLE><? print $SETTINGS[sitename]?></TITLE>
<LINK REL='stylesheet' TYPE='text/css' HREF='<?=phpa_include("style.css")?>' />
</HEAD>

<BODY BGCOLOR="#FFFFFF">
<DIV CLASS="container">
<FORM NAME=upload ACTION=<?=basename($_SERVER["PHP_SELF"])?> METHOD=POST  ENCTYPE="multipart/form-data">
<TABLE CELLPADDING=3 CELLSPACING=0 BORDER=0 ALIGN=CENTER WIDTH=90%>
<TR>
  <TD BGCOLOR="<?=$FONTCOLOR[$SETTINGS[headercolor]]?>" COLSPAN=2>
      <B><?=$MSG_663?></B>
  </TD>
</TR>
<TR>
  <TD COLSPAN=2>
    <?
      print $MSG_673."&nbsp;".$SETTINGS[maxpictures]."&nbsp;".$MSG_674;
      if($SETTINGS[picturesgalleryfee] == 1 ) {
          print $MSG_675."&nbsp;".print_money($SETTINGS[picturesgalleryvalue])."&nbsp;".$MSG_676;
      }
      print "<BR>".$MSG_679;
    ?>
  </TD>
</TR>
<?
  if(!empty($ERR)) {
?>
  <TR>
    <TD class=errfont ALIGN=CENTER>
      <?=$ERR?>
    </TD>
  </TR>
<?
  }
?>

<?
  if(count($_SESSION["UPLOADED_PICTURES"]) < $SETTINGS[maxpictures]) {
?>
  <TR>
    <TD>
      1.<?=$MSG_680?>
      <BR>
      <INPUT TYPE=FILE NAME=userfile SIZE=15>
    </TD>
  </TR>
  <TR>
    <TD>
      2.<?=$MSG_681?>
      <BR>
      <INPUT TYPE="SUBMIT" NAME="uploadpicture" VALUE="<?=$MSG_681?>">
    </TD>
  </TR>
  <TR>
    <TD>
        <?=$MSG_682?>
    </TD>
  </TR>

<?
  } else {
?>
  <TR>
    <TD class=errfont ALIGN=CENTER>
      <?=$MSG_688."&nbsp;".$SETTINGS[maxpictures]."&nbsp;".$MSG_689?>
    </TD>
  </TR>
<?
  }
?>
</TABLE>
<BR>
<BR>
<CENTER>
<B><?=$MSG_687?></B>
</CENTER>
<TABLE CELLPADDING=3 CELLSPACING=0 BORDER=0 ALIGN=CENTER WIDTH=90%>
  <TR BGCOLOR="<?=$FONTCOLOR[$SETTINGS[headercolor]]?>">
    <TD WIDTH=55%>
      <B><?=$MSG_684?></B>
    </TD>
    <TD WIDTH=35%>
      <B><?=$MSG_685?></B>
    </TD>
    <TD WIDTH=10% ALIGN=CENTER>
      <B><?=$MSG_686?></B>
    </TD>
  </TR>
<?
  if(is_array($_SESSION["UPLOADED_PICTURES"])) {
    while(list($k,$v) = each($_SESSION["UPLOADED_PICTURES"])) {
  ?>
    <TD WIDTH=55%>
        <?=$v?>
    </TD>
    <TD WIDTH=35%>
        <?=$_SESSION["UPLOADED_PICTURES_SIZE"][$k]?>
    </TD>
    <TD WIDTH=10% ALIGN=CENTER>
        <A HREF="<?=basename($_SERVER["PHP_SELF"])?>?action=delete&img=<?=$k?>"><IMG SRC="images/trash.png" BORDER=0></A>
    </TD>
  </TR>
<?
    }
  }
?>
</TABLE>

<BR><BR>
<CENTER>
<INPUT TYPE="SUBMIT" NAME="creategallery" VALUE="<?=$MSG_683?>">
</CENTER>
</FORM>
<BR><BR>
<center>
<A HREF="javascript: window.close()"><?=$MSG_678?></A>
<BR>
</CENTER>
</div>
</BODY>
</HTML>