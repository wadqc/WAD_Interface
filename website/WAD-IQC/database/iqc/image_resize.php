<?php
require("../globals.php") ;

// File and new size



$filename = $_GET['f_name'];

$newheight=$_GET['height'];


// Get new sizes
list($width, $height) = getimagesize($filename);
$newwidth = ($newheight/$height)*$width;

$thumb_img = imagecreatetruecolor($newwidth,$newheight);

// Load

switch (exif_imagetype($filename)) 
{
    case IMAGETYPE_GIF:
        $image_type = IMG_GIF;
        $full_img = imagecreatefromgif($filename);
        imagecopyresampled($thumb_img,$full_img,0,0,0,0,$newwidth,$newheight,$width,$height);
        imagedestroy($full_img);
        header('Content-Type: image/gif'); 
        imagegif($thumb_img);
        break;
    case IMAGETYPE_JPEG:
        $image_type = IMG_JPG;
        $full_img = imagecreatefromjpeg($filename);
        imagecopyresampled($thumb_img,$full_img,0,0,0,0,$newwidth,$newheight,$width,$height);
        imagedestroy($full_img);
        header('Content-Type: image/jpeg');
        imagejpeg($thumb_img);
        break;
    case IMAGETYPE_PNG:
        $image_type = IMG_PNG;
        $full_img = imagecreatefrompng($filename);
        imagecopyresampled($thumb_img,$full_img,0,0,0,0,$newwidth,$newheight,$width,$height);
        imagedestroy($full_img);        
        header('Content-Type: image/png');
        imagepng($thumb_img);
        break;
    case IMAGETYPE_WBMP:
        $image_type = IMG_WBMP;
        $full_img = imagecreatefromwbmp($filename);
        imagecopyresampled($thumb_img,$full_img,0,0,0,0,$newwidth,$newheight,$width,$height);
        imagedestroy($full_img);
        header('Content-Type: image/wbmp');
        imagegwbmp($thumb_img);
        break;
    case IMAGETYPE_BMP:
        $image_type = IMG_BMP;
        $full_img = imagecreatefrombmp($filename);
        imagecopyresampled($thumb_img,$full_img,0,0,0,0,$newwidth,$newheight,$width,$height);
        imagedestroy($full_img);
        header('Content-Type: image/bmp');
        imagebmp($thumb_img);
        break;
     default:
        $image_type = 0;
        printf("no image type");
        break;
}



?> 