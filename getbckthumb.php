<?	
function ErrorPNG($err)
{
	global $w,$h;
	$im  = imagecreate($w, $h); /* Create a blank image */
	$bgc = imagecolorallocate($im, 255, 255, 255);
	$tc  = imagecolorallocate($im, 0, 0, 0);
	imagefilledrectangle($im, 0, 0, $w, $h, $bgc);
	/* Output an errmsg */
	imagestring($im, 3, 5, 5, $err, $tc);
	return $im;
}
// control parameters and file existence
if(!isset($_GET['fromfile'])) {
	header("Content-type: image/png");
	echo imagepng(ErrorPNG("params empty"));
	exit;
} elseif (!file_exists($_GET['fromfile']))  {
	header("Content-type: image/png");
	echo imagepng(ErrorPNG("img doesn't exist"));
	exit;
}  elseif (!isset($_GET['brepeat']))  {
	header("Content-type: image/png");
	echo imagepng(ErrorPNG("specify a repeat mode"));
	exit;
}	
// try to see if it already exists a cached thumbnail

if(!isset($_GET['w'])) $w=200;											//	setting thumbnail width if missing
if(!isset($_GET['h'])) $h=165;											//	setting thumbnail width if missing
$img=@getimagesize($fromfile);											//	getting image data
if(is_array($img)) {
	switch($img[2]) {
		case 1 :
		if(!(imagetypes() & IMG_GIF)) {
		 	if(!function_exists("imagecreatefromgif")) $nomanage=true;  //	gif is only readable in recent GD
		 	else {
		 		$outype="png";											//	so the thumb will be in png format
		 		$img['mime']="image/png";
		 	}
		} else $outype="gif";
		$imtype="gif";
		break;
		case 2 :
		if(!(imagetypes() & IMG_JPG)) $nomanage=true;
		$outype="jpeg";
		$imtype="jpeg";		
		break;
		case 3 : 
		if(!(imagetypes() & IMG_PNG)) $nomanage=true;
		$imtype="png";
		$outype="png";
		break;
		default :
		header("Content-type: image/png");								//	image format not supported
		echo imagepng(ErrorPNG("wrong img type"));						//	by HAPPYBID
		exit;		
	}
	switch($brepeat) {
		case 'repeat': 
		$ratio=($img[0]>$w)? 5 : 1;
		$width=$img[0]/$ratio;
		$height=$img[1]/$ratio;
		break;					 
		case 'repeat-x': 
		$ratio=($img[0]>$w)? 5 : 1;
		$width=$img[0]/$ratio;
		$height=$h;
		break;					 
		case 'repeat-y': 
		$ratio=($img[1]>$h)? 5 : 1;
		$width=$w;
		$height=$img[1]/$ratio;
		break;					 
		case 'no-repeat': 
		$width=($w<$img[0]) ? $w: $img[0];
		$height=($h<$img[1]) ? $h: $img[1];
		break;					 
		case 'no': 
		header("Content-type: image/png");								//	no background mode
		echo imagepng(ErrorPNG("$fromfile"));	
		exit;
		break;					 
	}
} else {
	header("Content-type: image/png");									//	image is not a recognizable format
	echo imagepng(ErrorPNG("not image type"));
	exit;
}
if($nomanage) {
	header("Content-type: ".$img['mime']);								//	type not manageable
	echo join('',@file($fromfile));										//	render back the entire image requested
	exit;
}
$fi = @imagecreatetruecolor($width,$height);							//	create empty tile truecolor image
$ou = @imagecreatetruecolor($w,$h);										//	create empty truecolor image
$funcall="imagecreatefrom$imtype";										//	compose input function name
@imagecopyresampled($fi,@$funcall($fromfile),
	0,0,0,0,$width,$height,$img[0],$img[1]);							//	resample as tile
$it=imagesettile($ou,$fi);												//  set tile on output image
if($brepeat!="no-repeat")
	imageFilledRectangle($ou, 0, 0, $w, $h, IMG_COLOR_TILED);			//  fill with tile
else {
	$bgc = imagecolorallocate($ou, 255, 255, 255);	
	imagefilledrectangle($ou, 0, 0, $w, $h, $bgc);
	imageFilledRectangle($ou, 0, 0, $width, $height, IMG_COLOR_TILED);			//  fill with tile
}
$tc  = imagecolorallocate($ou, 0, 0, 0);
imagestring($ou, 3, 5, 5, $fromfile, $tc);
imagestring($ou, 3, 5, 15, $brepeat, $tc);
$funcall="image$outype";												//	compose output function name
header("Content-type: ".$img['mime']);									//	header
$funcall($ou);															//	write in output
?>
