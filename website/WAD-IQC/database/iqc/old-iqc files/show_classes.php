<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$v=$_GET['v'];
$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];

$new_student_ref=''; 
if (!empty($_GET['new_student_ref']))
{
 $new_student_ref=$_GET['new_student_ref']; 
}

$table_school='school';
$table_year='year';
$table_department='department';
$table_grade='grade';
$table_class='class';


$class_Stmt="SELECT * from $table_school,$table_year,$table_department,$table_grade,$table_class where
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_department.year_ref and
$table_department.department_ref=$table_grade.department_ref and
$table_grade.grade_ref=$table_class.grade_ref and
$table_school.school='$school' and
$table_year.year='$school_year' and 
$table_department.department='%s' and
$table_grade.grade='%d'
order by $table_class.number, $table_class.class"; 

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



 $content="";
 
 $i=1;
 while ($i<$max_grades+1)
 {

   if (!($result_class= mysql_query(sprintf($class_Stmt,$department,$i), $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
   }
   
   $previous=$content;
   $content.=sprintf("<tr><td class=\"table_data_blue\">Class %d </td>",$i);  
   
   $j=0;
   while (($field_class = mysql_fetch_object($result_class)))
   {
     //(* main menu school)
     if ($v==5) //report card(template) (* main menu school)
     {
       if ($j==0) //the first class defines the grade
       {
          $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
          href=\"show_subjects_report.php?grade=%s&department=%s&school_year=%s&school=%s\">Grade
   %s</a></td>",$field_class->grade,$department,$school_year,$school,$field_class->grade);
       }
     }
     if ($v==6)//exam card(template) (* main menu school)
     {
       if ($j==0) //the first class defines the grade
       {
          $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
          href=\"show_subjects_exam.php?grade=%s&department=%s&school_year=%s&school=%s\">Grade
   %s</a></td>",$field_class->grade,$department,$school_year,$school,$field_class->grade);
       }
     }
     
     //(* main menu students) 
     if ($v==201)//students (* main menu students) 
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
   href=\"show_students.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$v,$school,$field_class->class);
     }
     if ($v==202)//subjects (* main menu students) 
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
   href=\"subject_selection.php?grade=%s&department=%s&class=%s&school_year=%s&school=%s&subject_start=%d&subject_stop=%d\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$school,0,$subjects_step,$field_class->class);
     }
     if ($v==203)//mentor (* main menu students) 
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
   href=\"mentor_selection.php?grade=%s&department=%s&class=%s&school_year=%s&school=%s\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$school,$field_class->class);
     }
     if ($v==204)//Admin (* main menu students) 
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
   href=\"student_admin_selection.php?grade=%s&department=%s&class=%s&school_year=%s&school=%s\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$school,$field_class->class);
     }
     if ($v==205)//ID cards (* main menu students) 
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
   href=\"create_id_cards_pdf.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s\"
   target=\"_blank\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$v,$school,$field_class->class);     
     }
     
     //(* main menu results)

     if ($v==301)//marks (* main menu results)
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
   href=\"subject.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$v,$school,$field_class->class);
     }
     if ($v==302)//Score (* main menu results)
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
   href=\"subject.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$v,$school,$field_class->class);
     }
     if ($v==303)//Exam marks (* main menu results)
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
   href=\"subject.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$v,$school,$field_class->class);
     }
     if ($v==304)//Credits (* main menu results) 
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\" href=\"credit.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$v,$school,$field_class->class);
     }
     //(* main menu reports)
     if ($v==401)//Term (* main menu reports)
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
     href=\"report_term_select.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$v,$school,$field_class->class);
     }
     if ($v==402)//Meeting (* main menu reports)
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
     href=\"report_term_select.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$v,$school,$field_class->class);
     }
     //(* main menu attendance)
     if ($v==501)//Class (* main menu attendance)
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
   href=\"general_presention.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s\" target=\"_blank\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$v,$school,$field_class->class);
     }
     if ($v==502)//Subject (* main menu attendance)
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
   href=\"subject.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s\" target=\"_blank\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$v,$school,$field_class->class);
     }
     if ($v==503)//Student (* main menu attendance)
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
   href=\"report_term_select.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$v,$school,$field_class->class);

//"view_presention_show_students.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$v,$school,$field_class->class);
     }
     if ($v==600)//Exams
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
   href=\"subject.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$v,$school,$field_class->class);
     }
     
     
     if ($v==13)//grades
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
     href=\"show_grades.php?grade=%s&department=%s&class=%s&school_year=%s&school=%s\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$school,$field_class->class);
     }
    
     if (($v>=60)&&($v<=70))//link parental data
     {
     $content.=sprintf("<td bgcolor=\"blue\"><a class=\"menu\"
   href=\"show_students_parental_link.php?grade=%s&department=%s&class=%s&school_year=%s&v=%d&school=%s&new_student_ref=%s\">%s</a></td>",$field_class->grade,$department,$field_class->class,$school_year,$v,$school,$new_student_ref,$field_class->class);
     }








     $j++;
   }
   if ($j>0)    
   {
      $content.=sprintf("</tr>");
   }
   if ($j==0)
   {
     $content=$previous; 
   }
   mysql_free_result($result_class);  
   
   $i++;

 } 
 $dep_table = new Smarty_NM();
 
 $dep_table->assign("klassen",$content);

 $header=sprintf("%s %s %s",$school,$school_year,$department);
 $dep_table->assign("header",$header);

 $dep_table->display("show_classes.tpl"); 

?>
