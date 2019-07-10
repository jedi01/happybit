<?

    include "includes/config.inc.php";
?>
<HTML>
<HEAD>
<SCRIPT Language=Javascript>
function window_open(pagina,titulo,ancho,largo,x,y){

  var Ventana= 'toolbar=0,location=0,directories=0,scrollbars=0,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;
  open(pagina,titulo,Ventana);

}
</SCRIPT>

<BODY>
<link href="css/lightbox.css" rel="stylesheet" />
<?
    if(is_array($UPLOADED_PICTURES))
    {
  ?>


      <TABLE><TR>
  <?
       while(list($k,$v) = each($UPLOADED_PICTURES))
       {
			$k = htmlspecialchars($k);
			$v = addslashes(str_replace('..','',$v));
			$TMP = GetImageSize($uploaded_path.$GALLERY_DIR."/".$v);
			$WIDTH = (int)$TMP[0];
			$HEIGHT = (int)$TMP[1];		   
    ?>
           <TD><A HREF="javascript:window_open('view_gallery.php?img=<?=$k?>','perview',<?=$WIDTH?>,<?=$HEIGHT?>,0,0)"><IMG SRC="<?=$uploaded_path.$GALLERY_DIR.'/'.$v?>" BORDER=0 HEIGHT=100 HSPACE=10></TD>
    <?
       }
    ?>
    </TR></TABLE>
    <?
    }

?>
</BODY>
</HTML>