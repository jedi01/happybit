<?
	function tam($img)
	{
		$re = filesize($img);
		return $re;
	}
	//header( 'Content-type: text/html; charset=\"$CHARSET\"' );
	//$Path = "images/";
	//$Path .= basename($_FILES['Archivo']['name']);
	$Path = $fname;
	move_uploaded_file($_FILES['Archivo']['tmp_name'], $Path);

	
	$Nombre_arch = basename($_FILES['Archivo']['name']);
	$tamagno = tam($Path);
	if($tamagno > 204800){
		$Ext = substr($Nombre_arch, -4, 4);
		$Nom = substr($Nombre_arch, 0, -4);
		
		$i =0;
		$Imagen = "images/".$Nom.$i.$Ext;
		//nombre del archivo con el contador.
		rename($Path, $Imagen);

		$Imagen = "images/".$Nom.$i.$Ext;
		$i++;	
		$Nombre = $Nom.$i.$Ext;

		/*getimagesize() Nos devuelve un array con cuatro elementos:
		Array([0]=>Ancho, [1]=>Alto, [2]=>Tipo)
		
		1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(intel byte order), 8 = TIFF(motorola byte order), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC, 14 = IFF, 15 = WBMP, 16 = XBM*/

		$Inf_imagen = getimagesize($Imagen);
		$Ancho = $Inf_imagen[0];
		$Alto = $Inf_imagen[1];
		$Tipo = $Inf_imagen[2];
		
		$Directorio = 'images/';
		$razon_de_cambio  = $Ancho / $Alto;
		$diferecial_ancho = $Ancho - 1500;
		$diferecial_alto  = $Alto  - 1500;		

		if($razon_de_cambio > 0){
			$New_ancho  = ($Ancho - $diferecial_ancho) * $razon_de_cambio;
			$New_alto   = $Alto - $diferecial_alto;
		}else{
			$New_ancho  = $Ancho - $diferecial_ancho;
			$New_alto   = ($Alto - $diferecial_alto) * $razon_de_cambio;
		}

		//Determino las nuevas medidas en función de los límites
		switch ($Tipo) {
			case 1: //GIF
				$New_imagen = imagecreate($New_ancho, $New_alto);
				$Old_imagen = imagecreatefromgif($Imagen);
				//cambia tamagno
				imagecopyresampled($New_imagen, $Old_imagen, 0, 0, 0, 0, $New_ancho, $New_alto, $Ancho, $Alto);
				if (!imagegif($New_imagen, $Directorio, $Nombre)) return false;
			break;
		   
			case 2: //JPG
				$New_imagen = imagecreatetruecolor($New_ancho, $New_alto);
				$Old_imagen = imagecreatefromjpeg($Imagen);
				imagecopyresampled($New_imagen, $Old_imagen, 0, 0, 0, 0, $New_ancho, $New_alto, $Ancho, $Alto);
				$ImageResized = imagejpeg($New_imagen, $Directorio . $Nombre);
				if (!$ImageResized) return false;
			break;
		   
			case 3: //PNG
				$New_imagen = imagecreatetruecolor($New_ancho, $New_alto);
				$Old_imagen = imagecreatefrompng($Imagen);
				imagecopyresampled($New_imagen, $Old_imagen, 0, 0, 0, 0, $New_ancho, $New_alto, $Ancho, $Alto);
				if (!imagepng($New_imagen, $Directorio, $Nombre)) return false;
			break;
			default:
				echo "sorry no es formato adecuado"; return false;
			break;
		}
		imagedestroy($New_imagen);
		imagedestroy($Old_imagen);
		$z = $i - 1;
		//Borramos el archivo
		unlink("images/".$Nom.$z.$Ext);
		$tamagno = tam("images/".$Nom.$i.$Ext);

	//	echo $i;
		//Se renombra el archivo a como estaba en el original.
		rename("images/".$Nom.$i.$Ext, $Path);
	}

?>
