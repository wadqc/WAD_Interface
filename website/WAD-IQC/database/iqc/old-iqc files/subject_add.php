<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$school=$_GET['school'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$class=$_GET['class'];
$grade=$_GET['grade'];
$submit_value=$_POST['submit_button'];

if ($submit_value=='Customize')
{
  $flag=0;
} 
if ($submit_value=='Preset')
{
  $flag=1;
} 

if (!empty($_POST['subject']))
{
$subject=$_POST['subject'];
}
if (!empty($_POST['teacher']))
{
$teacher=$_POST['teacher'];
}
if (!empty($_POST['cluster']))
{
$cluster=$_POST['cluster'];
}

if (!empty($_POST['subject_all']))
{
$subject_all=$_POST['subject_all'];
}
if (!empty($_POST['teacher_all']))
{
$teacher_all=$_POST['teacher_all'];
}
if (!empty($_POST['cluster_all']))
{
$cluster_all=$_POST['cluster_all'];
}
//$subject_start=$_GET['subject_start'];
//$subject_stop=$_GET['subject_stop'];
//$subject_number=$_GET['subject_number'];
//if (!empty($_POST['down_x']))
//{
//  $subject_start=$subject_start-$subjects_step;
//  $subject_stop=$subject_stop-$subjects_step;
//  if ($subject_start<0)
//  {
//    $subject_start=0;
//    $subject_stop=$subjects_step;
//  }
//}
//
//if (!empty($_POST['up_x']))
//{
//  $subject_start=$subject_start+$subjects_step;
//  $subject_stop=$subject_stop+$subjects_step;
//  if ($subject_stop>$subject_number)
//  {
//    $subject_start=$subject_number-$subjects_step;
//    $subject_stop=$subject_number;
//  }
//}



$table_subjects='subjects';
$table_marks='marks';

$update_Stmt = "Update $table_subjects set subject='%s', teacher='%s',
cluster='%s', class_ref='%s' where  $table_subjects.subjects_ref='%d'";

$add_Stmt = "Insert into $table_subjects(subject,teacher,cluster,class_ref) values ('%s','%s','%s','%d')";

$delete_Stmt_subject = "DELETE from $table_subjects WHERE
$table_subjects.class_ref='%d' and $table_subjects.subject='%s'";

$delete_Stmt_marks = "DELETE from $table_marks WHERE $table_marks.subjects_ref='%d'";


$select_Stmt = "select * from $table_subjects WHERE
$table_subjects.class_ref='%d' and 
$table_subjects.subject='%s' ";

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

  $class_ref_key=array_keys($teacher);
  
  $first_key=$class_ref_key[0];
  $subject_key=array_keys($teacher[$first_key]);
 
if ($flag==0)
{
 
  $i=0;
  while ($i<sizeof($class_ref_key)) // loop for $class_ref
  {
    $j=0;
    while ($j<sizeof($subject_key)) //loop for $subject
    { 
      
      if (!($result_subject= mysql_query(sprintf($select_Stmt,$class_ref_key[$i],$subject_key[$j]),$link))) 
      {
         DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
         DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
         exit() ;
      }
      
      $subject_counter=0;
      while($field_subject = mysql_fetch_object($result_subject))
      {
        $subject_counter++;
        $subjects_ref=$field_subject->subjects_ref;
      }
      mysql_free_result($result_subject);
      if (!empty($subject[$class_ref_key[$i]][$subject_key[$j]]))
      {
        //option 1 if subject=on and subject does not excist -->add new
        if (($subject[$class_ref_key[$i]][$subject_key[$j]]=='on')&&($subject_counter==0))
        {
          if (!(mysql_query(sprintf($add_Stmt,$subject_key[$j],$teacher[$class_ref_key[$i]][$subject_key[$j]],$cluster[$class_ref_key[$i]][$subject_key[$j]],$class_ref_key[$i]),$link))) 
          {
            DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
            exit() ;
          }
          
        }
         
        //option 2 if subject=on and subject does excist -->update
        if (($subject[$class_ref_key[$i]][$subject_key[$j]]=='on')&&($subject_counter==1))
        {
          if (!(mysql_query(sprintf($update_Stmt,$subject_key[$j],$teacher[$class_ref_key[$i]][$subject_key[$j]],$cluster[$class_ref_key[$i]][$subject_key[$j]],$class_ref_key[$i],$subjects_ref),$link))) 
          {
            DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
            exit() ;
          }

        }
      }
       
      //option 3 if subject!=on and subject does excist
      if (empty($subject[$class_ref_key[$i]][$subject_key[$j]])&&($subject_counter==1))
      {
        //delete marks
        if (!(mysql_query(sprintf($delete_Stmt_marks,$field_subject->subjects_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
        //delete subject

        if (!(mysql_query(sprintf($delete_Stmt_subject,$class_ref_key[$i],$subject_key[$j]),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      
      $j++;
    }
 
   $i++;
  }

}
//
if ($flag==1)
{
  $select_class_ref_id=-1;
  $i=0;
  while ($i<sizeof($class_ref_key)) // loop for $class_ref
  {
    $j=0;
    while ($j<sizeof($subject_key)) //loop for $subject
    {
      if (!($result_subject= mysql_query(sprintf($select_Stmt,$class_ref_key[$i],$subject_key[$j]),$link))) 
      {
         DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
         DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
         exit() ;
      }
      $subject_counter=0;
      while($field_subject = mysql_fetch_object($result_subject))
      {
        $subject_counter++;
        $subjects_ref=$field_subject->subjects_ref;
      }
      mysql_free_result($result_subject);
      
      if (!empty($subject_all[$select_class_ref_id][$subject_key[$j]])) 
      {
        //option 1 subject does not excist -->add new
        if ($subject_counter==0)
        {
          if (!(mysql_query(sprintf($add_Stmt,$subject_key[$j],$teacher_all[$select_class_ref_id][$subject_key[$j]],$cluster_all[$select_class_ref_id][$subject_key[$j]],$class_ref_key[$i]),$link))) 
          {
            DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
            exit() ;
          }
        }
         
        //option 2 if subject does excist -->update
        if ($subject_counter==1)
        {
          if (!(mysql_query(sprintf($update_Stmt,$subject_key[$j],$teacher_all[$select_class_ref_id][$subject_key[$j]],$cluster_all[$select_class_ref_id][$subject_key[$j]],$class_ref_key[$i],$subjects_ref),$link))) 
          {
            DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
            exit() ;
          }
        }
      }
       
      //option 3 if subject!=on and subject does excist
      if (empty($subject_all[$select_class_ref_id][$subject_key[$j]])&&($subject_counter==1))
      {
        //delete exam marks for future needs to be placed here


        //delete marks
        if (!(mysql_query(sprintf($delete_Stmt_marks,$subjects_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
        //delete subject

        if (!(mysql_query(sprintf($delete_Stmt_subject,$class_ref_key[$i],$subject_key[$j]),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($subject_counter>1)
      {      
        printf("subject_counter=%d",$subject_counter);
        exit();
      }      
      $j++;
    }
    
   $i++;
  }

}




//



  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= sprintf("subject_selection.php?grade=$grade&department=$department&class=$class&school_year=$school_year&school=$school&t=%d",time());

  //$executestring.= sprintf("subject_selection.php?grade=$grade&department=$department&class=$class&school_year=$school_year&school=$school&subject_start=$subject_start&subject_stop=$subject_stop&t=%d",time());
  
  header($executestring);
  exit();
  
  
  
?>