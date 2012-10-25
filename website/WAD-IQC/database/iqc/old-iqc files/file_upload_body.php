<?

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

//$picture_folder=sprintf("%s%s%s",$picture_root,$picture_student_dir,$school_year);

$upload_action=sprintf("file_upload.php?school=$school&school_year=$school_year&year_ref=$year_ref&new_student_ref=$new_student_ref&picture_folder=$picture_folder&v=$v&t=%d",time());


$pic = new Smarty_NM();
$pic->assign("upload_action",$upload_action);
$pic->display("remote_file_upload.tpl");


?>

