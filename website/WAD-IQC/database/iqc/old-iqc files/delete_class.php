<?

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$class_ref=$_GET['class_ref'];


$table_class='class';
$table_grade='grade';



$grade_Stmt = "SELECT * from $table_class where
$table_class.class_ref='%d'";


$class_Stmt = "SELECT * from $table_class where
$table_class.grade_ref='%d'";

$del_grade = "delete from  $table_grade where 
$table_grade.grade_ref='%d'";

$del_class = "delete from  $table_class where 
$table_class.class_ref='%d'";






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

    //find grade_ref 
   
    if (!($result_grade = mysql_query(sprintf($grade_Stmt,$class_ref),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }

    $field_grade = mysql_fetch_object($result_grade);
    $grade_ref=$field_grade->grade_ref;
    mysql_free_result($result_grade);

    
    //query on classes in the specific grade

  
    if (!($result_class = mysql_query(sprintf($class_Stmt,$grade_ref),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }

    $class_counter=0;
    while($field_class = mysql_fetch_object($result_class))
    {
      $class_counter++;
    }
    mysql_free_result($result_class);


    if (!(mysql_query(sprintf($del_class,$class_ref), $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $del_class)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;}

    if ($class_counter==1) //only 1 class; grade needs to be deleted as well
    {
      if (!(mysql_query(sprintf($del_grade,$grade_ref), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $del_class)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}
    }




    
 
  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
 
  $executestring.= sprintf("show_grades.php?school=$school&school_year=$school_year&department=$department&t=%d",time());
  header($executestring);
  exit();
?>





