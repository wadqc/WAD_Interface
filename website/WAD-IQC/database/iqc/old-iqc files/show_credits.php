<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$class=$_GET['class'];
$class_ref=$_GET['class_ref'];
$term=$_GET['term'];
$student_name=$_GET['student_name'];

$table_teacher='teacher';
$table_year='teacher_year';
$table_department='teacher_department';



$table_credits='credits';

$credit_Stmt = "SELECT * from $table_credits where 
$table_credits.class_ref=$class_ref and
$table_credits.term=$term
order by $table_credits.teacher_name, $table_credits.project";

$queryStmt_teacher = "Select * from $table_teacher,$table_year where 
$table_teacher.teacher_ref=$table_year.teacher_ref and
$table_year.year='$school_year' and
$table_teacher.login='$user'";

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


if (!($result_credit=mysql_query($credit_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $credit_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

if (!($result_teacher= mysql_query($queryStmt_teacher, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_department)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$initials='';
while ($field_teacher = mysql_fetch_object($result_teacher))
{
  $initials=$field_teacher->initials;
}
mysql_free_result($result_teacher);


$data_table = new Smarty_NM();
$credit_list=$data_table->fetch("credits_select_header.tpl");
 
$j=0;
while (($field_credit = mysql_fetch_object($result_credit)))
{
   $b=($j%2);
   $bgcolor=''; 
   if ($b==0)
   {
     $bgcolor="#B8E7FF";
   }

   $data_table = new Smarty_NM();
   if ($j==0)
   {
     $table_credit=$data_table->fetch("credits_select_header.tpl");
   }
   
   $data_table->assign("bgcolor",$bgcolor);
   $data_table->assign("project",$field_credit->project);
   $data_table->assign("teacher",$field_credit->teacher_name);
   $data_table->assign("credits",$field_credit->credit);
   if  ($field_credit->teacher==$initials)  
   {
     $credit_action=sprintf("view_credit.php?school=$school&school_year=$school_year&department=$department&class=$class&student_name=$student_name&term=$term&credits_ref=%d&t=%d",$field_credit->credits_ref,time());
     $data_table->assign("action",$credit_action);
     $credit_list.=$data_table->fetch("credits_select_row.tpl");
   }
   if  ($field_credit->teacher!=$initials)  
   {
     $credit_list.=$data_table->fetch("credits_unselect_row.tpl");
   }
   $j++;
}


mysql_free_result($result_credit);  

$data = new Smarty_NM();


$data->assign("header",sprintf("Student: %s %s %s department:%s term:%s",$student_name,$school,$school_year,$department,$term));

$data->assign("credit_list",$credit_list);

$new_credit=sprintf("<a href=\"new_credit.php?school=$school&school_year=$school_year&department=$department&class=$class&student_name=$student_name&term=$term&class_ref=$class_ref&t=%d\">Add new Credit</a>",time());

$data->assign("new_credit",$new_credit);

$data->display("credit_view_select.tpl");
 
?> 
