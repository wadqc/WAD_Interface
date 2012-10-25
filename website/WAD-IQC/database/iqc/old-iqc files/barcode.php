<?php 
/* 
*  This script can be used to create barcode-images in the following formats: 
*  UPC-A     /^[0-9]{12}$/ 
*  UPC-E     /^[01][0-9]{7}$/ 
*  EAN-13    /^[0-9]{13}$/ 
*  EAN-8     /^[0-9]{8}$/ 
*  Code 39   /^\*[0-9A-Z\-\.\$\/+% ]{1,48}\*$/ 
*  Codabar   /^([ABCD])[0-9\-\$:\/\.\+]{1,48}\\1$/i 
*  128C      /^(\d\d)+$/ 
*  Also, UPC- and EAN-codes can be suffixed with additional 2- or 5-digit 
*  supplemental code. 
*  Additional info: when printing, 38 pixels take up 1 cm of space. 
* 
*   
*  Copyright (c) 2002 Nieko Maatjes (nieko.net) 
* 
*  This program is free software; you can redistribute it and/or 
*  modify it under the terms of the GNU General Public License 
*  as published by the Free Software Foundation; either version 2 
*  of the License, or (at your option) any later version. 
* 
*  This program is distributed in the hope that it will be useful, 
*  but WITHOUT ANY WARRANTY; without even the implied warranty of 
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
*  GNU General Public License for more details. 
* 
*  See http://www.gnu.org/licenses/gpl.txt 
* 
*/ 



$title = 'Barcode creator'; 

//data for encoding digits/letters to bars (=1) and spaces (=0) 
$a =        array('0001101',  //0 
                  '0011001',  //1 
                  '0010011',  //2 
                  '0111101',  //3 
                  '0100011',  //4 
                  '0110001',  //5 
                  '0101111',  //6 
                  '0111011',  //7 
                  '0110111',  //8 
                  '0001011'); //9 
//Beetje jammer dat er een foutje in zit:
//'0111011',  //5  (in array $b)
//moet zijn '0111001',  //5
$b =        array('0100111',  //0 
                  '0110011',  //1 
                  '0011011',  //2 
                  '0100001',  //3 
                  '0011101',  //4 
                  '0111001',  //5 
                  '0000101',  //6 
                  '0010001',  //7 
                  '0001001',  //8 
                  '0010111'); //9 
$right =    array('1110010',  //0 
                  '1100110',  //1 
                  '1101100',  //2 
                  '1000010',  //3 
                  '1011100',  //4 
                  '1001110',  //5 
                  '1010000',  //6 
                  '1000100',  //7 
                  '1001000',  //8 
                  '1110100'); //9 
$AB =       array('aaaaaa',   //0 
                  'aababb',   //1 
                  'aabbab',   //2 
                  'aabbba',   //3 
                  'abaabb',   //4 
                  'abbaab',   //5 
                  'abbbaa',   //6 
                  'ababab',   //7 
                  'ababba',   //8 
                  'abbaba');  //9 
$UPCE =     array('bbbaaa',   //0 
                  'bbabaa',   //1 
                  'bbaaba',   //2 
                  'bbaaab',   //3 
                  'babbaa',   //4 
                  'baabba',   //5 
                  'baaabb',   //6 
                  'bababa',   //7 
                  'babaab',   //8 
                  'baabab');  //9 
$code39 =  array('0' => '101001101101', 
                 '1' => '110100101011', 
                 '2' => '101100101011', 
                 '3' => '110110010101', 
                 '4' => '101001101011', 
                 '5' => '110100110101', 
                 '6' => '101100110101', 
                 '7' => '101001011011', 
                 '8' => '110100101101', 
                 '9' => '101100101101', 
                 'A' => '110101001011', 
                 'B' => '101101001011', 
                 'C' => '110110100101', 
                 'D' => '101011001011', 
                 'E' => '110101100101', 
                 'F' => '101101100101', 
                 'G' => '101010011011', 
                 'H' => '110101001101', 
                 'I' => '101101001101', 
                 'J' => '101011001101', 
                 'K' => '110101010011', 
                 'L' => '101101010011', 
                 'M' => '110110101001', 
                 'N' => '101011010011', 
                 'O' => '110101101001', 
                 'P' => '101101101001', 
                 'Q' => '101010110011', 
                 'R' => '110101011001', 
                 'S' => '101101011001', 
                 'T' => '101011011001', 
                 'U' => '110010101011', 
                 'V' => '100110101011', 
                 'W' => '110011010101', 
                 'X' => '100101101011', 
                 'Y' => '110010110101', 
                 'Z' => '100110110101', 
                 '-' => '100101011011', 
                 '.' => '110010101101', 
                 ' ' => '100110101101', 
                 '$' => '100100100101', 
                 '/' => '100100101001', 
                 '+' => '100101001001', 
                 '%' => '101001001001', 
                 '*' => '100101101101'); 
$codabar = array('0' => '101010011', 
                 '1' => '101011001', 
                 '2' => '101001011', 
                 '3' => '110010101', 
                 '4' => '101101001', 
                 '5' => '110101001', 
                 '6' => '100101011', 
                 '7' => '100101101', 
                 '8' => '100110101', 
                 '9' => '110100101', 
                 '-' => '101001101', 
                 '$' => '101100101', 
                 ':' => '1101011011', 
                 '/' => '1101101011', 
                 '.' => '1101101101', 
                 '+' => '1011011011', 
                 'A' => '1011001001',  //A=a, B=b, C=c, D=d 
                 'B' => '1010010011', 
                 'C' => '1001001011', 
                 'D' => '1010011001', 
                 'a' => '1011001001', 
                 'b' => '1010010011', 
                 'c' => '1001001011', 
                 'd' => '1010011001'); 
$kix     = array('0' => 'mmww',        //t=top, b=bottom, m=middle, w=whole 
                 '1' => 'mbtw', 
                 '2' => 'mbwt', 
                 '3' => 'bmtw', 
                 '4' => 'bmwt', 
                 '5' => 'bbtt', 
                 '6' => 'mtbw', 
                 '7' => 'mwmw', 
                 '8' => 'mwbt', 
                 '9' => 'btmw', 
                 'A' => 'btbt', 
                 'B' => 'bwmt', 
                 'C' => 'mtwb', 
                 'D' => 'mwtb', 
                 'E' => 'mwwm', 
                 'F' => 'bttb', 
                 'G' => 'btwm', 
                 'H' => 'bwtm', 
                 'I' => 'tmbw', 
                 'J' => 'tbmw', 
                 'K' => 'tbbt', 
                 'L' => 'wmmw', 
                 'M' => 'wmbt', 
                 'N' => 'wbmt', 
                 'O' => 'tmwb', 
                 'P' => 'tbtb', 
                 'Q' => 'tbwm', 
                 'R' => 'wmtb', 
                 'S' => 'wmwm', 
                 'T' => 'wbtm', 
                 'U' => 'ttbb', 
                 'V' => 'twmb', 
                 'W' => 'twbm', 
                 'X' => 'wtmb', 
                 'Y' => 'wtmb', 
                 'Z' => 'wwmm'); 
//128C 
//                        BWBWBW 
$bar128c = array('00' => '212222', 
                 '01' => '222122', 
                 '02' => '222221', 
                 '03' => '121223', 
                 '04' => '121322', 
                 '05' => '131222', 
                 '06' => '122213', 
                 '07' => '122312', 
                 '08' => '132212', 
                 '09' => '221213', 
                 '10' => '221312', 
                 '11' => '231212', 
                 '12' => '112232', 
                 '13' => '122132', 
                 '14' => '122231', 
                 '15' => '113222', 
                 '16' => '123122', 
                 '17' => '123221', 
                 '18' => '223211', 
                 '19' => '221132', 
                 '20' => '221231', 
                 '21' => '213212', 
                 '22' => '223112', 
                 '23' => '312131', 
                 '24' => '311222', 
                 '25' => '321122', 
                 '26' => '321221', 
                 '27' => '312212', 
                 '28' => '322112', 
                 '29' => '322211', 
                 '30' => '212123', 
                 '31' => '212321', 
                 '32' => '232121', 
                 '33' => '111323', 
                 '34' => '131123', 
                 '35' => '131321', 
                 '36' => '112313', 
                 '37' => '132113', 
                 '38' => '132311', 
                 '39' => '211313', 
                 '40' => '231113', 
                 '41' => '231311', 
                 '42' => '112133', 
                 '43' => '112331', 
                 '44' => '132131', 
                 '45' => '113123', 
                 '46' => '113321', 
                 '47' => '133121', 
                 '48' => '313121', 
                 '49' => '211331', 
                 '50' => '231131', 
                 '51' => '213113', 
                 '52' => '213311', 
                 '53' => '213131', 
                 '54' => '311123', 
                 '55' => '311321', 
                 '56' => '331121', 
                 '57' => '312113', 
                 '58' => '312311', 
                 '59' => '332111', 
                 '60' => '314111', 
                 '61' => '221411', 
                 '62' => '431111', 
                 '63' => '111224', 
                 '64' => '111422', 
                 '65' => '121124', 
                 '66' => '121421', 
                 '67' => '141122', 
                 '68' => '141221', 
                 '69' => '112214', 
                 '70' => '112412', 
                 '71' => '122114', 
                 '72' => '122411', 
                 '73' => '142112', 
                 '74' => '142211', 
                 '75' => '241211', 
                 '76' => '221114', 
                 '77' => '413111', 
                 '78' => '241112', 
                 '79' => '134111', 
                 '80' => '111242', 
                 '81' => '121142', 
                 '82' => '121241', 
                 '83' => '114212', 
                 '84' => '124112', 
                 '85' => '124211', 
                 '86' => '411212', 
                 '87' => '421112', 
                 '88' => '421211', 
                 '89' => '212141', 
                 '90' => '214121', 
                 '91' => '412121', 
                 '92' => '111143', 
                 '93' => '111341', 
                 '94' => '131141', 
                 '95' => '114113', 
                 '96' => '114311', 
                 '97' => '411113', 
                 '98' => '411311', 
                 '99' => '113141', 
                 'ST' => '211232',   //START 
                 'OP' => '2331112'); //STOP 


// $barcode: the barcode used

// $coding: the coding used
//
//UPC-A consists of 12 digits.
//UPC-E consists of 8 digits, from which the first is either a 0 or a 1.
//EAN-13 consists of 13 digits.
//EAN-8 consists of 8 digits.
//Code 39 starts and ends with an asterisk (*), and can only contain numbers, capitals and -.
//Codabar starts and ends with an A, B, C or D, and can only contain mubers and -$:/.+
//KIX For information on KIX, please visit "http://www.tpgpostbusiness.nl/kix
//128C consist of an even number of digits.
 
//$override   = 'on' if you want to Override KIX or Code 39, else ''. 
//$dispcod    = '15' if you want to display the code, else '0'
//$file_name  =
//
ImagePNG($image,'$file_name');

function create_barcode_image($barcode,$coding,$override,$dispcod,$file_name)
{ 
  
  if (preg_match("/^[0-9]{12}(,[0-9]{2,5})?$/", $barcode))  //if UPC-code, change to EAN-code with no extra coding 
  { 
    $barcode = '0'.$barcode;    //make UPC and EAN-codes both 13 characters long 
  } 

  //process barcode 
  //if correct UPC-A / EAN-13-code 
  if (preg_match("/^[0-9]{13}(,[0-9]{2,5})?$/", $barcode) && ($coding == 'DWIM' || $coding == 'UPC-A' || $coding == 'EAN-13')) 
  { 
    $gobackn = ($barcode[0] == '0' ? 10 : 0);  //$gobackn is used to make the image smaller when working with UPC-A 
    if (strlen($barcode) == 13) 
    { CreateImage(105 - $gobackn,  62 + $dispcod); } 
    elseif (strlen($barcode) == 16) 
    { CreateImage(132 - $gobackn, 62 + $dispcod); } 
    elseif (strlen($barcode) == 19) 
    { CreateImage(168 - $gobackn, 62 + $dispcod); } 

    //draw numbers 
    if ($barcode[0] != '0') 
    { ImageString($image, 3, 2, 50 + $dispcod, $barcode[0], $black); } 

    if ($dispcod && $barcode[0] != '0')  //draw preceeding EAN-number 
    { ImageString($image, 3, 36, 0, 'EAN-13', $black); } 
    elseif ($dispcod) //UPC-A 
    { 
      ImageString($image, 3, 31, 0, 'UPC-A', $black); 
    } 
    ImageString($image, 3, 14 - $gobackn, 50 + $dispcod, substr($barcode, 1, 6), $black); 
    ImageString($image, 3, 60 - $gobackn, 50 + $dispcod, substr($barcode, 7, 6), $black); 

    //draw guard bars 
    ImageLine($image, 10 - $gobackn, $dispcod, 10 - $gobackn, 62 + $dispcod, $black); 
    ImageLine($image, 12 - $gobackn, $dispcod, 12 - $gobackn, 62 + $dispcod, $black); 
    ImageLine($image, 56 - $gobackn, $dispcod, 56 - $gobackn, 62 + $dispcod, $black); 
    ImageLine($image, 58 - $gobackn, $dispcod, 58 - $gobackn, 62 + $dispcod, $black); 
    ImageLine($image, 102 - $gobackn, $dispcod, 102 - $gobackn, 62 + $dispcod, $black); 
    ImageLine($image, 104 - $gobackn, $dispcod, 104 - $gobackn, 62 + $dispcod, $black); 

    $position = 13;   //start drawing bars at x = 13; 

    for ($digit = 1; $digit <= 6; $digit++)  //first digit should be skipped, is either 0 (UPC) or encoded in next six (EAN) 
    { 
       for ($offset = 0; $offset < 7; $offset++) 
       { 
         $color = $AB[$barcode[0]];               //$barcode[0] is first digit that is coded into first 42 (6*7) bars 
         $color = substr($color, $digit - 1, 1); 
         $color = ${$color}; 
         $color = substr($color[$barcode[$digit]], $offset, 1); 
         $color = ($color == '1' ? $black : $white); 
         ImageLine($image, $position - $gobackn, $dispcod, $position - $gobackn, 50 + $dispcod, $color); 
         $position++; 
       } 
    } 
    $position += 5; 
    for ($digit = 7; $digit <= 12; $digit++) 
    { 
       for ($offset = 0; $offset < 7; $offset++) 
       { 
         $color = substr($right[$barcode[$digit]], $offset, 1); 
         $color = ($color == '1' ? $black : $white); 
         ImageLine($image, $position - $gobackn, $dispcod, $position - $gobackn, 50 + $dispcod, $color); 
         $position++; 
       } 
    } 

    if (preg_match("/,[0-9]{2,5}$/", $barcode)) 
    { 
      $position -= $gobackn; 
      suffix($position, preg_replace("/^[0-9]{13},([0-9]{2,5})$/", "\\1", $barcode)); 
    } 

    //header('Content-type: image/png');   //send image-header 
    ImagePNG($image,'$file_name'); 
    ImageDestroy($image); 
  } 
  elseif (preg_match("/^[0-9]{8}(,[0-9]{2,5})?$/", $barcode) && ($coding == 'DWIM' || $coding == 'EAN-8'))    //if correct EAN-8-code 
  { 
    if (strlen($barcode) == 8) 
    { CreateImage(67, 62 + $dispcod); } 
    elseif (strlen($barcode) == 11) 
    { CreateImage(94, 62 + $dispcod); } 
    elseif (strlen($barcode) == 14) 
    { CreateImage(130, 62 + $dispcod); } 

    //draw numbers 
    ImageString($image, 3, 4, 50 + $dispcod, substr($barcode, 0, 4), $black); 
    ImageString($image, 3, 36, 50 + $dispcod, substr($barcode, 4, 4), $black); 
    if ($dispcod) { ImageString($image, 3, 17, 0, 'EAN-8', $black); } 


    //draw guard bars 
    ImageLine($image, 0, $dispcod, 0, 62 + $dispcod, $black); 
    ImageLine($image, 2, $dispcod, 2, 62 + $dispcod, $black); 
    ImageLine($image, 32, $dispcod, 32, 62 + $dispcod, $black); 
    ImageLine($image, 34, $dispcod, 34, 62 + $dispcod, $black); 
    ImageLine($image, 64, $dispcod, 64, 62 + $dispcod, $black); 
    ImageLine($image, 66, $dispcod, 66, 62 + $dispcod, $black); 

    $position = 3;   //start drawing bars at x = 3; 

    for ($digit = 0; $digit <= 3; $digit++) 
    { 
       for ($offset = 0; $offset < 7; $offset++) 
       { 
         $color = substr($a[$barcode[$digit]], $offset, 1);   //$a contains left-A spaces/bars 
         $color = ($color == '1' ? $black : $white); 
         ImageLine($image, $position, $dispcod, $position, 50 + $dispcod, $color); 
         $position++; 
       } 
    } 
    $position += 5; 
    for ($digit = 4; $digit <= 7; $digit++) 
    { 
       for ($offset = 0; $offset < 7; $offset++) 
       { 
         $color = substr($right[$barcode[$digit]], $offset, 1); 
         $color = ($color == '1' ? $black : $white); 
         ImageLine($image, $position, $dispcod, $position, 50 + $dispcod, $color); 
         $position++; 
       } 
    } 

    if (preg_match("/,[0-9]{2,5}$/", $barcode)) 
    { 
      suffix($position, preg_replace("/^[0-9]{8},([0-9]{2,5})$/", "\\1", $barcode)); 
    } 

    //header('Content-type: image/png');   //send image-header 
    ImagePNG($image,'$file_name'); 
    ImageDestroy($image); 
  } 
  elseif (preg_match("/^[01][0-9]{7}(,[0-9]{2,5})?$/", $barcode) && ($coding == 'UPC-E'))    //if correct UPC-E-code (DWIM not included => EAN-8) 
  { 
    if (strlen($barcode) == 8) 
    { CreateImage(69, 62 + $dispcod); } 
    elseif (strlen($barcode) == 11) 
    { CreateImage(95, 62 + $dispcod); } 
    elseif (strlen($barcode) == 14) 
    { CreateImage(131, 62 + $dispcod); } 

    //draw numbers 
    ImageString($image, 3, 2, 30 + $dispcod, substr($barcode, 0, 1), $black); 
    ImageString($image, 3, 14, 50 + $dispcod, substr($barcode, 1, 6), $black); 
    if ($dispcod=='15') { ImageString($image, 3, 18, 0, 'UPC-E', $black); } 
    ImageString($image, 3, 63, 30 + $dispcod, substr($barcode, 7, 1), $black); 

    //draw guard bars 
    ImageLine($image, 10, $dispcod, 10, 62 + $dispcod, $black); 
    ImageLine($image, 12, $dispcod, 12, 62 + $dispcod, $black); 
    ImageLine($image, 56, $dispcod, 56, 62 + $dispcod, $black); 
    ImageLine($image, 58, $dispcod, 58, 62 + $dispcod, $black); 
    ImageLine($image, 60, $dispcod, 60, 62 + $dispcod, $black); 

    $position = 13;   //start drawing bars at x = 3; 
    if ($barcode[0] == '0' || $barcode[0] == '1')  //UPC-E can only start with 0 or 1 
    { 
      for ($digit = 1; $digit <= 6; $digit++)   //first digit is encoded in next six 
      { 
        $color = $UPCE[$barcode[7]]; 
        $color = substr($color, $digit - 1, 1); 
        if ($barcode[0] == '1')   //aaabbb => bbbaaa, see docs.txt 
        { 
          $color = ($color == 'a' ? 'b' : 'a'); 
        } 
        $color = ${$color}; 
        $color = $color[$barcode[$digit]]; 
        for ($offset = 0; $offset < 7; $offset++) 
        { 
          ImageLine($image, $position, $dispcod, $position, 50 + $dispcod, (substr($color, $offset, 1) == '1' ? $black : $white)); 
          $position++; 
        } 
      } 
    } 

    if (preg_match("/,[0-9]{2,5}$/", $barcode)) 
    { 
      $position += 10; 
      suffix($position, preg_replace("/^[0-9]{8},([0-9]{2,5})$/", "\\1", $barcode)); 
    } 

    //header('Content-type: image/png');   //send image-header 
    ImagePNG($image,'$file_name'); 
    ImageDestroy($image); 
  } 
  elseif ((($override && preg_match("/^[0-9A-Z\-\.\$\/+% ]{1,48}$/i", $barcode)) || preg_match("/^\*[0-9A-Z\-\.\$\/+% ]{1,48}\*$/i", $barcode)) && ($coding == 'DWIM' || $coding == 'Code 39')) 
  { 
    $barcode = strtoupper($barcode);   //can only use capital letters 
    CreateImage(13 * strlen($barcode), 62 + $dispcod); 

    //draw numbers 
    if (($dispcod=='15') && strlen($barcode) > 3)  //otherwise, 'Code 39' would be too large to fit in the image 
    { ImageString($image, 3, 6.5 * strlen($barcode) - 25, 0, 'Code 39', $black); } 

    $position = 0;   //start drawing bars at x = 0; 

    for ($digit = 0; $digit <= strlen($barcode) - 1; $digit++) 
    { 
       //draw number/letter 
       ImageString($image, 3, $position + 3, 50 + $dispcod, $barcode[$digit], $black); 

       for ($offset = 0; $offset < 12; $offset++) 
       { 
         $color = substr($code39[$barcode[$digit]], $offset, 1); 
         $color = ($color == '1' ? $black : $white); 
         ImageLine($image, $position, $dispcod, $position, 50 + $dispcod, $color); 
         $position++; 
       } 
       ImageLine($image, $position, $dispcod, $position, 50 + $dispcod, $white);   //every letter ends with a space 
       $position++; 
    } 
    //header('Content-type: image/png');   //send image-header 
    ImagePNG($image,'$file_name'); 
    ImageDestroy($image); 
  } 
  elseif (preg_match("/^([ABCD])[0-9\-\$:\/\.\+]{1,48}\\1$/i", $barcode) && ($coding == 'DWIM' || $coding == 'Codabar')) 
  { 
    $length = -1;  //final whitespace should be left out 
    for ($digit = 0; $digit < strlen($barcode); $digit++) 
    { 
      $length += strlen($codabar[$barcode[$digit]]); 
      $length += 1;   //extra space after every digit 
    } 
     
    CreateImage($length, 62 + $dispcod); 

    //draw coding 
    if (($dispcod=='15') && $length > 47)  //otherwise, 'Codabar' would be to large to fit in the image 
    { ImageString($image, 3, $length / 2 - 22, 0, 'Codabar', $black); } 

    $position = 0;   //start drawing bars at x = 0; 

    for ($digit = 0; $digit < strlen($barcode); $digit++) 
    { 
       //draw number/letter 
       ImageString($image, 3, $position + 3, 50 + $dispcod, $barcode[$digit], $black); 

       for ($offset = 0; $offset < strlen($codabar[$barcode[$digit]]); $offset++) 
       { 
         $color = substr($codabar[$barcode[$digit]], $offset, 1); 
         $color = ($color == '1' ? $black : $white); 
         ImageLine($image, $position, $dispcod, $position, 50 + $dispcod, $color); 
         $position++; 
       } 
       ImageLine($image, $position, $dispcod, $position, 50 + $dispcod, $white);   //every letter ends with a space 
       $position++; 
    } 
    //header('Content-type: image/png');   //send image-header 
    ImagePNG($image,'$file_name'); 
    ImageDestroy($image); 
  } 
  elseif ((($override && preg_match("/^[a-z0-9]{1,50}$/i", $barcode)) || preg_match("/^[0-9]{4}[a-z]{2}[0-9]{0,5}($|X[a-z0-9]{0,6}|[0-9]{1,5})$/i", $barcode)) && ($coding == 'DWIM' || $coding == 'KIX')) 
  { 
    #breedte streepje: 2 pixels, breedte witruimte: 2 pixels 
    #hoogte synchronisatiestreep 5 pixels 
    #hoogte rest streepje 7 pixels 
    $barcode = strtoupper($barcode);  //$kix only contains the uppercase alphabet 
    CreateImage(strlen($barcode) * 16, 19 + $dispcod); 

    //draw numbers 
    if (($dispcod=='15') && strlen($barcode) > 0)  //otherwise, 'KIX' would be to large to fit in the image 
    { ImageString($image, 3, strlen($barcode) * 16 / 2 - 11, 0, 'KIX', $black); } 

    $position = 0; 

    for($digit = 0; $digit < strlen($barcode); $digit++) 
    { 
      for ($offset = 0; $offset < 4; $offset++) 
      { 
        switch($kix[$barcode[$digit]][$offset]) 
        { 
          case 'm': 
            ImageLine($image, $position, 7 + $dispcod, $position, 11 + $dispcod, $black); 
            ImageLine($image, $position + 1, 7 + $dispcod, $position + 1, 11 + $dispcod, $black); 
            break; 
          case 'b': 
            ImageLine($image, $position, 7 + $dispcod, $position, 18 + $dispcod, $black); 
            ImageLine($image, $position + 1, 7 + $dispcod, $position + 1, 18 + $dispcod, $black); 
            break; 
          case 't': 
            ImageLine($image, $position, $dispcod, $position, 11 + $dispcod, $black); 
            ImageLine($image, $position + 1, $dispcod, $position + 1, 11 + $dispcod, $black); 
            break; 
          case 'w': 
            ImageLine($image, $position, $dispcod, $position, 18 + $dispcod, $black); 
            ImageLine($image, $position + 1, $dispcod, $position + 1, 18 + $dispcod, $black); 
            break; 
        } 
        $position += 4; 
      } 
    }     

    //header('Content-type: image/png');   //send image-header 
    ImagePNG($image,'$file_name'); 
    ImageDestroy($image); 
  } 
  elseif (preg_match("/^(\d\d)+$/", $_GET['barcode']) && ($coding == 'DWIM' || $coding == '128C')) 
  { 
    $barcode = 'ST'.$_GET['barcode'].'OP'; //include START and STOP-bars 
    CreateImage(strlen($barcode) * 11 / 2 + 2, 42 + $dispcod);  //11 pixels per 2 digits, except for the last one, which has 13 (11 + 2) 

    if ($dispcod=='15') 
    { ImageString($image, 3, strlen($barcode) * 11 / 4 - 11, 0, '128C', $black); } 

    $pos = 0; 

    //draw bars (including START and STOP) 
    for ($digit = 0; $digit < strlen($barcode); $digit += 2) 
    { 
      $bars = $bar128c[substr($barcode, $digit, 2)];  //something like '113141' (BWBWBW) 
      for ($bar = 0; $bar < strlen($bars); $bar++) 
      { 
        for ($counter = 0; $counter < substr($bars, $bar, 1); $counter++) 
        { ImageLine($image, $pos, $dispcod, $pos++, 42 + $dispcod, ($bar % 2 ? $white : $black)); } 
      } 
    } 
    //header('Content-type: image/png');   //send image-header 
    ImagePNG($image,'$file_name'); 
    ImageDestroy($image); 
  } 
  else 
  { 
    if ($coding == 'DWIM') 
    { echoHTML($title, "\n  <font color=\"#ff0000\">Sorry, the barcode was not recognized!</font><br /><br />"); } 
    elseif ($coding == 'UPC-A') 
    { echoHTML($title, "\n  <font color=\"#ff0000\">Sorry, the barcode was not recognized as UPC-A!<br />\n  UPC-A consists of 12 digits.</font><br /><br />"); } 
    elseif ($coding == 'UPC-E') 
    { echoHTML($title, "\n  <font color=\"#ff0000\">Sorry, the barcode was not recognized as UPC-E!<br />\n  UPC-E consists of 8 digits, from which the first is either a 0 or a 1.</font><br /><br />"); } 
    elseif ($coding == 'EAN-13') 
    { echoHTML($title, "\n  <font color=\"#ff0000\">Sorry, the barcode was not recognized as EAN-13!<br />\n  EAN-13 consists of 13 digits.</font><br /><br />"); } 
    elseif ($coding == 'EAN-8') 
    { echoHTML($title, "\n  <font color=\"#ff0000\">Sorry, the barcode was not recognized as EAN-8!<br />\n  EAN-8 consists of 8 digits.</font><br /><br />"); } 
    elseif ($coding == 'Code 39') 
    { echoHTML($title, "\n  <font color=\"#ff0000\">Sorry, the barcode was not recognized as Code 39!<br />\n  Code 39 starts and ends with an asterisk (*), and<br />\n  can only contain numbers, capitals and -. $/+%</font><br /><br />"); } 
    elseif ($coding == 'Codabar') 
    { echoHTML($title, "\n  <font color=\"#ff0000\">Sorry, the barcode was not recognized as Codabar!<br />\n  Codabar starts and ends with an A, B, C or D, and<br />\n  can only contain mubers and -$:/.+</font><br /><br />"); } 
    elseif ($coding == 'KIX') 
    { echoHTML($title, "\n  <font color=\"#ff0000\">Sorry, the barcode was not recognized as KIX!<br />\n  For information on KIX, please visit <a href=\"http://www.tpgpostbusiness.nl/kix/\">TPG Post</a>.</font><br /><br />"); } 
    elseif ($coding == '128C') 
    { echoHTML($title, "\n  <font color=\"#ff0000\">Sorry, the barcode was not recognized as 128C!<br />\n  128C-barcodes consist of an even number of digits.</font><br /><br />"); } 
  } 
} 
else 
{ echoHTML($title, 'just for the fun'); } 


// F U N C T I O N S 
function echoHTML($title, $extra) 
{ 
  echo "<?xml version=\"1.1\" encoding=\"us-ascii\" ?> 
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\"> 
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\"> 
<head> 
  <title>$title</title> 
  <style type=\"text/css\"> 
    body 
    { background-color: #cfcfcf; 
      color: #3f0000 } 
    p 
    { display: inline; } 
  </style> 
</head> 
<body> 
<p>$extra</p> 
<form action=\"{$_SERVER['PHP_SELF']}\" method=\"get\"> 
  <p> 
    <input type=\"text\" name=\"barcode\" value=\"Enter a barcode\" size=\"25\" maxlength=\"50\" /> 
    <select name=\"coding\"> 
      <option value=\"DWIM\" selected=\"selected\">Do What I Mean</option> 
      <option value=\"UPC-A\">UPC-A (US/Canada)</option> 
      <option value=\"UPC-E\">UPC-E (US/Canada)</option> 
      <option value=\"EAN-13\">EAN-13 (Europe/Japan)</option> 
      <option value=\"EAN-8\">EAN-8 (Europe/Japan)</option> 
      <option value=\"Code 39\">Code 39 (Text)</option> 
      <option value=\"Codabar\">Codabar</option> 
      <option value=\"KIX\">KIX</option> 
      <option value=\"128C\">128C</option> 
    </select> 
    <input type=\"submit\" value=\"Create image!\" /><br /> 
    <input type=\"checkbox\" name=\"override\" />Override KIX or Code 39 
    <input type=\"checkbox\" name=\"dispcod\" checked=\"checked\" />Display coding in barcode 
  </p> 
</form> 
<hr /> 
<p>Copyright (&copy;) 2002 Nieko Maatjes</p> 
</body> 
</html>"; 
} 


function createImage($x, $y) 
{ 
  global $image; 
  global $white; 
  global $black; 
  $image = ImageCreate($x, $y);   //create image 
  $white = ImageColorAllocate($image, 255, 255, 255);  //define colors 
  $black = ImageColorAllocate($image, 0, 0, 0); 
} 

function suffix(&$position, $value)  //draw supplemental barcodes 
{ 
  global $image; 
  global $black; 
  global $white; 
  global $a; 
  global $b; 
  global $UPCE; 
  global $dispcod; 

  if (strlen($value) == 2)   //suffix can only be 2 or 5 digits wide 
  { 
    $position += 10;  //leave a gap 7 bars wide, and skip 3 guard bars => 10 
    ImageLine($image, $position, 12 + $dispcod, $position, 62 + $dispcod, $black); 
    ImageLine($image, $position + 2, 12 + $dispcod, $position + 2, 62 + $dispcod, $black); 
    ImageLine($image, $position + 3, 12 + $dispcod, $position + 3, 62 + $dispcod, $black); 
    ImageString($image, 3, $position + 5, $dispcod, $value, $black); 

    $position += 4; 
    switch (((int)$value) % 4) 
    { 
      case 0: $parity = 'aa'; break; 
      case 1: $parity = 'ab'; break; 
      case 2: $parity = 'ba'; break; 
      case 3: $parity = 'bb'; break; 
    } 

    for ($digit = 0; $digit <= 1; $digit++) 
    { 
       for ($offset = 0; $offset < 7; $offset++) 
       { 
         $color = substr($parity, $digit, 1); 
         $color = ${$color}; 
         $color = $color[substr($value, $digit, 1)]; 
         $color = substr($color, $offset, 1); 
         $color = ($color == '1' ? $black : $white); 
         ImageLine($image, $position, 12  + $dispcod, $position, 62 + $dispcod, $color); 
         $position++; 
       } 
       if ($digit == 0)  //draw guardbar '01' 
       { $position++; ImageLine($image, $position, 12 + $dispcod, $position, 62 + $dispcod, $black); $position++; } 
    } 
  } 
  elseif (strlen($value) == 5) 
  { 
    $position += 10;  //leave a gap 7 bars wide, and skip 3 guard bars => 10 
    ImageLine($image, $position, 12 + $dispcod, $position, 62 + $dispcod, $black); 
    ImageLine($image, $position + 2, 12 + $dispcod, $position + 2, 62 + $dispcod, $black); 
    ImageLine($image, $position + 3, 12 + $dispcod, $position + 3, 62 + $dispcod, $black); 
    ImageString($image, 3, $position + 12, $dispcod, $value, $black); 

    $position += 4; 
    $parity = ((int)substr($value, 0, 1) + (int)substr($value, 2, 1) + (int)substr($value, 4, 1)) * 3; 
    $parity += ((int)substr($value, 1, 1) + (int)substr($value, 3, 1)) * 9; 
    $parity = $parity % 10; 
    $parity = $UPCE[$parity]; 

    for ($digit = 0; $digit <= 5; $digit++) 
    { 
       for ($offset = 0; $offset < 7; $offset++) 
       { 
         $color = substr($parity, $digit, 1); 
         $color = ${$color}; 
         $color = $color[substr($value, $digit, 1)]; 
         $color = substr($color, $offset, 1); 
         $color = ($color == '1' ? $black : $white); 
         ImageLine($image, $position, 12 + $dispcod, $position, 62 + $dispcod, $color); 
         $position++; 
       } 
       if ($digit < 5)  //draw guardbar '01' 
       { $position++; ImageLine($image, $position, 12 + $dispcod, $position, 62 + $dispcod, $black); $position++; } 
    } 
  } 
} 
?>
