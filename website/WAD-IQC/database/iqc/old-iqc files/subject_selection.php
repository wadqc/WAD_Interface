<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];
$grade=$_GET['grade'];

$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';
$table_subjects='subjects';

$table_school='school';
$table_year='year';
$table_department='department';
$table_subject='subject';

$table_teacher='teacher';
$table_teacher_year='teacher_year';
$table_teacher_department='teacher_department';
$table_teacher_subject='teacher_subject';

$teacher_verify_Stmt="SELECT * from $table_teacher, $table_teacher_year,
$table_teacher_department, $table_teacher_subject where
$table_teacher.teacher_ref=$table_teacher_year.teacher_ref and
$table_teacher_year.year_ref=$table_teacher_department.year_ref and
$table_teacher_department.department_ref=$table_teacher_subject.department_ref and
$table_teacher_year.year='$school_year' and
$table_teacher_year.school='$school' and
$table_teacher_department.department='$department' and
$table_teacher_subject.subject='%s'";

$subject_Stmt = "SELECT * from $table_school, $table_year, $table_department, $table_subject where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_subject.department_ref and
$table_school.school='%s' and
$table_year.year='%s' and
$table_department.department='%s'
order by $table_subject.category, $table_subject.subject";

$student_Stmt = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student where 
$table_class_student.year='$school_year' and
$table_school_student.school='$school' and
$table_department_student.department='$department' and 
$table_class_student.class='$class' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref
order by $table_student.lastname, $table_student.firstname";



$subjects_Stmt = "SELECT * from $table_subjects where
$table_subjects.class_ref='%d' and 
$table_subjects.subject='%s'";

$delete_Stmt_subject = "DELETE from $table_subjects WHERE
$table_subjects.class_ref='%d'";

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

if (!($result_subject= mysql_query(sprintf($subject_Stmt,$school,$school_year,$department),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}



if (!($result_student= mysql_query($student_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

//delete subject with class_ref equal to -1
$select_class_ref_id=-1;
if (!(mysql_query(sprintf($delete_Stmt_subject,$select_class_ref_id),$link))) 
{
   DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
   exit() ;
}


$j=0;
while (($field = mysql_fetch_object($result_subject)))
{
  if ($j>0)
  { 
    if ($field->subject!=$subject_array[$j-1])
    {
      $subject_array[$j]=$field->abreviation;
      $j++;
    }
  }
  if ($j==0)
  { 
    $subject_array[$j]=$field->abreviation;
    $j++;
  }
}  
mysql_free_result($result_subject); 
$subject_number=count($subject_array);


$data=new Smarty_NM();
$table_student_select=$data->fetch("subject_select_arrows.tpl");
$table_subject_select='<tr>';
$table_subject_select_all='<tr>';

$table_student_select.=sprintf("
  <tr>
    <td class=\"table_data_blue_header_scroll\">
      <B>Last Name</B>
    </td>
    <td class=\"table_data_blue_header_scroll\">
      <B>First Name</B>
    </td>
  </tr>");
  
  $i=0; //Definition of the header information
  while ($i<$subject_number)
  {
    $header = new Smarty_NM();
    $table_subject_select.=$header->fetch("subject_data_header.tpl");
    $i++;
  } 

  $table_subject_select.=sprintf("</tr>");
  
  $j=0; // The header information will be defined during the first student row

while (($field_student = mysql_fetch_object($result_student)))
{
   $b=($j%2);
   if ($b==0)
   $row_start=sprintf("<TR bgcolor=\"#B8E7FF\">");
   if ($b==1)
   $row_start=sprintf("<TR>");
   
   $table_subject_select.=$row_start;
   $table_student_select.=$row_start;   

   $table_student_select.=sprintf("
   <td class=\"table_data_blue_header_scroll\">
    %s
   </td>
   <td class=\"table_data_blue_header_scroll\">
    %s
   </td> </tr>",$field_student->lastname,$field_student->firstname);
  
  //$i=$subject_start;
  //while ($i<$subject_stop)
 
  $i=0;
  while ($i<$subject_number)
  {
      if (!($result_subjects= mysql_query(sprintf($subjects_Stmt,$field_student->class_ref,$subject_array[$i]),$link))){
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
      $k=0;
      $subject_cluster='';
      $subject_teacher='';
      // one row for each subject
      while (($field_subjects = mysql_fetch_object($result_subjects)))
      {
        $k++;
        $subject_teacher=$field_subjects->teacher;
        $subject_cluster=$field_subjects->cluster;
      }
  
      if ($k==0)
      {
        $subject_checked='';
      }
  
      if ($k==1)
      {
        $subject_checked='checked';
      }
      mysql_free_result($result_subjects);
      
      $data_part = new Smarty_NM();
      $subject_name=sprintf("subject[%d][%s]",$field_student->class_ref,$subject_array[$i]);
      $data_part->assign("subject_name",$subject_name);
      $data_part->assign("subject_checked",$subject_checked);
      $data_part->assign("subject",$subject_array[$i]);
      $teacher_name=sprintf("teacher[%d][%s]",$field_student->class_ref,$subject_array[$i]);
      $data_part->assign("teacher_name",$teacher_name);
      
      
      if ($j==0)
      { 
        if (!($result_teacher= mysql_query(sprintf($teacher_verify_Stmt,$subject_array[$i]), $link))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
        }
        $teacher_list[$i]='';
        while ($field_teacher = mysql_fetch_object($result_teacher))
        {
          $teacher_list[$i]["$field_teacher->initials"]="$field_teacher->initials";
        }
        mysql_free_result($result_teacher);
      }
      $data_part->assign("teacher_options",$teacher_list[$i]);
      $data_part->assign("teacher_id",$subject_teacher);
      $cluster_name=sprintf("cluster[%d][%s]",$field_student->class_ref,$subject_array[$i]);
      $data_part->assign("cluster_name",$cluster_name);
      $data_part->assign("cluster_options",$cluster_list);
      $data_part->assign("cluster_id",$subject_cluster);

      $table_subject_select.=$data_part->fetch("subject_data_part.tpl");
      
      if ($j==0) //first student row only
      {
        $select_class_ref_id=-1;
        $data_part = new Smarty_NM();
        $subject_name=sprintf("subject_all[%d][%s]",$select_class_ref_id,$subject_array[$i]);
        $data_part->assign("subject_name",$subject_name);
        $data_part->assign("subject_checked",$subject_checked);
        $data_part->assign("subject",$subject_array[$i]);
        $teacher_name=sprintf("teacher_all[%d][%s]",$select_class_ref_id,$subject_array[$i]);
        $data_part->assign("teacher_name",$teacher_name);
        $data_part->assign("teacher_options",$teacher_list[$i]);
        $data_part->assign("teacher_id",$subject_teacher);
        $cluster_name=sprintf("cluster_all[%d][%s]",$select_class_ref_id,$subject_array[$i]);
        $data_part->assign("cluster_name",$cluster_name);
        $data_part->assign("cluster_options",$cluster_list);
        $data_part->assign("cluster_id",$subject_cluster);
        
        $table_subject_select_all.=$data_part->fetch("subject_data_select_all.tpl");

      }
      $i++;  
  }//all subjects
  
  $table_subject_select.=sprintf("</tr>");
  if ($j==0)
  {
    $table_subject_select_all.='<tr>';
  }
  $j++; 
  
}//all students
mysql_free_result($result_student);  

$table_subject_select_all.=$table_subject_select;
$table_subject_select=$table_subject_select_all;


$data = new Smarty_NM();
$data->assign("table_student_select",$table_student_select);
$data->assign("table_subject_select",$table_subject_select);
$data->assign("header",sprintf("%s %s %s Class:%s",$school,$school_year,$department,$class));
$data->assign("subject_action",sprintf("subject_add.php?grade=$grade&department=$department&class=$class&school_year=$school_year&school=$school&t=&d",time()));

//$data->assign("subject_action",sprintf("subject_add.php?grade=$grade&department=$department&class=$class&school_year=$school_year&school=$school&subject_start=$subject_start&subject_stop=$subject_stop&subject_number=$subject_number&t=&d",time()));
 
$data->display("subject_select.tpl");
 
?>
