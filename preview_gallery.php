<?#//v.3.0.0
include "includes/config.inc.php";
if(!defined('INCLUDED')) exit("Access denied");
?>
<HTML>
<BODY TOPMARGIN=0 LEFTMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<A HREF="Javascript:window.close()"><IMG SRC=<?=$uploaded_path.session_id()."/".$UPLOADED_PICTURES[$img]?> BORDER=0></A>
</BODY>
</HTML>
