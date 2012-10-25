<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$cluster=$_GET['cluster'];
$term=$_GET['term'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$school=$_GET['school'];
$grade=$_GET['grade'];
$class=$_GET['class'];
$subject=$_GET['subject'];
$mark_border=$_GET['mark_border'];
$v=$_GET['v'];

$offset=0;
if (!empty($_POST['new_row']))
{
  $offset=1;
}


if (!empty($_POST['description']))
{ 
  $description=$_POST['description'];
}

if (!empty($_POST['weigth']))
{ 
  $weigth=$_POST['weigth'];
}

if (!empty($_POST['mark']))
{ 
  $mark=$_POST['mark'];
}

$date_0_Year='';
$date_0_Month='';
$date_0_Day='';
$date_1_Year='';
$date_1_Month='';
$date_1_Day='';
$date_2_Year='';
$date_2_Month='';
$date_2_Day='';
$date_3_Year='';
$date_3_Month='';
$date_3_Day='';
$date_4_Year='';
$date_4_Month='';
$date_4_Day='';
$date_5_Year='';
$date_5_Month='';
$date_5_Day='';
$date_6_Year='';
$date_6_Month='';
$date_6_Day='';
$date_7_Year='';
$date_7_Month='';
$date_7_Day='';
$date_8_Year='';
$date_8_Month='';
$date_8_Day='';
$date_9_Year='';
$date_9_Month='';
$date_9_Day='';
$date_10_Year='';
$date_10_Month='';
$date_10_Day='';
$date_11_Year='';
$date_11_Month='';
$date_11_Day='';
$date_12_Year='';
$date_12_Month='';
$date_12_Day='';
$date_13_Year='';
$date_13_Month='';
$date_13_Day='';
$date_14_Year='';
$date_14_Month='';
$date_14_Day='';
$date_15_Year='';
$date_15_Month='';
$date_15_Day='';
$date_16_Year='';
$date_16_Month='';
$date_16_Day='';
$date_17_Year='';
$date_17_Month='';
$date_17_Day='';
$date_18_Year='';
$date_18_Month='';
$date_18_Day='';

if (!empty($_POST['date_0_Day']))
{ 
   $date_0_Day=$_POST['date_0_Day'];
}
if (!empty($_POST['date_0_Month']))
{ 
  $date_0_Month=$_POST['date_0_Month'];
}
if (!empty($_POST['date_0_Year']))
{ 
  $date_0_Year=$_POST['date_0_Year'];
}
if (!empty($_POST['date_1_Day']))
{ 
  $date_1_Day=$_POST['date_1_Day'];
}
if (!empty($_POST['date_1_Month']))
{ 
  $date_1_Month=$_POST['date_1_Month'];
}
if (!empty($_POST['date_1_Year']))
{ 
  $date_1_Year=$_POST['date_1_Year'];
}

if (!empty($_POST['date_2_Day']))
{ 
  $date_2_Day=$_POST['date_2_Day'];
}
if (!empty($_POST['date_2_Month']))
{ 
  $date_2_Month=$_POST['date_2_Month'];
}
if (!empty($_POST['date_2_Year']))
{ 
  $date_2_Year=$_POST['date_2_Year'];
}

if (!empty($_POST['date_3_Day']))
{ 
  $date_3_Day=$_POST['date_3_Day'];
}
if (!empty($_POST['date_3_Month']))
{ 
  $date_3_Month=$_POST['date_3_Month'];
}
if (!empty($_POST['date_3_Year']))
{ 
  $date_3_Year=$_POST['date_3_Year'];
}

if (!empty($_POST['date_4_Day']))
{ 
  $date_4_Day=$_POST['date_4_Day'];
}
if (!empty($_POST['date_4_Month']))
{ 
  $date_4_Month=$_POST['date_4_Month'];
}
if (!empty($_POST['date_4_Year']))
{ 
  $date_4_Year=$_POST['date_4_Year'];
}

if (!empty($_POST['date_5_Day']))
{ 
  $date_5_Day=$_POST['date_5_Day'];
}
if (!empty($_POST['date_5_Month']))
{ 
  $date_5_Month=$_POST['date_5_Month'];
}
if (!empty($_POST['date_5_Year']))
{ 
  $date_5_Year=$_POST['date_5_Year'];
}

if (!empty($_POST['date_6_Day']))
{ 
  $date_6_Day=$_POST['date_6_Day'];
}
if (!empty($_POST['date_6_Month']))
{ 
  $date_6_Month=$_POST['date_6_Month'];
}
if (!empty($_POST['date_6_Year']))
{ 
  $date_6_Year=$_POST['date_6_Year'];
}

if (!empty($_POST['date_7_Day']))
{ 
  $date_7_Day=$_POST['date_7_Day'];
}
if (!empty($_POST['date_7_Month']))
{ 
  $date_7_Month=$_POST['date_7_Month'];
}
if (!empty($_POST['date_7_Year']))
{ 
  $date_7_Year=$_POST['date_7_Year'];
}

if (!empty($_POST['date_8_Day']))
{ 
  $date_8_Day=$_POST['date_8_Day'];
}
if (!empty($_POST['date_8_Month']))
{ 
  $date_8_Month=$_POST['date_8_Month'];
}
if (!empty($_POST['date_8_Year']))
{ 
  $date_8_Year=$_POST['date_8_Year'];
}

if (!empty($_POST['date_9_Day']))
{ 
  $date_9_Day=$_POST['date_9_Day'];
}
if (!empty($_POST['date_9_Month']))
{ 
  $date_9_Month=$_POST['date_9_Month'];
}
if (!empty($_POST['date_9_Year']))
{ 
  $date_9_Year=$_POST['date_9_Year'];
}

if (!empty($_POST['date_10_Day']))
{ 
  $date_10_Day=$_POST['date_10_Day'];
}
if (!empty($_POST['date_10_Month']))
{ 
  $date_10_Month=$_POST['date_10_Month'];
}
if (!empty($_POST['date_10_Year']))
{ 
  $date_10_Year=$_POST['date_10_Year'];
}

if (!empty($_POST['date_11_Day']))
{ 
  $date_11_Day=$_POST['date_11_Day'];
}
if (!empty($_POST['date_11_Month']))
{ 
  $date_11_Month=$_POST['date_11_Month'];
}
if (!empty($_POST['date_11_Year']))
{ 
  $date_11_Year=$_POST['date_11_Year'];
}

if (!empty($_POST['date_12_Day']))
{ 
  $date_12_Day=$_POST['date_12_Day'];
}
if (!empty($_POST['date_12_Month']))
{ 
  $date_12_Month=$_POST['date_12_Month'];
}
if (!empty($_POST['date_12_Year']))
{ 
  $date_12_Year=$_POST['date_12_Year'];
}

if (!empty($_POST['date_13_Day']))
{ 
  $date_13_Day=$_POST['date_13_Day'];
}
if (!empty($_POST['date_13_Month']))
{ 
  $date_13_Month=$_POST['date_13_Month'];
}
if (!empty($_POST['date_13_Year']))
{ 
  $date_13_Year=$_POST['date_13_Year'];
}

if (!empty($_POST['date_14_Day']))
{ 
  $date_14_Day=$_POST['date_14_Day'];
}
if (!empty($_POST['date_14_Month']))
{ 
  $date_14_Month=$_POST['date_14_Month'];
}
if (!empty($_POST['date_14_Year']))
{ 
  $date_14_Year=$_POST['date_14_Year'];
}

if (!empty($_POST['date_15_Day']))
{ 
  $date_15_Day=$_POST['date_15_Day'];
}
if (!empty($_POST['date_15_Month']))
{ 
  $date_15_Month=$_POST['date_15_Month'];
}
if (!empty($_POST['date_15_Year']))
{ 
  $date_15_Year=$_POST['date_15_Year'];
}

if (!empty($_POST['date_16_Day']))
{ 
  $date_16_Day=$_POST['date_16_Day'];
}
if (!empty($_POST['date_16_Month']))
{ 
  $date_16_Month=$_POST['date_16_Month'];
}
if (!empty($_POST['date_16_Year']))
{ 
  $date_16_Year=$_POST['date_16_Year'];
}

if (!empty($_POST['date_16_Year']))
{ 
  $date_16_Year=$_POST['date_16_Year'];
}


$table_marks='marks';

$add_Stmt_mark = "Insert into $table_marks(term,col,description,date,mark,mark_r,weigth,report,average,mark_int,weigth_int,report_int,subjects_ref) values ('%s','%d','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d','%d')";


$select_Stmt_mark_temp="Select * from $table_marks";

$select_Stmt_mark = "Select * from $table_marks where 
$table_marks.col='%d' and 
$table_marks.term='%s' and
$table_marks.subjects_ref='%d'";

$update_Stmt_mark = "Update $table_marks set 
description='%s',
date='%s', mark='%s', mark_r='%s', weigth='%s', report='%s', average='%s', mark_int='%d', weigth_int='%d', report_int='%d' where 
col='%d' and
term='%s' and
subjects_ref='%d'";

$delete_Stmt_mark = "DELETE from $table_marks WHERE 
$table_marks.col='%d'and
$table_marks.term='%s'and
$table_marks.subjects_ref='%d'";


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


//temp

//$table_marks='marks';

//$select_Stmt_mark_temp="Select * from $table_marks";

//$update_Stmt_mark_temp = "Update $table_marks set 
//mark_int='%d', weigth_int='%d', report_int='%d' where 
//marks_ref='%d'";

//if (!($result_marks=mysql_query($select_Stmt_mark_temp,$link))) 
//       {
//         DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
//         exit() ;
//       }        
//       while($marks_field = mysql_fetch_object($result_marks))
//       { 
//          $mark_int=intval($marks_field->mark);
//          $weigth_int=intval($marks_field->weigth);
//          $report_int=intval($marks_field->report);
//         if (!(mysql_query(sprintf($update_Stmt_mark_temp,$mark_int,$weigth_int,$report_int,$marks_field->marks_ref),$link))) 
//           {
//             DisplayErrMsg(sprintf("Error in %s",$addStmt)) ;
//             exit() ;
//           }
//       } 
//       mysql_free_result($result_marks);
//
//exit();
//temp





  $subjects_ref_key=array_keys($mark);
  
  $first_key=$subjects_ref_key[0];

  $col_ref_key=array_keys($mark[$first_key]);





  //calculating report
  $report_sum=0;
  $report_number=0;
  $i=0;
  while ($i<sizeof($subjects_ref_key)) // loop for $subjects_ref
  {
    $mark_temp=0;
    $weigth_temp=0;
    $j=0;
    while ($j<sizeof($col_ref_key)) //loop for mark_cols
    {
      if (!empty($mark[$subjects_ref_key[$i]][$col_ref_key[$j]])) 
      {
        sscanf($mark[$subjects_ref_key[$i]][$col_ref_key[$j]],"%d",&$H_mark);
        if (!empty($weigth[$col_ref_key[$j]])) 
        {
          sscanf($weigth[$col_ref_key[$j]],"%d",&$weigth_value);       
          $mark_temp=$mark_temp+($H_mark*$weigth_value);
          $weigth_temp=$weigth_temp+$weigth_value;
        }
      }
      $j++;
    }
    $report[$i]="-";
    if (($mark_temp>0)&&($weigth_temp>0))
    {
      $report_temp=($mark_temp/$weigth_temp);
      $report[$i]=sprintf("%.0f",$report_temp);
      
      $report_sum+=$report[$i];
      $report_number+=1;
    }
    //printf("i=%d and report=%s",$i,$report[$i]);
    $i++;

  }
  $report_average='-';
  if (($report_sum>0)&&($report_number>0))
  {
    $report_temp=($report_sum/$report_number);
    $report_average=sprintf("%.0f",$report_temp);
  }

  //writing data to the database
  $i=0;
  while ($i<sizeof($subjects_ref_key)) // loop for $subjects_ref
  {
    $j=0;
    while ($j<sizeof($col_ref_key)) //loop for mark_cols
    {
       if ($col_ref_key[$j]==0)
       {
          $date=sprintf("%s-%s-%s",$date_0_Year,$date_0_Month,$date_0_Day);
       }
       if ($col_ref_key[$j]==1)
       {
          $date=sprintf("%s-%s-%s",$date_1_Year,$date_1_Month,$date_1_Day);
       }
       if ($col_ref_key[$j]==2)
       {
          $date=sprintf("%s-%s-%s",$date_2_Year,$date_2_Month,$date_2_Day);
       }
       if ($col_ref_key[$j]==3)
       {
          $date=sprintf("%s-%s-%s",$date_3_Year,$date_3_Month,$date_3_Day);
       }
       if ($col_ref_key[$j]==4)
       {
          $date=sprintf("%s-%s-%s",$date_4_Year,$date_4_Month,$date_4_Day);
       }
       if ($col_ref_key[$j]==5)
       {
          $date=sprintf("%s-%s-%s",$date_5_Year,$date_5_Month,$date_5_Day);
       }
       if ($col_ref_key[$j]==6)
       {
          $date=sprintf("%s-%s-%s",$date_6_Year,$date_6_Month,$date_6_Day);
       }
       if ($col_ref_key[$j]==7)
       {
          $date=sprintf("%s-%s-%s",$date_7_Year,$date_7_Month,$date_7_Day);
       }
       if ($col_ref_key[$j]==8)
       {
          $date=sprintf("%s-%s-%s",$date_8_Year,$date_8_Month,$date_8_Day);
       }
       if ($col_ref_key[$j]==9)
       {
          $date=sprintf("%s-%s-%s",$date_9_Year,$date_9_Month,$date_9_Day);
       }
       if ($col_ref_key[$j]==10)
       {
          $date=sprintf("%s-%s-%s",$date_10_Year,$date_10_Month,$date_10_Day);
       }
       if ($col_ref_key[$j]==11)
       {
          $date=sprintf("%s-%s-%s",$date_11_Year,$date_11_Month,$date_11_Day);
       }
       if ($col_ref_key[$j]==12)
       {
          $date=sprintf("%s-%s-%s",$date_12_Year,$date_12_Month,$date_12_Day);
       }
       if ($col_ref_key[$j]==13)
       {
          $date=sprintf("%s-%s-%s",$date_13_Year,$date_13_Month,$date_13_Day);
       }
       if ($col_ref_key[$j]==14)
       {
          $date=sprintf("%s-%s-%s",$date_14_Year,$date_14_Month,$date_14_Day);
       }
       if ($col_ref_key[$j]==15)
       {
          $date=sprintf("%s-%s-%s",$date_15_Year,$date_15_Month,$date_15_Day);
       }
       //rebuild all marks (new and modified) for subjects_ref equal to $subjects_ref[$i]
       
       //verify if mark excists
       if (!($result_col=mysql_query(sprintf($select_Stmt_mark,$col_ref_key[$j],$term,$subjects_ref_key[$i]),$link))) 
       {
         DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
         exit() ;
       }        
       $col_excist=0;
       while($field_col = mysql_fetch_object($result_col))
       {
         $col_excist=1;
       } 
       mysql_free_result($result_col);
       //printf("i=%d and col_excist=%d",$i,$col_excist);

       if (empty($mark[$subjects_ref_key[$i]][$col_ref_key[$j]]))
       {
         if ($col_excist==1) //delete col
         {         
           if (!(mysql_query(sprintf($delete_Stmt_mark,$col_ref_key[$j],$term,$subjects_ref_key[$i]),$link))) 
           {
             DisplayErrMsg(sprintf("Error in delete onderzoek"));
             exit() ;
           }        
         }
       }
      
       if (!empty($mark[$subjects_ref_key[$i]][$col_ref_key[$j]]))
       {
         if ($col_excist==1) //update col
         {  
            $mark_int=intval($mark[$subjects_ref_key[$i]][$col_ref_key[$j]]);
            $weigth_int=intval($weigth[$col_ref_key[$j]]);
            $report_int=intval($report[$i]);
          
           if (!(mysql_query(sprintf($update_Stmt_mark,$description[$col_ref_key[$j]],$date,$mark[$subjects_ref_key[$i]][$col_ref_key[$j]],"",$weigth[$col_ref_key[$j]],$report[$i],$report_average,$mark_int,$weigth_int,$report_int,$col_ref_key[$j],$term,$subjects_ref_key[$i]),$link))) 
           {
             DisplayErrMsg(sprintf("Error in %s",$addStmt)) ;
             exit() ;
           }
         }
          

         if ($col_excist==0) //create col
         { 
            $mark_int=intval($mark[$subjects_ref_key[$i]][$col_ref_key[$j]]);
            $weigth_int=intval($weigth[$col_ref_key[$j]]);
            $report_int=intval($report[$i]);
        
           if (!(mysql_query(sprintf($add_Stmt_mark,$term,$col_ref_key[$j],$description[$col_ref_key[$j]],$date,$mark[$subjects_ref_key[$i]][$col_ref_key[$j]],"",$weigth[$col_ref_key[$j]],$report[$i],$report_average,$mark_int,$weigth_int,$report_int,$subjects_ref_key[$i]),$link))) 
           {
             DisplayErrMsg(sprintf("Error in %s",$addStmt)) ;
             exit() ;
           }
         }
       }
       $j++;
    }
    $i++;
  }
  
  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("marks_select.php?school_year=$school_year&school=$school&department=$department&mark_border=$mark_border&grade=$grade&class=$class&subject=$subject&cluster=$cluster&term=$term&v=$v&offset=$offset&t=%d",time());
  
  
  header($executestring);
  exit();
?>