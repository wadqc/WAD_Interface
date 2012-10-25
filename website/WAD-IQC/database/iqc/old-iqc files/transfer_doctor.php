<?

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];

$table_doctor='doctor';

$del_doctor_stmt = "delete from  $table_doctor where 
$table_doctor.doctor_ref='%d'";


// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",
                             $hostName, $userName)) ;
   exit();
}


// Select the Database
if (!mysql_select_db($databaseName, $link)) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


$limit=0;
if (!empty($_POST['doctor']))
{
  $doctor=$_POST['doctor'];
  $doctor_ref_key=array_keys($doctor);
  $limit=sizeof($doctor_ref_key);
} 


$i=0;

while ($i<$limit) // loop for $class_ref
{
  if ($doctor[$doctor_ref_key[$i]]=='on')
  {
     if (!($result_doctor= mysql_query(sprintf($del_doctor_stmt,$doctor_ref_key[$i]),$link))) {
            DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
            DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
            exit() ;}
  }
  $i++;
}

$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
$executestring.= sprintf("show_doctors.php?school=$school&t=%d",time());
  
header($executestring);
exit();


?>


