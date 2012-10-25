<?php
header("Content-type: image/png");
$im = imagecreate(128, 16) or die("Cannot Initialize new GD image stream");
$bc = imagecolorallocate($im, 0, 255, 255);
$tc = imagecolorallocate($im, 0, 0, 0);
imagestring($im, 1, 4, 4,  $t, $tc);
imagepng($im);
imagedestroy($im);
?>