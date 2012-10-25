<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$department=$_GET['department'];
$grade=$_GET['grade'];

$year_ref=$_GET['year_ref'];
$grade_ref=$_GET['grade_ref'];

$credits='';
if (!empty($_POST['credits']))
{
  $credits=$_POST['credits'];
}
$credit_max='';
if (!empty($_POST['credit_max']))
{
  $credit_max=$_POST['credit_max'];
}
$level_first='';
if (!empty($_POST['level_first']))
{
  $level_first=$_POST['level_first'];
}
$level_second='';
if (!empty($_POST['level_second']))
{
  $level_second=$_POST['level_second'];
}
$mark_border='';
if (!empty($_POST['mark_border']))
{
  $mark_border=$_POST['mark_border'];
}

$factor_1='';
if (!empty($_POST['factor_1']))
{
  $factor_1=serialize($_POST['factor_1']);
}
$factor_2='';
if (!empty($_POST['factor_2']))
{
  $factor_2=serialize($_POST['factor_2']);
}
$factor_3='';
if (!empty($_POST['factor_3']))
{
  $factor_3=serialize($_POST['factor_3']);
}
$factor_4='';
if (!empty($_POST['factor_4']))
{
  $factor_4=serialize($_POST['factor_4']);
}
$factor_5='';
if (!empty($_POST['factor_5']))
{
  $factor_5=serialize($_POST['factor_5']);
}
$factor_6='';
if (!empty($_POST['factor_6']))
{
  $factor_6=serialize($_POST['factor_6']);
}
$factor_7='';
if (!empty($_POST['factor_7']))
{
  $factor_7=serialize($_POST['factor_7']);
}
$factor_8='';
if (!empty($_POST['factor_8']))
{
  $factor_8=serialize($_POST['factor_8']);
}
$factor_9='';
if (!empty($_POST['factor_9']))
{
  $factor_9=serialize($_POST['factor_9']);
}
$factor_10='';
if (!empty($_POST['factor_10']))
{
  $factor_10=serialize($_POST['factor_10']);
}

$show_average_1='';
if (!empty($_POST['show_average_1']))
{
  $show_average_1=$_POST['show_average_1'];
}
$show_average_2='';
if (!empty($_POST['show_average_2']))
{
  $show_average_2=$_POST['show_average_2'];
}
$show_average_3='';
if (!empty($_POST['show_average_3']))
{
  $show_average_3=$_POST['show_average_3'];
}
$show_average_4='';
if (!empty($_POST['show_average_4']))
{
  $show_average_4=$_POST['show_average_4'];
}
$show_average_5='';
if (!empty($_POST['show_average_5']))
{
  $show_average_5=$_POST['show_average_5'];
}
$show_average_6='';
if (!empty($_POST['show_average_6']))
{
  $show_average_6=$_POST['show_average_6'];
}
$show_average_7='';
if (!empty($_POST['show_average_7']))
{
  $show_average_7=$_POST['show_average_7'];
}
$show_average_8='';
if (!empty($_POST['show_average_8']))
{
  $show_average_8=$_POST['show_average_8'];
}
$show_average_9='';
if (!empty($_POST['show_average_9']))
{
  $show_average_9=$_POST['show_average_9'];
}
$show_average_10='';
if (!empty($_POST['show_average_10']))
{
  $show_average_10=$_POST['show_average_10'];
}

$alternative_tittle_1='';
if (!empty($_POST['alternative_tittle_1']))
{
  $alternative_tittle_1=$_POST['alternative_tittle_1'];
}
$alternative_tittle_2='';
if (!empty($_POST['alternative_tittle_2']))
{
  $alternative_tittle_2=$_POST['alternative_tittle_2'];
}
$alternative_tittle_3='';
if (!empty($_POST['alternative_tittle_3']))
{
  $alternative_tittle_3=$_POST['alternative_tittle_3'];
}
$alternative_tittle_4='';
if (!empty($_POST['alternative_tittle_4']))
{
  $alternative_tittle_4=$_POST['alternative_tittle_4'];
}
$alternative_tittle_5='';
if (!empty($_POST['alternative_tittle_5']))
{
  $alternative_tittle_5=$_POST['alternative_tittle_5'];
}
$alternative_tittle_6='';
if (!empty($_POST['alternative_tittle_6']))
{
  $alternative_tittle_6=$_POST['alternative_tittle_6'];
}
$alternative_tittle_7='';
if (!empty($_POST['alternative_tittle_7']))
{
  $alternative_tittle_7=$_POST['alternative_tittle_7'];
}
$alternative_tittle_8='';
if (!empty($_POST['alternative_tittle_8']))
{
  $alternative_tittle_8=$_POST['alternative_tittle_8'];
}
$alternative_tittle_9='';
if (!empty($_POST['alternative_tittle_9']))
{
  $alternative_tittle_9=$_POST['alternative_tittle_9'];
}
$alternative_tittle_10='';
if (!empty($_POST['alternative_tittle_10']))
{
  $alternative_tittle_10=$_POST['alternative_tittle_10'];
}


$honor_term_1='1';
if (!empty($_POST['honor_term_1']))
{
  $honor_term_1=$_POST['honor_term_1'];
}
$honor_term_2='2';
if (!empty($_POST['honor_term_2']))
{
  $honor_term_2=$_POST['honor_term_2'];
}
$honor_term_3='3';
if (!empty($_POST['honor_term_3']))
{
  $honor_term_3=$_POST['honor_term_3'];
}
$honor_term_4='4';
if (!empty($_POST['honor_term_4']))
{
  $honor_term_4=$_POST['honor_term_4'];
}
$honor_term_5=5;
if (!empty($_POST['honor_term_5']))
{
  $honor_term_5=$_POST['honor_term_5'];
}
$honor_term_6=6;
if (!empty($_POST['honor_term_6']))
{
  $honor_term_6=$_POST['honor_term_6'];
}
$honor_term_7=7;
if (!empty($_POST['honor_term_7']))
{
  $honor_term_7=$_POST['honor_term_7'];
}
$honor_term_8=8;
if (!empty($_POST['honor_term_8']))
{
  $honor_term_8=$_POST['honor_term_8'];
}
$honor_term_9=9;
if (!empty($_POST['honor_term_9']))
{
  $honor_term_9=$_POST['honor_term_9'];
}
$honor_term_10=10;
if (!empty($_POST['honor_term_10']))
{
  $honor_term_10=$_POST['honor_term_10'];
}

$table_school='school';
$table_year='year';
$table_term='term';
$table_department='department';
$table_grade='grade';
$table_calculation_report='calculation_report';
$table_credits_report='credits_report';

$calculation_report_Stmt = "SELECT * from $table_calculation_report where
$table_calculation_report.grade_ref='%d' and 
$table_calculation_report.term='%d'";

$credits_report_Stmt = "SELECT * from $table_credits_report where
$table_credits_report.grade_ref='%d'";

$term_Stmt = "SELECT * from $table_term where 
$table_term.year_ref='%d'
order by $table_term.term";

$update_calculation_report_Stmt = "Update $table_calculation_report set term='%s', factor='%s',
alternative_tittle='%s', show_average='%s',honor_term='%s',grade_ref='%d' where  $table_calculation_report.calculation_report_ref='%d'";

$add_calculation_report_Stmt = "Insert into $table_calculation_report(term,factor,alternative_tittle,show_average,honor_term,grade_ref) values ('%s','%s','%s','%s','%s','%d')";

$update_credits_report_Stmt = "Update $table_credits_report set mark_border='%s', credits='%s', credit_max='%s',
level_second='%s', level_first='%s',grade_ref='%d' where  $table_credits_report.credits_report_ref='%d'";

$add_credits_report_Stmt = "Insert into $table_credits_report(mark_border,credits,credit_max,level_second,level_first,grade_ref) values ('%s','%s','%s','%s','%s','%d')";


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


if (!($result_term= mysql_query(sprintf($term_Stmt,$year_ref), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $COTG_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}
  
while ($field_term = mysql_fetch_object($result_term))
{
   // one row for each term
   if (!($result_calculation_report=
   mysql_query(sprintf($calculation_report_Stmt,$grade_ref,$field_term->term),$link)))
   {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
    $k=0;
    
    while ($field_calculation_report = mysql_fetch_object($result_calculation_report))
    {
      $k++;
      $calculation_report_ref=$field_calculation_report->calculation_report_ref;
    }
    if ($k==0)  // add calculation row
    {    
      if ($field_term->term==1)
      {
        if (!(mysql_query(sprintf($add_calculation_report_Stmt,$field_term->term,$factor_1,$alternative_tittle_1,$show_average_1,$honor_term_1,$grade_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==2)
      {
        if (!(mysql_query(sprintf($add_calculation_report_Stmt,$field_term->term,$factor_2,$alternative_tittle_2,$show_average_2,$honor_term_2,$grade_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==3)
      {
        if (!(mysql_query(sprintf($add_calculation_report_Stmt,$field_term->term,$factor_3,$alternative_tittle_3,$show_average_3,$honor_term_3,$grade_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==4)
      {
        if (!(mysql_query(sprintf($add_calculation_report_Stmt,$field_term->term,$factor_4,$alternative_tittle_4,$show_average_4,$honor_term_4,$grade_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==5)
      {
        if (!(mysql_query(sprintf($add_calculation_report_Stmt,$field_term->term,$factor_5,$alternative_tittle_5,$show_average_5,$honor_term_5,$grade_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==6)
      {
        if (!(mysql_query(sprintf($add_calculation_report_Stmt,$field_term->term,$factor_6,$alternative_tittle_6,$show_average_6,$honor_term_6,$grade_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==7)
      {
        if (!(mysql_query(sprintf($add_calculation_report_Stmt,$field_term->term,$factor_7,$alternative_tittle_7,$show_average_7,$honor_term_7,$grade_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==8)
      {
        if (!(mysql_query(sprintf($add_calculation_report_Stmt,$field_term->term,$factor_8,$alternative_tittle_8,$show_average_8,$honor_term_8,$grade_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==9)
      {
        if (!(mysql_query(sprintf($add_calculation_report_Stmt,$field_term->term,$factor_9,$alternative_tittle_9,$show_average_9,$honor_term_9,$grade_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==10)
      {
        if (!(mysql_query(sprintf($add_calculation_report_Stmt,$field_term->term,$factor_10,$alternative_tittle_10,$show_average_10,$honor_term_10,$grade_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
    } //end k==0 (add)

    if ($k==1)  // update calculation row
    {    
      if ($field_term->term==1)
      {
        if (!(mysql_query(sprintf($update_calculation_report_Stmt,$field_term->term,$factor_1,$alternative_tittle_1,$show_average_1,$honor_term_1,$grade_ref,$calculation_report_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==2)
      {
        if (!(mysql_query(sprintf($update_calculation_report_Stmt,$field_term->term,$factor_2,$alternative_tittle_2,$show_average_2,$honor_term_2,$grade_ref,$calculation_report_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==3)
      {
        if (!(mysql_query(sprintf($update_calculation_report_Stmt,$field_term->term,$factor_3,$alternative_tittle_3,$show_average_3,$honor_term_3,$grade_ref,$calculation_report_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==4)
      {
        if (!(mysql_query(sprintf($update_calculation_report_Stmt,$field_term->term,$factor_4,$alternative_tittle_4,$show_average_4,$honor_term_4,$grade_ref,$calculation_report_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==5)
      {
        if (!(mysql_query(sprintf($update_calculation_report_Stmt,$field_term->term,$factor_5,$alternative_tittle_5,$show_average_5,$honor_term_5,$grade_ref,$calculation_report_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==6)
      {
        if (!(mysql_query(sprintf($update_calculation_report_Stmt,$field_term->term,$factor_6,$alternative_tittle_6,$show_average_6,$honor_term_6,$grade_ref,$calculation_report_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==7)
      {
        if (!(mysql_query(sprintf($update_calculation_report_Stmt,$field_term->term,$factor_7,$alternative_tittle_7,$show_average_7,$honor_term_7,$grade_ref,$calculation_report_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==8)
      {
        if (!(mysql_query(sprintf($update_calculation_report_Stmt,$field_term->term,$factor_8,$alternative_tittle_8,$show_average_8,$honor_term_8,$grade_ref,$calculation_report_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==9)
      {
        if (!(mysql_query(sprintf($update_calculation_report_Stmt,$field_term->term,$factor_9,$alternative_tittle_9,$show_average_9,$honor_term_9,$grade_ref,$calculation_report_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
      if ($field_term->term==10)
      {
        if (!(mysql_query(sprintf($update_calculation_report_Stmt,$field_term->term,$factor_10,$alternative_tittle_10,$show_average_10,$honor_term_10,$grade_ref,$calculation_report_ref),$link))) 
        {
          DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
          exit() ;
        }
      }
    } //end k==0 (add)
}
mysql_free_result($result_term);


//credits section
$k=0;

if (!($result_credits= mysql_query(sprintf($credits_report_Stmt,$grade_ref),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
while ($field_credits = mysql_fetch_object($result_credits) )
{  
  $k++;
  $credits_report_ref=$field_credits->credits_report_ref;
}
if ($k==0) //add
{
  if (!(mysql_query(sprintf($add_credits_report_Stmt,$mark_border,$credits,$credit_max,$level_second,$level_first,$grade_ref),$link))) 
  {
     DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
     exit() ;
  }
}
if ($k==1) //update
{
  if (!(mysql_query(sprintf($update_credits_report_Stmt,$mark_border,$credits,$credit_max,$level_second,$level_first,$grade_ref,$credits_report_ref),$link))) 
  {
     DisplayErrMsg(sprintf("Error in delete onderzoek")) ;
     exit() ;
  }
}



  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("show_subjects_report.php?school=$school&school_year=$school_year&department=$department&grade=$grade&t=%d",time());
  header($executestring);
  exit();
  
?>