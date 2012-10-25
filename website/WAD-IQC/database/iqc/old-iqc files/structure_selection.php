<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$term=$_GET['school_year'];

$table_department='department';
$table_grade='grade';
$table_class='class';

$table_subject='subject';


$class_Stmt = "SELECT * from $table_department, $table_grade, $table_class where
$table_department.department_ref=$table_grade.department_ref and
$table_grade.grade_ref=$table_class.grade_ref and 
$table_department.year=$term 
and $table_grade.grade='%d'
order by $table_class.number";

$subject_Stmt = "SELECT * from $table_department, $table_subject where
$table_department.department_ref=$table_subject.department_ref and 
$table_department.year=$term order by $table_subject.number";


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

if (!($result_subject= mysql_query($subject_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}



 $i=0;
 $department_class="";
 $row="";
 $j=1;
 while ($j<7) // 6 classes maximum
 {
   $b=($j%2);
   if ($b==0)
   $department_class.=sprintf("<TR bgcolor=\"#B8E7FF\">");
   if ($b==1)
   $department_class.=sprintf("<TR>");
   $department_class.=sprintf("
  <td>
     <font color=\"black\"><B>Class %d</B></font>
  </td>",$j);
  
  if (!($result_class= mysql_query(sprintf($class_Stmt,$j),$link)))
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  
  
  $m=0;
   
  //selection on all available descriptions for a certain class 
  while (($field_class = mysql_fetch_object($result_class)))
  {
    $class_input =new Smarty_NM();

    $class_name=sprintf("class[%d][%d]",$j,$m);
    $class_input->assign("class_name",$class_name);  
    $class_input->assign("class_value",$field_class->description); 
   
    $department_class.=$class_input->fetch("class_input.tpl");
    
    //printf("m=%d",$m);   
    $m++;
  }

  while ($m<$class_cols)
  {
    $class_input =new Smarty_NM();

    $class_name=sprintf("class[%d][%d]",$j,$m);
    $class_input->assign("class_name",$class_name);  
    $class_input->assign("class_value",$field_class->description); 
   
    $department_class.=$class_input->fetch("class_input.tpl");
    
    //printf("m=%d",$m);   
    $m++;
  } 

  mysql_free_result($result_class);
  $department_class.=sprintf("</tr>");
   
  $j++; 
 }//all classes
  
 $department_subject="";
 $row="";
 $j=1;

 //selection on all available subjects  
 while (($field_subject = mysql_fetch_object($result_subject)))
 {
  
   $b=($j%2);
   if ($j==1)
   {
     if ($b==1)
     $department_subject.=sprintf("<TR bgcolor=\"#B8E7FF\">");
     if ($b==0)
     $department_subject.=sprintf("<TR>");
     $department_subject.=sprintf("
     <td>
     <font color=\"black\"><B>No</B></font>
     </td>
     <td>
     <font color=\"black\"><B>Name</B></font>
     </td>
     <td>
     <font color=\"black\"><B>Abreviation</B></font>
     </td>
     </TR>");
   }
   if ($b==1)
   $department_subject.=sprintf("<TR bgcolor=\"#B8E7FF\">");
   if ($b==0)
   $department_subject.=sprintf("<TR>");
   
   $subject_input =new Smarty_NM();
   $subject_input->assign("number",$j);
   $subject_name=sprintf("subject[%d]",$j);
   $subject_input->assign("subject_name",$subject_name);  
   $subject_input->assign("subject_value",$field_subject->name); 
   $subject_abr=sprintf("subject_abr[%d]",$j);
   $subject_input->assign("subject_abr",$subject_abr);  
   $subject_input->assign("subject_abr_value",$field_subject->abreviation); 
   $department_subject.=$subject_input->fetch("subject_input.tpl");
   
   $department_subject.=sprintf("</TR>"); 
   
   $j++;
 }

 while ($j<$subject_cols)
 {
   $b=($j%2);
   if ($j==1)
   {
     if ($b==1)
     $department_subject.=sprintf("<TR bgcolor=\"#B8E7FF\">");
     if ($b==0)
     $department_subject.=sprintf("<TR>");
     $department_subject.=sprintf("
     <td>
     <font color=\"black\"><B>No</B></font>
     </td>
     <td>
     <font color=\"black\"><B>Name</B></font>
     </td>
     <td>
     <font color=\"black\"><B>Abreviation</B></font>
     </td>
     </TR>");
   }
   if ($b==1)
   $department_subject.=sprintf("<TR bgcolor=\"#B8E7FF\">");
   if ($b==0)
   $department_subject.=sprintf("<TR>");
   
   $subject_input =new Smarty_NM();
   $subject_input->assign("number",$j);
   $subject_name=sprintf("subject[%d]",$j);
   $subject_input->assign("subject_name",$subject_name);  
   $subject_input->assign("subject_value",$field_subject->name); 
   $subject_abr=sprintf("subject_abr[%d]",$j);
   $subject_input->assign("subject_abr",$subject_abr);  
   $subject_input->assign("subject_abr_value",$field_subject->abreviation); 
   $department_subject.=$subject_input->fetch("subject_input.tpl");
   
   $department_subject.=sprintf("</TR>"); 
   
   $j++;

 } 

 mysql_free_result($result_subject);
 
 $department_table = new Smarty_NM();
 
 $department_table->assign("department_class",$department_class);
 $department_table->assign("department_subject",$department_subject);



 $department_table->assign("department_action",sprintf("update_department.php?year=$term&department=$department&v=$v&t=%d",time()));

 $header=sprintf("School year %s Department %s ",$term,$department);

 $department_table->assign("header",$header);

 $department_table->display("department_table.tpl");
 ReturnToMain();

?>