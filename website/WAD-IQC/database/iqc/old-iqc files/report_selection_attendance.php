<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");
require("./../school_data.php") ;
require('./pdf/fpdf.php');

$v=$_GET['v'];
$school=$_GET['school'];
$school_year=$_GET['school_year'];

$attendance_month=$_POST['attendance_month'];
$attendance_day=$_POST['attendance_day'];

$table_school_school='school';
$table_school_year='year';
$table_school_term='term';
$table_school_department='department';
$table_school_grade='grade';
$table_school_class='class';

$table_student='student';
$table_school_student='school_student';
$table_department_student='department_student';
$table_class_student='class_student';
$table_presention_general='presention_general';



$term_Stmt = "SELECT * from $table_school_school, $table_school_year, $table_school_term where 
$table_school_school.school_ref=$table_school_year.school_ref and
$table_school_year.year_ref=$table_school_term.year_ref and
$table_school_school.school='$school' and
$table_school_year.year='$school_year'
order by $table_school_term.term";


$dep_Stmt = "SELECT * from $table_school_school,$table_school_year,$table_school_department where
$table_school_school.school_ref=$table_school_year.school_ref and 
$table_school_year.year_ref=$table_school_department.year_ref and
$table_school_school.school='%s' and
$table_school_year.year='%s'
order by $table_school_department.number";

$class_Stmt="SELECT * from $table_school_school,$table_school_year,$table_school_department,$table_school_grade,$table_school_class where
$table_school_school.school_ref=$table_school_year.school_ref and
$table_school_year.year_ref=$table_school_department.year_ref and
$table_school_department.department_ref=$table_school_grade.department_ref and
$table_school_grade.grade_ref=$table_school_class.grade_ref and
$table_school_school.school='$school' and
$table_school_year.year='$school_year' and 
$table_school_department.department='%s' 
order by $table_school_grade.grade, $table_school_class.number, $table_school_class.class"; 

$absent_day_Stmt = "SELECT $table_student.sex, sum($table_presention_general.absent_day) as sum_absent_day from $table_student,$table_school_student,
$table_department_student, $table_class_student, $table_presention_general where 
$table_school_student.school='$school' and
$table_department_student.department='%s' and 
$table_class_student.class='%s' and
$table_class_student.year='$school_year' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref and
$table_class_student.class_ref=$table_presention_general.class_ref and
$table_presention_general.date>='%s' and 
$table_presention_general.date<='%s'
group by $table_student.sex";


$absent_letter_day_Stmt = "SELECT $table_student.sex, sum($table_presention_general.absent_letter_day) as sum_absent_letter_day from $table_student,$table_school_student,
$table_department_student, $table_class_student, $table_presention_general where 
$table_school_student.school='$school' and
$table_department_student.department='%s' and 
$table_class_student.class='%s' and
$table_class_student.year='$school_year' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref and
$table_class_student.class_ref=$table_presention_general.class_ref and
$table_presention_general.date>='%s' and 
$table_presention_general.date<='%s'
group by $table_student.sex";



$student_count_start_Stmt = "SELECT $table_student.sex, count(distinct $table_student.number) as number_of_students from $table_student,$table_school_student,$table_department_student, $table_class_student where 
$table_class_student.year='$school_year' and
( $table_school_student.school_out ='0000-00-00' or $table_school_student.school_out >='%s') and $table_school_student.school_in<'%s' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref 
group by $table_student.sex";


$student_count_stop_Stmt = "SELECT $table_student.sex, count(distinct $table_student.number) as number_of_students from $table_student,$table_school_student,$table_department_student, $table_class_student where 
$table_class_student.year='$school_year' and
($table_school_student.school_out ='0000-00-00' or $table_school_student.school_out >'%s') and $table_school_student.school_in<='%s' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref 
group by $table_student.sex";


$student_in_Stmt = "SELECT * from $table_student,$table_school_student,$table_department_student, $table_class_student where 
$table_class_student.year='$school_year' and
$table_school_student.school_in>='%s' and
$table_school_student.school_in<='%s' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref 
order by $table_student.lastname";

$student_out_Stmt = "SELECT * from $table_student,$table_school_student,$table_department_student, $table_class_student where 
$table_class_student.year='$school_year' and
$table_school_student.school_out>='%s' and
$table_school_student.school_out<='%s' and
$table_student.student_ref=$table_school_student.student_ref and
$table_school_student.school_ref=$table_department_student.school_ref and
$table_department_student.department_ref=$table_class_student.department_ref 
order by $table_student.lastname";

//all above here is new



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

if (!($result_term= mysql_query($term_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$field = mysql_fetch_object($result_term); //only the first term
$start_date=$field->start_date;
mysql_free_result($result_term);

$start_year=substr($start_date,0,4);
$start_month=substr($start_date,5,2);
$start_day=substr($start_date,8,2);

$current_year=substr($school_year,0,4);

$start_stamp  = mktime(0, 0, 0, $start_month, $start_day, $start_year);
$current_stamp= mktime(0, 0, 0, $attendance_month, 15, $current_year);
$number_of_days=sprintf("%s",date("t",$current_stamp));
$current_stamp= mktime(0, 0, 0, $attendance_month, $number_of_days, $current_year);
if ($current_stamp<$start_stamp)
{
  $current_year=substr($school_year,5,4);
}





$current_stamp= mktime(0, 0, 0, $attendance_month,1, $current_year);
$number_of_days=sprintf("%s",date("t",$current_stamp));
$current_month_txt=sprintf("%s",date("F",$current_stamp));


$start_date=sprintf("%s-%s-%s",$current_year,$attendance_month,1);

$stop_date=sprintf("%s-%s-%s",$current_year,$attendance_month,$number_of_days);


$year = substr($start_date,0,4);
$position=strpos($start_date,'-',5);
$length=$position-5;
$string_length=strlen($start_date);
$month  = substr($start_date,5,$length);
$day = substr($start_date,5+$length+1,($string_length-6-$length));
$month_txt=date ("M",mktime(0,0,0,$month,$day,$year)); 
$start_date_txt=sprintf("%s-%s-%s",$month_txt,$day,$year); 

$year = substr($stop_date,0,4);
$position=strpos($stop_date,'-',5);
$length=$position-5;
$string_length=strlen($stop_date);
$month  = substr($stop_date,5,$length);
$day = substr($stop_date,5+$length+1,($string_length-6-$length));
$month_txt=date ("M",mktime(0,0,0,$month,$day,$year)); 
$stop_date_txt=sprintf("%s-%s-%s",$month_txt,$day,$year); 



if (!($result_dep= mysql_query(sprintf($dep_Stmt,$school,$school_year), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

$absent_male_total=0;
$absent_female_total=0; 
$data_row=new Smarty_NM();
$attendance_table=$data_row->fetch("attendance_report_row_header.tpl");
$j=0;
while (($field_dep = mysql_fetch_object($result_dep)))
{
  $department=$field_dep->department; 
  if (!($result_class= mysql_query(sprintf($class_Stmt,$department), $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  while (($field_class = mysql_fetch_object($result_class)))
  {
    $class=$field_class->class;
    $absent_day_male=0;
    $absent_day_female=0; 
    $b=($j%2);
    $bgcolor='';
    if ($b==0)
    {
      $bgcolor='#B8E7FF';
    }
    //printf("department=%s and class=%s",$department,$class);
    if (!($result_absent_day= mysql_query(sprintf($absent_day_Stmt,$department,$class,$start_date,$stop_date), $link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
    }
    while (($field_absent_day = mysql_fetch_object($result_absent_day)))
    {
      switch($field_absent_day->sex)
      {  
        case 'm': $absent_day_male=$absent_day_male+$field_absent_day->sum_absent_day;
                  break;
        case 'f': $absent_day_female=$absent_day_female+$field_absent_day->sum_absent_day;
                  break;
      } 
    } 
    mysql_free_result($result_absent_day);
    if (!($result_absent_letter_day= mysql_query(sprintf($absent_letter_day_Stmt,$department,$class,$start_date,$stop_date), $link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
    }
    while (($field_absent_letter_day = mysql_fetch_object($result_absent_letter_day)))
    {
      switch($field_absent_letter_day->sex)
      {
        case 'm': $absent_day_male=$absent_day_male+$field_absent_letter_day->sum_absent_letter_day;
                  break;
        case 'f': $absent_day_female=$absent_day_female+$field_absent_letter_day->sum_absent_letter_day;
                  break;
      }
    }
    mysql_free_result($result_absent_letter_day);

    $data_row=new Smarty_NM();
    $data_row->assign("bgcolor",$bgcolor); 
    $data_row->assign("department",$department);
    $data_row->assign("class",$class); 
    $data_row->assign("off_male",$absent_day_male);
    $data_row->assign("off_female",$absent_day_female);
    $total= $absent_day_male+$absent_day_female;
    $data_row->assign("off_total",$total);

    $attendance_table.=$data_row->fetch("attendance_report_row.tpl");
    
    $absent_male_total=$absent_male_total+$absent_day_male;
    $absent_female_total=$absent_female_total+$absent_day_female;
    $absent_male=0;
    $absent_female=0;  
    
    $j++;

  } 
  mysql_free_result($result_class);
}
mysql_free_result($result_dep);

$data_row=new Smarty_NM();
$data_row->assign("bgcolor",$bgcolor); 
$data_row->assign("department",'');
$data_row->assign("class","Total"); 
$data_row->assign("off_male",$absent_male_total);
$data_row->assign("off_female",$absent_female_total);
$total= $absent_male_total+$absent_female_total;
$data_row->assign("off_total",$total);

$attendance_table.=$data_row->fetch("attendance_report_sum_row.tpl");


//number of students start
$male_count=0;
$female_count=0;




if (!($result_student_count= mysql_query(sprintf($student_count_start_Stmt,$start_date,$start_date),$link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $student_count_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
    }
while (($field_student_count = mysql_fetch_object($result_student_count)))
{
  switch($field_student_count->sex)
  {  
     case 'm': $male_count=$field_student_count->number_of_students;
               break;
     case 'f': $female_count=$field_student_count->number_of_students;
               break;
  } 
} 
mysql_free_result($result_student_count);
$male_start=$male_count;
$female_start=$female_count;






// number of students end
$male_count=0;
$female_count=0;



if (!($result_student_count= mysql_query(sprintf($student_count_stop_Stmt,$stop_date,$stop_date),$link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $student_count_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
    }
while (($field_student_count = mysql_fetch_object($result_student_count)))
{
  switch($field_student_count->sex)
  {  
     case 'm': $male_count=$field_student_count->number_of_students;
               break;
     case 'f': $female_count=$field_student_count->number_of_students;
               break;
  } 
} 
mysql_free_result($result_student_count);
$male_stop=$male_count;


$female_stop=$female_count;



$percentage_male='0 %';
$percentage_female='0 %';
$percentage_total='0 %';

if ($male_start!=0)
{   
  $percentage_male=(100*$absent_male_total/($attendance_day*$male_start));
  $percentage_male=sprintf("%.1f %%",$percentage_male);
}
if ($female_start!=0)
{
  $percentage_female=(100*$absent_female_total/($attendance_day*$female_start));
  $percentage_female=sprintf("%.1f %%",$percentage_female);
}
if (($male_start+$female_start)!=0)
{
  $percentage_total=(100*$total/($attendance_day*($male_start+$female_start)));
  $percentage_total=sprintf("%.1f %%",$percentage_total);
}

$data_row=new Smarty_NM();
$data_row->assign("bgcolor",$bgcolor); 
$data_row->assign("department",'School days');
$data_row->assign("class",$attendance_day); 
$data_row->assign("off_male",$percentage_male);
$data_row->assign("off_female",$percentage_female);
$data_row->assign("off_total",$percentage_total);

$attendance_table.=$data_row->fetch("attendance_report_sum_row.tpl");


//written in

$student_in_table='';

if (!($result_student_in= mysql_query(sprintf($student_in_Stmt,$start_date,$stop_date),$link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $student_count_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
}

$j=0;
$male_count=0;
$female_count=0;
$in_comment='';
while (($field_student = mysql_fetch_object($result_student_in)))
{
   $b=($j%2);
   $bgcolor='';
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }
   if ($j==0)
   {  
     $data_row=new Smarty_NM();
     $student_in_table=$data_row->fetch("student_entry_attendance_row_header.tpl");
   }
   $home_address='';
   if ($field_student->lives_with!='')
   {  
     if ($field_student->lives_with=='Father')
     {
       $table_parents='father';
       $parent_student_link="$table_parents.father_ref=$table_student.father_ref";
       $student_link="$table_student.father_ref"; 
       $student_link_ref=$field_student->father_ref; 
     } 
     if ($field_student->lives_with=='Mother')
     {
       $table_parents='mother';
       $parent_student_link="$table_parents.mother_ref=$table_student.mother_ref";
       $student_link="$table_student.mother_ref"; 
       $student_link_ref=$field_student->mother_ref; 
     } 
     if ($field_student->lives_with=='Father & Mother')
     {
       $table_parents='father';
       $parent_student_link="$table_parents.father_ref=$table_student.father_ref";
       $student_link="$table_student.father_ref"; 
       $student_link_ref=$field_student->father_ref; 
     } 
     if ($field_student->lives_with=='Guardian')
     {
       $table_parents='guardian';
       $parent_student_link="$table_parents.guardian_ref=$table_student.guardian_ref";
       $student_link="$table_student.guardian_ref"; 
       $student_link_ref=$field_student->guardian_ref; 
     } 

     $parents_Stmt = "SELECT * from $table_student, $table_parents where $parent_student_link and $student_link='%d'";
     if (!($result_parents= mysql_query(sprintf($parents_Stmt,$student_link_ref), $link)))
     {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
     }
     $field_parents = mysql_fetch_object($result_parents);
     $home_address=$field_parents->home_address;
  } 
  mysql_free_result($result_parents);


  $data_row=new Smarty_NM();
  $data_row->assign("bgcolor",$bgcolor); 
  $data_row->assign("department",$field_student->department);
  $data_row->assign("class",$field_student->class); 
  $data_row->assign("date_in",$field_student->school_in);
  $data_row->assign("from",$field_student->comes_from);
  $data_row->assign("last",$field_student->lastname);
  $data_row->assign("first",$field_student->firstname);
  $data_row->assign("date",$field_student->date_of_birth);
  $data_row->assign("sex",$field_student->sex);
  $data_row->assign("address",$home_address);
  $data_row->assign("went_to",$field_student->went_to);
  $student_in_table.=$data_row->fetch("student_entry_attendance_row.tpl");

  switch($field_student->sex)
  {  
    case 'm': $male_count++;
              break;
    case 'f': $female_count++;
              break;
  } 
  $j++;
} 
if ($j>0)
{
  $in_comment=sprintf("(%sm / %sf)",$male_count,$female_count);
}

// written out



$student_out_table='';
if (!($result_student_out= mysql_query(sprintf($student_out_Stmt,$start_date,$stop_date),$link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $student_count_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
}

$j=0;
$male_count=0;
$female_count=0;
$out_comment='';
while (($field_student = mysql_fetch_object($result_student_out)))
{
   $b=($j%2);
   $bgcolor='';
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }
   if ($j==0)
   {  
     $data_row=new Smarty_NM();
     $student_out_table=$data_row->fetch("student_entry_attendance_row_header.tpl");
   }
   $home_address='';
   if ($field_student->lives_with!='')
   {  
     if ($field_student->lives_with=='Father')
     {
       $table_parents='father';
       $parent_student_link="$table_parents.father_ref=$table_student.father_ref";
       $student_link="$table_student.father_ref"; 
       $student_link_ref=$field_student->father_ref; 
     } 
     if ($field_student->lives_with=='Mother')
     {
       $table_parents='mother';
       $parent_student_link="$table_parents.mother_ref=$table_student.mother_ref";
       $student_link="$table_student.mother_ref"; 
       $student_link_ref=$field_student->mother_ref; 
     } 
     if ($field_student->lives_with=='Father & Mother')
     {
       $table_parents='father';
       $parent_student_link="$table_parents.father_ref=$table_student.father_ref";
       $student_link="$table_student.father_ref"; 
       $student_link_ref=$field_student->father_ref; 
     } 
     if ($field_student->lives_with=='Guardian')
     {
       $table_parents='guardian';
       $parent_student_link="$table_parents.guardian_ref=$table_student.guardian_ref";
       $student_link="$table_student.guardian_ref"; 
       $student_link_ref=$field_student->guardian_ref; 
     } 

     $parents_Stmt = "SELECT * from $table_student, $table_parents where $parent_student_link and $student_link='%d'";
     if (!($result_parents= mysql_query(sprintf($parents_Stmt,$student_link_ref), $link)))
     {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
     }
     $field_parents = mysql_fetch_object($result_parents);
     $home_address=$field_parents->home_address;
  } 
  mysql_free_result($result_parents);


  $data_row=new Smarty_NM();
  $data_row->assign("bgcolor",$bgcolor); 
  $data_row->assign("department",$field_student->department);
  $data_row->assign("class",$field_student->class); 
  $data_row->assign("date_in",$field_student->school_in);
  $data_row->assign("from",$field_student->comes_from);
  $data_row->assign("last",$field_student->lastname);
  $data_row->assign("first",$field_student->firstname);
  $data_row->assign("date",$field_student->date_of_birth);
  $data_row->assign("sex",$field_student->sex);
  $data_row->assign("address",$home_address);
  $data_row->assign("went_to",$field_student->went_to);
  $student_out_table.=$data_row->fetch("student_entry_attendance_row.tpl");

  switch($field_student->sex)
  {  
    case 'm': $male_count++;
              break;
    case 'f': $female_count++;
              break;
  } 
  $j++;
} 
if ($j>0)
{
  $out_comment=sprintf("(%sm / %sf)",$male_count,$female_count);
}





$report=new Smarty_NM();
$report->assign("picture_logo",$report_logo);
$header_name=sprintf("Attendance Report %s %s",$school,$school_year);   
$report->assign("header_name",$header_name);
$term_info=sprintf("period %s %s",$current_month_txt,$current_year);
$report->assign("term_info",$term_info);
$report->assign("attendance_list",$attendance_table);
$report->assign("start_date",$start_date_txt);
$report->assign("start_males",$male_start);
$report->assign("start_females",$female_start);
$report->assign("stop_date",$stop_date_txt);
$report->assign("stop_males",$male_stop);
$report->assign("stop_females",$female_stop);
$report->assign("in_comment",$in_comment);
$report->assign("student_in",$student_in_table);
$report->assign("out_comment",$out_comment);
$report->assign("student_out",$student_out_table);
$report->display("school_report_attendance.tpl");

?>
