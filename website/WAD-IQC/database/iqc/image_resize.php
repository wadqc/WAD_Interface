<?php
require("../globals.php") ;

// File and new size



$filename = $_GET['f_name'];
$newheight=$_GET['height'];
//$filename=sprintf("%s%s",$picture_dir,$filename);
// Get new sizes
list($width, $height) = getimagesize($filename);
$newwidth = ($newheight/$height)*$width;

// Load

$full_img = imagecreatefromjpeg($filename);
$thumb_img = imagecreatetruecolor($newwidth,$newheight);
imagecopyresampled($thumb_img,$full_img,0,0,0,0,$newwidth,$newheight,$width,$height);
//imagecopyresized($thumb_img,$full_img,0,0,0,0,$newwidth,$newheight,$width,$height);
imagedestroy($full_img);


// Output
header('Content-type: image/jpeg');
imagejpeg($thumb_img);

?> 