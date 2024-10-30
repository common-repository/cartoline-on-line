<?php
//Funzione per riconoscere l'estensione del file
function col_get_file_ext($nome_file){
	return strrev(substr(strrev($nome_file),0,strpos(strrev($nome_file),'.')));
}

function col_get_tipo_img($nome_file){
	$file_info=pathinfo($nome_file);
	return strtolower($file_info['extension']);
}
	
function col_crea_nomefile($path,$nome_file){
	if(substr($path,-1)=='/'){
		return $path.$nome_file;
	}else{
		return $path.'/'.$nome_file;
	}
}
	
function col_apri_file_img($path,$nome_file){
	$image_file_type = col_get_tipo_img($nome_file);
		
	if($image_file_type=="gif"){
		 return imagecreatefromgif(col_crea_nomefile($path,$nome_file)); 
	}elseif($image_file_type=="png"){
		 return imagecreatefrompng(col_crea_nomefile($path,$nome_file)); 
	}elseif($image_file_type=="jpg" || $image_file_type=="jpeg"){
		 return imagecreatefromjpeg(col_crea_nomefile($path,$nome_file)); 
	}
}

function col_crea_img($width,$height){
	if (function_exists("imagecreatetruecolor")){
		return imagecreatetruecolor($width,$height);
	}else{
		return imagecreate($width,$height);
	}
}
$path=isset($_REQUEST['p'])?$_REQUEST['p']:'';
print "asdasd";
$nome_file=isset($_REQUEST['f'])?$_REQUEST['f']:'';
$open_image=col_apri_file_img($path,$nome_file);
$width_orig=imagesx($open_image);
$height_orig=imagesy($open_image);
$height = isset($_REQUEST['h'])?intval($_REQUEST['h']):200;
$width = ($width_orig*$height)/$height_orig;

header('Content-type: image/jpeg');
header('Content-Disposition: attachment; filename="thumb_'.$nome_file.'.jpg"');

if ($width && ($width_orig < $height_orig)) {
   $width = ($height / $height_orig) * $width_orig;
} else {
   $height = ($width / $width_orig) * $height_orig;
}

if($width>220)
	$width = 220;

$height = ($height_orig*$width)/$width_orig;

$image_p = col_crea_img($width, $height);
$white = imagecolorallocate($image_p , 255, 255, 255);
imagefill($image_p, 0, 0, $white);
imagecopyresampled($image_p, $open_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
imagejpeg($image_p, null, 80);	
@imagedestroy($open_image);
@imagedestroy($image_p);
?>
