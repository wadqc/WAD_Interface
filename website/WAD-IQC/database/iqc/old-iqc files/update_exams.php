<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$cluster=$_GET['cluster'];
$subject=$_GET['subject'];
$department=$_GET['department'];
$school_year=$_GET['school_year'];
$school=$_GET['school'];
$class=$_GET['class'];
$v=$_GET['v'];

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

if (!empty($_POST['retry']))
{ 
  $retry=$_POST['retry'];
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
$date_19_Year='';
$date_19_Month='';
$date_19_Day='';
$date_20_Year='';
$date_20_Month='';
$date_20_Day='';
$date_21_Year='';
$date_21_Month='';
$date_21_Day='';
$date_22_Year='';
$date_22_Month='';
$date_22_Day='';
$date_23_Year='';
$date_23_Month='';
$date_23_Day='';
$date_24_Year='';
$date_24_Month='';
$date_24_Day='';
$date_25_Year='';
$date_25_Month='';
$date_25_Day='';
$date_26_Year='';
$date_26_Month='';
$date_26_Day='';
$date_27_Year='';
$date_27_Month='';
$date_27_Day='';
$date_28_Year='';
$date_28_Month='';
$date_28_Day='';


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

if (!empty($_POST['date_17_Day']))
{ 
  $date_17_Day=$_POST['date_17_Day'];
}
if (!empty($_POST['date_17_Month']))
{ 
  $date_17_Month=$_POST['date_17_Month'];
}
if (!empty($_POST['date_17_Year']))
{ 
  $date_17_Year=$_POST['date_17_Year'];
}

if (!empty($_POST['date_18_Day']))
{ 
  $date_18_Day=$_POST['date_18_Day'];
}
if (!empty($_POST['date_18_Month']))
{ 
  $date_18_Month=$_POST['date_18_Month'];
}
if (!empty($_POST['date_18_Year']))
{ 
  $date_18_Year=$_POST['date_18_Year'];
}

if (!empty($_POST['date_19_Day']))
{ 
  $date_19_Day=$_POST['date_19_Day'];
}
if (!empty($_POST['date_19_Month']))
{ 
  $date_19_Month=$_POST['date_19_Month'];
}
if (!empty($_POST['date_19_Year']))
{ 
  $date_19_Year=$_POST['date_19_Year'];
}

if (!empty($_POST['date_20_Day']))
{ 
  $date_20_Day=$_POST['date_20_Day'];
}
if (!empty($_POST['date_20_Month']))
{ 
  $date_20_Month=$_POST['date_20_Month'];
}
if (!empty($_POST['date_20_Year']))
{ 
  $date_20_Year=$_POST['date_20_Year'];
}

if (!empty($_POST['date_21_Day']))
{ 
  $date_21_Day=$_POST['date_21_Day'];
}
if (!empty($_POST['date_21_Month']))
{ 
  $date_21_Month=$_POST['date_21_Month'];
}
if (!empty($_POST['date_21_Year']))
{ 
  $date_21_Year=$_POST['date_21_Year'];
}

if (!empty($_POST['date_22_Day']))
{ 
  $date_22_Day=$_POST['date_22_Day'];
}
if (!empty($_POST['date_22_Month']))
{ 
  $date_22_Month=$_POST['date_22_Month'];
}
if (!empty($_POST['date_22_Year']))
{ 
  $date_22_Year=$_POST['date_22_Year'];
}

if (!empty($_POST['date_23_Day']))
{ 
  $date_23_Day=$_POST['date_23_Day'];
}
if (!empty($_POST['date_23_Month']))
{ 
  $date_23_Month=$_POST['date_23_Month'];
}
if (!empty($_POST['date_23_Year']))
{ 
  $date_23_Year=$_POST['date_23_Year'];
}

if (!empty($_POST['date_24_Day']))
{ 
  $date_24_Day=$_POST['date_24_Day'];
}
if (!empty($_POST['date_24_Month']))
{ 
  $date_24_Month=$_POST['date_24_Month'];
}
if (!empty($_POST['date_24_Year']))
{ 
  $date_24_Year=$_POST['date_24_Year'];
}

if (!empty($_POST['date_25_Day']))
{ 
  $date_25_Day=$_POST['date_25_Day'];
}
if (!empty($_POST['date_25_Month']))
{ 
  $date_25_Month=$_POST['date_25_Month'];
}
if (!empty($_POST['date_25_Year']))
{ 
  $date_25_Year=$_POST['date_25_Year'];
}


$table_exam_marks='exam_marks';
$table_exam_template='exam_template';


$addStmt = "Insert into $table_exam_marks(col,description,date,mark,mark_r,weigth,report,subjects_ref) values ('%d','%s','%s','%s','%s','%s','%s','%d')";

$deleteStmt = "DELETE from $table_exam_marks WHERE $table_exam_marks.subjects_ref='%d'";


$template_Stmt="SELECT * from $table_exam_template where $table_exam_template.order='%d'";

$template_counter_Stmt="SELECT * from $table_exam_template order by $table_exam_template.order";

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

    $max_counter=0;

    if (!($result_template_counter= mysql_query($template_counter_Stmt, $link))) {
       DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
       DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
       exit() ;
       }
    while($field_template = mysql_fetch_object($result_template_counter))
    {
      $retry_array[$max_counter]=$field_template->retry;
      $description[$max_counter]=$field_template->description;
      $max_counter++;
    }
    mysql_free_result($result_template_counter); 




  $subjects_ref_key=array_keys($mark);
  
  $first_key=$subjects_ref_key[0];
  
  //calculating report
  $i=0;
  while ($i<sizeof($subjects_ref_key)) // loop for $subjects_ref
  {
    $mark_temp=0;
    $weigth_temp=0;
    $j=0;
    while ($j<$max_counter) //loop for $mark_cols
    {
      if (!empty($mark[$subjects_ref_key[$i]][$j])) 
      {
        sscanf($mark[$subjects_ref_key[$i]][$j],"%d",&$H_mark);
        if (!empty($weigth[$j])) 
        {
          sscanf($weigth[$j],"%d",&$weigth_value);       
          
          if (!empty($retry[$subjects_ref_key[$i]][$j])) 
          {
            sscanf($retry[$subjects_ref_key[$i]][$j],"%d",&$R_mark);
            if ($H_mark<$R_mark)
            {
              $H_mark=$R_mark;
            }
          }
        
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
    }
    $i++;
  }

  //writing data to the database
  $i=0;
  while ($i<sizeof($subjects_ref_key)) // loop for $subjects_ref
  {
    //delete all excisting marks for subjects_ref equal to $subjects_ref[$i]
    if (!(mysql_query(sprintf($deleteStmt,$subjects_ref_key[$i]),$link))) 
    {
      DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
      exit() ;
    }

    $j=0;
    while ($j<$max_counter) //loop for $exam_cols
    {
       if ($j==0)
       {
          $date=sprintf("%s-%s-%s",$date_0_Year,$date_0_Month,$date_0_Day);
       }
       if ($j==1)
       {
          $date=sprintf("%s-%s-%s",$date_1_Year,$date_1_Month,$date_1_Day);
       }
       if ($j==2)
       {
          $date=sprintf("%s-%s-%s",$date_2_Year,$date_2_Month,$date_2_Day);
       }
       if ($j==3)
       {
          $date=sprintf("%s-%s-%s",$date_3_Year,$date_3_Month,$date_3_Day);
       }
       if ($j==4)
       {
          $date=sprintf("%s-%s-%s",$date_4_Year,$date_4_Month,$date_4_Day);
       }
       if ($j==5)
       {
          $date=sprintf("%s-%s-%s",$date_5_Year,$date_5_Month,$date_5_Day);
       }
       if ($j==6)
       {
          $date=sprintf("%s-%s-%s",$date_6_Year,$date_6_Month,$date_6_Day);
       }
       if ($j==7)
       {
          $date=sprintf("%s-%s-%s",$date_7_Year,$date_7_Month,$date_7_Day);
       }
       if ($j==8)
       {
          $date=sprintf("%s-%s-%s",$date_8_Year,$date_8_Month,$date_8_Day);
       }
       if ($j==9)
       {
          $date=sprintf("%s-%s-%s",$date_9_Year,$date_9_Month,$date_9_Day);
       }
       if ($j==10)
       {
          $date=sprintf("%s-%s-%s",$date_10_Year,$date_10_Month,$date_10_Day);
       }
       if ($j==11)
       {
          $date=sprintf("%s-%s-%s",$date_11_Year,$date_11_Month,$date_11_Day);
       }
       if ($j==12)
       {
          $date=sprintf("%s-%s-%s",$date_12_Year,$date_12_Month,$date_12_Day);
       }
       if ($j==13)
       {
          $date=sprintf("%s-%s-%s",$date_13_Year,$date_13_Month,$date_13_Day);
       }
       if ($j==14)
       {
          $date=sprintf("%s-%s-%s",$date_14_Year,$date_14_Month,$date_14_Day);
       }
       if ($j==15)
       {
          $date=sprintf("%s-%s-%s",$date_15_Year,$date_15_Month,$date_15_Day);
       }
       if ($j==16)
       {
          $date=sprintf("%s-%s-%s",$date_16_Year,$date_16_Month,$date_16_Day);
       }
       if ($j==17)
       {
          $date=sprintf("%s-%s-%s",$date_17_Year,$date_17_Month,$date_17_Day);
       }
       if ($j==18)
       {
          $date=sprintf("%s-%s-%s",$date_18_Year,$date_18_Month,$date_18_Day);
       }
       if ($j==19)
       {
          $date=sprintf("%s-%s-%s",$date_19_Year,$date_19_Month,$date_19_Day);
       }
       if ($j==20)
       {
          $date=sprintf("%s-%s-%s",$date_20_Year,$date_20_Month,$date_20_Day);
       }
       if ($j==21)
       {
          $date=sprintf("%s-%s-%s",$date_21_Year,$date_21_Month,$date_21_Day);
       }
       if ($j==22)
       {
          $date=sprintf("%s-%s-%s",$date_22_Year,$date_22_Month,$date_22_Day);
       }
       if ($j==23)
       {
          $date=sprintf("%s-%s-%s",$date_23_Year,$date_23_Month,$date_23_Day);
       }
       if ($j==24)
       {
          $date=sprintf("%s-%s-%s",$date_24_Year,$date_24_Month,$date_24_Day);
       }
       if ($j==25)
       {
          $date=sprintf("%s-%s-%s",$date_25_Year,$date_25_Month,$date_25_Day);
       }
       if ($j==26)
       {
          $date=sprintf("%s-%s-%s",$date_26_Year,$date_26_Month,$date_26_Day);
       }
       if ($j==27)
       {
          $date=sprintf("%s-%s-%s",$date_27_Year,$date_27_Month,$date_27_Day);
       }
       if ($j==28)
       {
          $date=sprintf("%s-%s-%s",$date_28_Year,$date_28_Month,$date_28_Day);
       }
       if ($j==29)
       {
          $date=sprintf("%s-%s-%s",$date_29_Year,$date_29_Month,$date_29_Day);
       }
       if ($j==30)
       {
          $date=sprintf("%s-%s-%s",$date_30_Year,$date_30_Month,$date_30_Day);
       }
       if ($j==31)
       {
          $date=sprintf("%s-%s-%s",$date_31_Year,$date_31_Month,$date_31_Day);
       }
 

       //rebuild all marks (new and modified) for subjects_ref equal to $subjects_ref[$i]
       
       if (empty($mark[$subjects_ref_key[$i]][$j]))
       {
         $mark[$subjects_ref_key[$i]][$j]='';
       }
       if (empty($retry[$subjects_ref_key[$i]][$j]))
       {
         $retry[$subjects_ref_key[$i]][$j]='';
       }

       if ($retry_array[$j]>0)
       {
         if (!(mysql_query(sprintf($addStmt,$j,$description[$j],$date,$mark[$subjects_ref_key[$i]][$j],$retry[$subjects_ref_key[$i]][$j],$weigth[$j],$report[$i],$subjects_ref_key[$i]),$link))) 
         {
           DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
           exit() ;
         }
       }
       if ($retry_array[$j]==0)
       {
         if (!(mysql_query(sprintf($addStmt,$j,$description[$j],$date,$mark[$subjects_ref_key[$i]][$j],"",$weigth[$j],$report[$i],$subjects_ref_key[$i]),$link))) 
         {
           DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
           exit() ;
         }
       }


       $j++;
    }

    $i++;
  }

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= sprintf("exam_select.php?school_year=$school_year&school=$school&department=$department&class=$class&subject=$subject&cluster=$cluster&v=$v&t=%d",time());
  header($executestring);
  exit();

?>