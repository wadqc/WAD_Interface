<?

function add_teacher_teacher($firstname,$middlename,$lastname,$title,$sex,$date_of_birth,$place_of_birth,$nationality,$religion,$language,$email,$address,$phone_home,$phone_cell,$fax,$marital_status,$spouse,$children,$picture,$initials,$login_level_1,$login_level_2,$login_level_3,$login,$date_of_employment,$employment_subjects,$employment_qualifications,$employment_certificates,$password_teacher,$teacher_ref,$message)
{

require("../globals.php") ;



$table_teacher='teacher';
$message='';

$addStmt_teacher = "Insert into
$table_teacher(firstname,middlename,lastname,title,sex,date_of_birth,place_of_birth,nationality,religion,language,email,address,phone_home,phone_cell,fax,marital_status,spouse,children,picture,initials,login_level_1,login_level_2,login_level_3,login,date_of_employment,employment_subjects,employment_qualifications,employment_certificates,password)
values ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')";


$queryStmt_teacher = "Select * from $table_teacher where 
$table_teacher.firstname='%s' and
$table_teacher.lastname='%s' and
$table_teacher.sex='%s' and
$table_teacher.date_of_birth='%s' and
$table_teacher.address='%s' and
$table_teacher.phone_home='%s' and
$table_teacher.phone_cell='%s' and
$table_teacher.picture='%s' and
$table_teacher.initials='%s' and
$table_teacher.login='%s' ";


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

//verify on login and initials
if ($login==''||$initials==''||$lastname=='')
{
  $message=1;
}  


// verify on excisting teacher
if (!($result_query= mysql_query(sprintf($queryStmt_teacher,$firstname,$lastname,$sex,$date_of_birth,$address,$phone_home,$phone_cell,$picture,$initials,$login), $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
while ($field_teacher = mysql_fetch_object($result_query))
{
  $message=2;
}
mysql_free_result($result_query);

if ($message=='') //new teacher
{
  if(!mysql_query(sprintf($addStmt_teacher,$firstname,$middlename,$lastname,$title,$sex,$date_of_birth,$place_of_birth,$nationality,$religion,$language,$email,$address,$phone_home,$phone_cell,$fax,$marital_status,$spouse,$children,$picture,$initials,$login_level_1,$login_level_2,$login_level_3,$login,$date_of_employment,$employment_subjects,$employment_qualifications,$employment_certificates,$password_teacher),$link)) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  } 
  
  if (!($result_query= mysql_query(sprintf($queryStmt_teacher,$firstname,$lastname,$sex,$date_of_birth,$address,$phone_home,$phone_cell,$picture,$initials,$login), $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  $field_query = mysql_fetch_object($result_query);
  $teacher_ref=$field_query->teacher_ref;  
  mysql_free_result($result_query);
}

}



function add_teacher_year($year,$school,$teacher_ref,$year_ref,$message)
{
require("../globals.php") ;

//$table_teacher='teacher';
$table_teacher_year='teacher_year';

$queryStmt_year = "Select * from $table_teacher_year where 
$table_teacher_year.year='%s' and
$table_teacher_year.school='%s' and
$table_teacher_year.teacher_ref='%d'";

$addStmt_year = "Insert into $table_teacher_year(year,school,teacher_ref)
values ('%s','%s','%d')";



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

if (!($result_year_verify= mysql_query(sprintf($queryStmt_year,$year,$school,$teacher_ref),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$message='';
while (($field_verify = mysql_fetch_object($result_year_verify)))
{
   $message=1;
}
mysql_free_result($result_year_verify);  


if ($message=='') //new year
{
  if (!mysql_query(sprintf($addStmt_year,$year,$school,$teacher_ref),$link)) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  } 

  if (!($result_year_verify= mysql_query(sprintf($queryStmt_year,$year,$school,$teacher_ref),$link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }

  $field_verify = mysql_fetch_object($result_year_verify);
  $year_ref=$field_verify->year_ref;

  mysql_free_result($result_year_verify);  

}

}

?>