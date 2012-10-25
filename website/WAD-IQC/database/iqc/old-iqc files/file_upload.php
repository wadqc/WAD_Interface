<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$picture_folder=$_GET['picture_folder'];
$new_student_ref=$_GET['new_student_ref'];
$v=$_GET['v'];

$year_ref=-1; //just a value, in case used by student
if (!empty($_GET['year_ref']))
{
  $year_ref=$_GET['year_ref'];
}


$dir_handle=@opendir($picture_folder);
if (!$dir_handle)
{
  mkdir($picture_folder);
}







if ( ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/pjpeg") )
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
      //printf("picture_folder=: %s",$picture_folder);
      //printf("Upload: %s \n", $_FILES["file"]["name"] );
      //printf("Type: %s \n", $_FILES["file"]["type"] );
      //printf("Size: %f0 \n", ($_FILES["file"]["size"] / 1024) );
 
      $database_picture=sprintf("%s/%s",$picture_folder, $_FILES["file"]["name"]);
      //printf("picture=%s",$database_picture);
      if (file_exists($database_picture))
      {
        printf("file: %s already exists!",$_FILES["file"]["name"]);
        exit();
      }
      else
      {
        move_uploaded_file($_FILES["file"]["tmp_name"],$database_picture);
        
        $newheight=$default_picture_height;
        // Get new sizes
        list($width, $height) = getimagesize($database_picture);
        $newwidth = ($newheight/$height)*$width;

        // Load

        $full_img = imagecreatefromjpeg($database_picture);
        $thumb_img = imagecreatetruecolor($newwidth,$newheight);
        imagecopyresampled($thumb_img,$full_img,0,0,0,0,$newwidth,$newheight,$width,$height);
        imagedestroy($full_img);

        //store
        imagejpeg($thumb_img,$database_picture,100);//save to file high res img.
      }   


    }
  }
else
  {
  printf("type=%s",$_FILES["file"]["type"]);
  echo "Invalid file";
  }




  //printf("new_student.php?picture=$database_picture&school=$school&school_year=$school_year&year_ref=$year_ref&new_student_ref=$new_student_ref&t=%d",time());


$start_year=substr($school_year,0,4);
$stop_year=substr($school_year,5,4);



$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
if ($v==0) //student   
{
  $picture=sprintf("%s%s_%s/%s",$picture_student_dir,$start_year,$stop_year, $_FILES["file"]["name"]);
  $executestring.= sprintf("new_student.php?picture=$picture&school=$school&school_year=$school_year&year_ref=$year_ref&new_student_ref=$new_student_ref&t=%d",time());
}
if ($v==1) //teacher  
{
  $picture=sprintf("%s%s_%s/%s",$picture_teacher_dir,$start_year,$stop_year, $_FILES["file"]["name"]);
  $executestring.= sprintf("new_teacher.php?picture=$picture&school=$school&school_year=$school_year&year_ref=$year_ref&t=%d",time());
} 

header($executestring);
exit();








?>