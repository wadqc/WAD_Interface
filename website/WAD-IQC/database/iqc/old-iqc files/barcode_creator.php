<?php 

//script using code39  9 lines with 3 of them double width
//each code is seperated by a single white line


$barcode=$_GET['barcode'];
//printf("barcode=%s",$barcode);

//start/stop character *
$barcode=sprintf("*%s*",$barcode);
//printf("barcode=%s",$barcode);


$code['*']='BWWBWBBWBBWB'; 
$code[' ']='BWWBBWBWBBWB'; 
$code['0']='BWBWWBBWBBWB';
$code['1']='BBWBWWBWBWBB'; 
$code['2']='BWBBWWBWBWBB'; 
$code['3']='BBWBBWWBWBWB'; 
$code['4']='BWBWWBBWBWBB'; 
$code['5']='BBWBWWBBWBWB'; 
$code['6']='BWBBWWBBWBWB'; 
$code['7']='BWBWWBWBBWBB'; 
$code['8']='BBWBWWBWBBWB'; 
$code['9']='BWBBWWBWBBWB'; 

$barcode_string='';
$barcode_string_length=strlen($barcode);
$j=0;
while ($j<$barcode_string_length)
{
  $barcode_string.=$code[$barcode[$j]];
  $barcode_string.='W'; //a white line between each code
  $j++;
}
//printf("barcode_string=%s",$barcode_string);

$barcode_image_height=30; //30 pixels is about 0.8 mm
$barcode_image_width=13*$barcode_string_length; //12 code characters + 1 white line

if($barcode_image_width!= strlen($barcode_string))
{
  printf("something wrong with barcode in barcode creator");
  exit();
}

$im = imagecreate($barcode_image_width, $barcode_image_height);

// The first call to imagecolorallocate() fills the background color.
$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);


$j=0;
while ($j<$barcode_image_width)
{
  if ($barcode_string[$j]=='B')
  {
    imageline ($im,$j,0,$j,$barcode_image_height,$black);
  }
  $j++;
}
header("Content-type: image/png");
imagepng($im);
imagedestroy($im);

?>
