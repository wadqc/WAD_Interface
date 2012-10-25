<?

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];


$table_new_teacher='new_teacher';

$new_teacher_Stmt = "SELECT * from $table_new_teacher";

// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",
                             $hostName, $userName)) ;
   exit() ;
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_new_teacher = mysql_query($new_teacher_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


if (!($new_tea = mysql_fetch_object($result_new_teacher))){
   DisplayErrMsg("Internal error: the entry does not exist") ;
   exit() ;
  }


$dh=opendir($picture_teacher_dir);

while (false!== ($filename=readdir($dh)))
{
  $file_array[]=sprintf("%s%s",$picture_teacher_dir,$filename);
}


$pic = new Smarty_NM();
$pic->assign("file_selected",$new_tea->picture);

$insert=sprintf("%s?school=$school&school_year=$school_year&t=%d",$new_tea->page,time());

mysql_free_result($result_new_teacher);

$pic->assign("file_list",$file_array);
$pic->assign("insert_action",$insert);
$pic->assign("insert_value","insert");
$pic->display("insert_picture.tpl");


?>