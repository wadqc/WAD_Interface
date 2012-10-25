<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_student='naw';
$table_mpc_class='mpc_class';


$student_Stmt = "SELECT * from $table_student, $table_mpc_class where 
$table_student.naw_ref=$table_mpc_class.naw_ref
and $table_mpc_class.mpc_class_ref=$mpc_class_ref";

$klas_Stmt = "SELECT * from $table_student, $table_mpc_class where 
$table_student.naw_ref=$table_mpc_class.naw_ref
and $table_student.naw_ref='%d'order by $table_mpc_class.jaar";


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

if (!($result_student= mysql_query($student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$field_student = mysql_fetch_object($result_student);

$student_table = new Smarty_NM();

$student_table->assign("student_firstname",$field_student->firstname);
$student_table->assign("student_lastname",$field_student->lastname);
$student_table->assign("student_date_of_birth",$field_student->date_of_birth);
$student_table->assign("student_sex",$field_student->sex);
$student_table->assign("student_address",$field_student->address);
$student_table->assign("student_phone",$field_student->phone);
$student_table->assign("student_number",$field_student->number);

$student_table->assign("student_department",$field_student->afdeling);
$student_table->assign("student_class",$field_student->klas);
$student_table->assign("student_profile",$field_student->profiel);

$student_table->assign("department",$field_student->afdeling);
$student_table->assign("class",$field_student->klas);
$student_table->assign("term",$field_student->jaar);

$picture_path=sprintf("%s%s",$picture_dir,$field_student->picture);
$student_table->assign("picture",$picture_path);

$student_table->assign("action_modify",sprintf("modify_student.php?mpc_class_ref=$mpc_class_ref&t=%d",time()));
$student_table->assign("action_delete",sprintf("delete_student.php?mpc_class_ref=$mpc_class_ref&t=%d",time()));

if (!($result_klas= mysql_query(sprintf($klas_Stmt,$field_student->naw_ref),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

mysql_free_result($result_student); 

$klas_content=sprintf("<tr><td class=\"table_data_blue\"> History </td></tr>");

while ($field_klas = mysql_fetch_object($result_klas))
{
  $klas_content.=sprintf("
  <tr>
    <td class=\"table_data_blue\"> $field_klas->jaar </td>
    <td class=\"table_data_blue\"> $field_klas->afdeling </td>
    <td class=\"table_data_blue\"> $field_klas->klas </td>
    <td class=\"table_data_blue\"> $field_klas->profiel </td>
  </tr>");
}
mysql_free_result($result_klas); 

$student_table->assign("klas_content",$klas_content);

$student_table->display("view_student_teacher.tpl");

?>