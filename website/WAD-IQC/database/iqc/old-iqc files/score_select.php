<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$subject=$_GET['subject'];
$cluster=$_GET['cluster'];
$term=$_GET['term'];

$school=$_GET['school'];
$department=$_GET['department'];
$grade=$_GET['grade'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];
$mark_border=$_GET['mark_border'];
$v=$_GET['v'];

$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';


$table_school='school';
$table_year='year';
$table_score='score';
$table_skill='skill';
$table_sub_skill='skill_sub';

$table_subject='subjects';
$table_marks='marks';
$table_category='category';

$table_teacher='teacher';

if ($v==0)
{
  $query_cluster='%%';
  $query_class=$class;
}

if ($v==1)
{
  $query_cluster=$cluster; 
  //$query_class=sprintf("%s%s",$class[0],'%%');  
  //$header_class=$class[0];
  $header_class=$grade;
  $query_class='%%'; 
}



$teacher_Stmt = "SELECT * from $table_teacher where
$table_teacher.login='%s'";

$student_Stmt = "SELECT * from $table_student, $table_school_student, 
$table_department_student, $table_class_student, $table_subject where 
$table_school_student.school='$school' and
$table_department_student.department='$department' and 
$table_class_student.grade='$grade'and
$table_class_student.class like '$query_class' and
$table_class_student.year='$school_year' and
$table_subject.subject='$subject' and
$table_subject.cluster like '$query_cluster' and
$table_subject.teacher='%s' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref and
$table_class_student.class_ref=$table_subject.class_ref  
order by $table_student.lastname, $table_student.firstname";


$report_Stmt="SELECT * from $table_marks where 
$table_marks.term='$term' and
$table_marks.subjects_ref='%d'";

//$skill_name_Stmt ="SELECT * from $table_skill where $table_skill.order='%d'order by $table_skill.code_order";

$categories_Stmt="SELECT * from $table_category where
$table_category.subjects_ref='%d' and
$table_category.skill='%s' and
$table_category.term<='$term' 
order by $table_category.term";

$score_Stmt="SELECT * from $table_year, $table_school, $table_score 
where $table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_score.year_ref and
$table_school.school='$school' and 
$table_year.year='$school_year'
order by $table_score.score";

$skill_Stmt="SELECT * from $table_year, $table_school, $table_skill 
where $table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_skill.year_ref and
$table_school.school='$school' and 
$table_year.year='$school_year'
order by $table_skill.number";

$skill_sub_Stmt="SELECT * from $table_skill, $table_sub_skill where
$table_skill.skill_ref=$table_sub_skill.skill_ref and
$table_skill.skill_ref='%d' order by $table_sub_skill.number";


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
$j=0;
while ($field_skill = mysql_fetch_object($result_skill))
{
  $skill_array[$j]=$field_skill->skill;
  $skill_ref_array[$j]=$field_skill->skill_ref;
  $j++;
}
mysql_free_result($result_skill); 
$skill_number=count($skill_array);


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

$table_skill_select=sprintf("
<tr>
  <td class=\"table_data_blue\">
     <font color=\"Blue\"><B>First name</B></font>
  </td>
  <td class=\"table_data_blue\">
     <font color=\"Blue\"><B>Last name</B></font>
  </td>
  <td class=\"table_data_blue\">
     <font color=\"Blue\"><B>Report</B></font>
  </td>
</tr>");

$explenation_table="";
$explenation_counter=0;

//student loop 
while (($field_student = mysql_fetch_object($result_student)))
{
  
  
  if (!($result_report= mysql_query(sprintf($report_Stmt,$field_student->subjects_ref), $link))) {
  DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;}
  $field_report = mysql_fetch_object($result_report);

  $data=new Smarty_NM(); 
  $font_color='blue';
  $data->assign("font_color",$font_color);
  $data->assign("col1",$field_student->firstname);
  $data->assign("col2",$field_student->lastname);
  $data->assign("col3",$field_report->report);
  if ($field_report->report<$mark_border)
  {
    $font_color='red';
  }
  $data->assign("font_color_report",$font_color);

  $table_skill_select.=$data->fetch("score_row.tpl");

  mysql_free_result($result_report);
  
  
  $explenation_row="";
  
  $i=0;
  while ($i<$skill_number) //loop for different available skills
  {
   //query_for different available sub skills
   if (!($result_sub_skill= mysql_query(sprintf($skill_sub_Stmt,$skill_ref_array[$i]), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $skill_name_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
   }
   $list_code='';
   $list_code[' ']=' '; //default is a space
   $sub_skill_number=0;
   while($field_sub_skill = mysql_fetch_object($result_sub_skill))
   {
     if ($explenation_counter==0)
     {
       $explenation_row.=sprintf("<tr><td class=\"table_data\">%s</td><td class=\"table_data\">%s</td></tr>",$field_sub_skill->code,$field_sub_skill->skill_sub);
     }
     $list_code["$field_sub_skill->code"]="$field_sub_skill->code";
     $sub_skill_number++;
   } 
   mysql_free_result($result_sub_skill);
   
   $skill_name=$skill_array[$i];
   if ($explenation_counter==0)
   {
     $explenation_header=sprintf("<TR bgcolor=\"#B8E7FF\"><td class=\"table_data\" colspan=\"2\"> %s </td></tr>",$skill_name);
     $explenation_table.=sprintf("%s",$explenation_header);
     $explenation_table.=sprintf("%s",$explenation_row); 
     $explenation_row="";
   }

   $b=($i%2);
   if ($b==0)
   $table_skill_select.=sprintf("<TR bgcolor=\"#B8E7FF\">");
   if ($b==1)
   $table_skill_select.=sprintf("<TR>");
   
   //check default values

   if (!($result_category=mysql_query(sprintf($categories_Stmt,$field_student->subjects_ref,$skill_name),$link)))
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
   $skill_input->assign("name",$skill_name);
   $score=sprintf("score[%d][%d]",$i,$field_student->subjects_ref);
   $skill_input->assign("score",$score);
   $skill_input->assign("score_options",$list_score);
   $skill_input->assign("default_score",$default_score);
   

   if ($sub_skill_number>0)
   {
     $code=sprintf("code[%d][%d]",$i,$field_student->subjects_ref);
     $skill_input->assign("code",$code);
     $skill_input->assign("code_options",$list_code);
     $skill_input->assign("default_code",$default_code);
     $table_skill_select.=$skill_input->fetch("skill_sub_skill.tpl");
   }
   if ($sub_skill_number==0)
   {
     $table_skill_select.=$skill_input->fetch("skill.tpl");
   }
   
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
 
 if ($v==0)
 { 
   $header=sprintf("%s %s %s Class: %s Term:%s Subject:%s Teacher:%s",$school,$school_year,$department,$class,$term,$subject,$user);
 }
 if ($v==1)
 { 
   $header=sprintf("%s %s %s Cluster: %s Term:%s Subject:%s Teacher:%s",$school,$school_year,$department,$cluster,$term,$subject,$user);
 } 


 $data->assign("header",$header);

 

 $data->assign("action",sprintf("add_score.php?v=$v&subject=$subject&cluster=$cluster&school=$school&department=$department&mark_border=$mark_border&grade=$grade&class=$class&school_year=$school_year&term=$term&default_selected_score=$default_selected_score&t=%d",time()));

 $data->display("score_select.tpl");
 
 mysql_free_result($result_student);  

?>