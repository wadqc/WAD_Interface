<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$subject=$_GET['subject'];
$cluster=$_GET['cluster'];
$term=$_GET['term'];

$school=$_GET['school'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];

$v=$_GET['v'];

$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';


$table_school='school';
$table_year='year';
$table_department='department';
$table_subject='subject';
$table_subject_skill='subject_skill';

$table_score='score';
$table_skill='skill';
$table_sub_skill='skill_sub';

$table_subjects='subjects';
$table_category_skill='category_skill';

$table_teacher='teacher';

if ($v==0)
{
  $query_cluster='%%';
  $query_class=$class;
}

if ($v==1)
{
  $query_cluster=$cluster; 
  $query_class=sprintf("%s%s",$class[0],'%%');  
}


$teacher_Stmt = "SELECT * from $table_teacher where
$table_teacher.login='%s'";

$student_Stmt = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student, $table_subjects where 
$table_school_student.school='$school' and
$table_department_student.department='$department' and 
$table_class_student.class='$class' and
$table_class_student.year='$school_year' and
$table_subjects.subject='$subject' and
$table_subjects.cluster like '$query_cluster' and
$table_subjects.teacher='%s' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref and
$table_class_student.class_ref=$table_subjects.class_ref  
order by $table_student.lastname, $table_student.firstname";


//$report_Stmt="SELECT * from $table_marks where 
//$table_marks.term='$term' and
//$table_marks.subjects_ref='%d'";

//$skill_name_Stmt ="SELECT * from $table_skill where $table_skill.order='%d'order by $table_skill.code_order";

$categories_skill_Stmt="SELECT * from $table_category_skill where
$table_category_skill.subjects_ref='%d' and
$table_category_skill.subject_skill_ref='%d' and
$table_category_skill.term<='$term' 
order by $table_category_skill.term";

$score_Stmt="SELECT * from $table_year, $table_school, $table_score 
where $table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_score.year_ref and
$table_school.school='$school' and 
$table_year.year='$school_year'
order by $table_score.number";

$skill_Stmt="SELECT * from $table_school, $table_year, $table_department,
$table_subject, $table_subject_skill 
where $table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_subject.department_ref and
$table_subject.subject_ref=$table_subject_skill.subject_ref and
$table_school.school='$school' and 
$table_year.year='$school_year' and
$table_department.department='$department' and
$table_subject.abreviation='$subject'
order by $table_subject_skill.number";


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

if (!($result_teacher= mysql_query(sprintf($teacher_Stmt,$user),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
$field_teacher = mysql_fetch_object($result_teacher); //only one hit!

if (!($result_student= mysql_query(sprintf($student_Stmt,$field_teacher->initials),$link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
mysql_free_result($result_teacher);


//define skill array



if (!($result_skill= mysql_query($skill_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
$skill_array='';
$skill_abreviation_array='';
$j=0;
while ($field_skill = mysql_fetch_object($result_skill))
{
  $number_array[$j]=$field_skill->number;
  $score_array[$j]=$field_skill->skill;
  $subject_skill_ref_array[$j]=$field_skill->subject_skill_ref;
  $j++;
}
mysql_free_result($result_skill); 
$skill_number=count($score_array);


//define score array 
if (!($result_score= mysql_query($score_Stmt, $link))) {
 DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
 DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
 exit() ;
}

$explenation_row_score='';
while($field_score = mysql_fetch_object($result_score))
{
  $list_score["$field_score->score"]="$field_score->score";
  if ($field_score->selected_score=='on')
  {
    $default_selected_score=$field_score->score;
  }
  $explenation_row_score.=sprintf("<tr><td class=\"table_data\">%s</td><td class=\"table_data\">%s</td></tr>",$field_score->score,$field_score->description);
} 
mysql_free_result($result_score);
   

$data = new Smarty_NM();

//$table_skill_select=sprintf("
//<tr>
//  <td class=\"table_data_blue\">
//     <font color=\"Blue\"><B>First name</B></font>
//  </td>
//  <td class=\"table_data_blue\">
//     <font color=\"Blue\"><B>Last name</B></font>
//  </td>
//  <td class=\"table_data_blue\">
//     <font color=\"Blue\"><B>Report</B></font>
//  </td>
//</tr>");

$explenation_table="";
$explenation_counter=0;

//student loop 
while (($field_student = mysql_fetch_object($result_student)))
{
  
  $data=new Smarty_NM(); 
  
  $data->assign("student_name",sprintf("%s %s",$field_student->firstname,$field_student->lastname));
  $data->assign("subject",$subject);
  
  $table_skill_select.=$data->fetch("subject_skill_score_header.tpl");

  //mysql_free_result($result_report);
  
  
  $explenation_row="";
  
  $i=0;
  while ($i<$skill_number) //loop for different available skills
  {
      
   $subject_skill_ref=$subject_skill_ref_array[$i];
   $subject_skill_score=$score_array[$i];
   $subject_skill_number=$number_array[$i];
   $b=($i%2);
   if ($b==0)
   $table_skill_select.=sprintf("<TR bgcolor=\"#B8E7FF\">");
   if ($b==1)
   $table_skill_select.=sprintf("<TR>");
   
   //check default values

   if (!($result_category=mysql_query(sprintf($categories_skill_Stmt,$field_student->subjects_ref,$subject_skill_ref),$link)))
   {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $categories_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
   }
   $k=0;
   // one row for each skill
   while (($field_category = mysql_fetch_object($result_category)))
   {
     $k++;
     $default_score=$field_category->score;
     $default_code=$field_category->code;
   }
   if ($k==0) // no default values;
   {
     $default_score=$default_selected_score;
     $default_code=" ";
   }
   
   mysql_free_result($result_category);

   $skill_input =new Smarty_NM();
   $skill_input->assign("number",$subject_skill_number);
   $skill_input->assign("name",$subject_skill_score);
   $score=sprintf("score[%d][%d]",$i,$field_student->subjects_ref);
   $skill_input->assign("score",$score);
   $skill_input->assign("score_options",$list_score);
   $skill_input->assign("default_score",$default_score);
   
   
   //if ($sub_skill_number==0)
   //{
     $table_skill_select.=$skill_input->fetch("skill.tpl");
   //}
   
   $table_skill_select.="</TR>";

   $i++;  
  }//all categories

    
  //$j++; 
  $explenation_counter++;
}//all students
  
 $data =  new Smarty_NM();

 $data->assign("subject_list",$table_skill_select);

 $data->assign("explenation_list",$explenation_table);
 $data->assign("explenation_list_score",$explenation_row_score);
 
 $header=sprintf("%s %s %s %s Term:%s Subject:%s Teacher:%s",$school,$school_year,$department,$class,$term,$subject,$user);

 $data->assign("header",$header);

 

 $data->assign("action",sprintf("add_score.php?v=$v&subject=$subject&cluster=$cluster&school=$school&department=$department&class=$class&school_year=$school_year&term=$term&default_selected_score=$default_selected_score&t=%d",time()));

 $data->display("score_select.tpl");
 
 mysql_free_result($result_student);  

?>