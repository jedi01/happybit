<?

require("includes/config.inc.php");

$emailaddress = $SETTINGS['adminmail'];
$cleanemail = str_replace("@", "[at]", $emailaddress);

switch($_GET["show"]) {
	case "aboutus":
	$TITLE = $MSG_5074;
	$CONTENT = stripslashes($SETTINGS['aboutustext']);
	break;
	case "terms":
	$TITLE = $MSG_5086;
	$CONTENT = stripslashes($SETTINGS['termstext']);
	break;
	case "howitworks":
	$TITLE = $MSG_31_0048;
	$CONTENT = stripslashes($SETTINGS['howitworkstext']);
	break;
        case "faq":
	$TITLE = "Contact us";
        $contact_help_text = "<br><font color='#333333' size='2' face='arial'>To contact us just send an email to <strong>" . $cleanemail . "</strong> and we'll get back to you as soon as possible.<br>Replace [at] with the @ symbol. This is to help prevent spam. </font><br><br>";
	$CONTENT = $contact_help_text . stripslashes($SETTINGS['faqtext']);
	break;
}

include "header.php";
include phpa_include("template_contents_php.html");
include "footer.php";
?>