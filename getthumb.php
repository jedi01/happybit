<?

$w = $_GET['w'];
$fromfile = $_GET['fromfile'];

function ErrorPNG($err)
{
	$im  = @imagecreate(100, 30); /* Create a blank image */
	$bgc = @imagecolorallocate($im, 255, 255, 255);
	$tc  = @imagecolorallocate($im, 0, 0, 0);
	@imagefilledrectangle($im, 0, 0, 100, 30, $bgc);
	/* Output an errmsg */
	@imagestring($im, 1, 5, 5, $err, $tc);
	return $im;
}
if(isset($_GET['fromfile']))	$_GET['fromfile'] = str_replace('..', '', $_GET['fromfile'] );

// control parameters and file existence
if(!isset($_GET['fromfile'])) {
	header("Content-type: image/png");
	echo @imagepng(@ErrorPNG("params empty"));
	exit;
} elseif (!file_exists($_GET['fromfile']))  {
	header("Content-type: image/png");
	echo @imagepng(@ErrorPNG("img doesn't exist"));
	exit;
}
// try to see if it already exists a cached thumbnail
if(function_exists('imagetypes')) {
	//if(file_exists("./uploaded/cache/".md5($_SERVER["QUERY_STRING"]))) {
	if(0) {
		$img=@getimagesize("./uploaded/cache/".md5($_SERVER["QUERY_STRING"]));
		/* set the cache limiter to 'nocache' */
		//session_cache_limiter('nocache');
		//$cache_limiter = session_cache_limiter();
		
		/* set the cache expire to 30 minutes */
		//session_cache_expire(30);
		//$cache_expire = session_cache_expire();
		header("Content-type: ".$img['mime']);
		echo join('',@file("./uploaded/cache/".md5($_SERVER["QUERY_STRING"])));
		exit;
	} elseif(!@is_dir("./uploaded/cache")) mkdir("./uploaded/cache",0777);

	if(!isset($_GET['w'])) $w=100;											//	setting thumbnail width if missing
	$img=@getimagesize("./".$fromfile);											//	getting image data
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
    $ratio=floatval($img[0]/$w);										//	calculate proportional ratio
		$h=ceil($img[1]/$ratio);										//	proportional height
	} else {
		header("Content-type: image/png");									//	image is not a recognizable format
		echo imagepng(ErrorPNG("not image type"));
		exit;
	}
} else {
	$nomanage=true;
	$img=@getimagesize("./".$fromfile);											//	getting image data
}
if($nomanage) {
	header("Content-type: ".$img['mime']);								//	type not manageable
	echo join('',@file($fromfile));										//	render back the entire image requested
	exit;
}
/* set the cache limiter to 'nocache' */
//session_cache_limiter('nocache');
//$cache_limiter = session_cache_limiter();

/* set the cache expire to 30 minutes */
//session_cache_expire(30);
//$cache_expire = session_cache_expire();

$ou = @imagecreatetruecolor($w,$h);										//	create empty truecolor image
@imagealphablending($ou, false);										//  transparent pixels on background!
$funcall="imagecreatefrom$imtype";										//	compose input function name
@imagecopyresampled($ou,@$funcall("./".$fromfile),
0,0,0,0,$w,$h,$img[0],$img[1]);											//	resample a thumbnail
$funcall="image$outype";												//	compose output function name
@$funcall($ou,"./uploaded/cache/".md5($_SERVER["QUERY_STRING"]));			//	write in output
header("Content-type: ".$img['mime']);									//	header
@$funcall($ou);															//	write in output
?>
