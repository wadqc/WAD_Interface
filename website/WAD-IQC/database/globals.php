<?php


global $PHP_SELF;
require_once("global_functions.php");



error_reporting( E_ALL & ~E_NOTICE );

//verify user login

if (!session_id())
session_start();

  if(!empty($_SESSION['user_name']))
  {
    $user=$_SESSION['user_name'];
  }
  if(empty($_SESSION['user_name']))
  {
    $user='0';
  }
  if ($user=='0')
  {
    $message=sprintf("Unauthorised visitor!");
    $executestring = sprintf("Location: http://%s/",$_SERVER['HTTP_HOST']);
    $executestring.= sprintf("database/login/main_login_open_school.php?message=$message");
    header($executestring);
    exit();
  }
  if(!empty($_SESSION['level_1']))
  {
     $user_level_1=$_SESSION['level_1'];
  }
  if(!empty($_SESSION['level_2']))
  {
     $user_level_2=$_SESSION['level_2'];
  }
  if(!empty($_SESSION['level_3']))
  {
     $user_level_3=$_SESSION['level_3'];
  }
  if(!empty($_SESSION['level_4']))
  {
     $user_level_4=$_SESSION['level_4'];
  }
  if(!empty($_SESSION['level_5']))
  {
     $user_level_5=$_SESSION['level_5'];
  }
  if(!empty($_SESSION['login_school_name']))
  {
    $login_school_name=$_SESSION['login_school_name'];
  }
  if(!empty($_SESSION['login_school_year']))
  {
    $login_school_year=$_SESSION['login_school_year'];
  }

//verify character input

if (strcasecmp('post',$_SERVER['REQUEST_METHOD']))
{
   $_POST=sanitize($_POST);
}
else if (strcasecmp('get',$_SERVER['REQUEST_METHOD']))
{
   $_GET=sanitize($_GET);
}
else
{
   printf(error);
   exit();
}
$_COOKIE=sanitize($_COOKIE);




 

$site_dir="WAD-IQC";

//$site_root="c:/xampp/htdocs";
$site_root="c:/WAD-software/WAD_Interface";
$hostName="localhost";		
$userName="iqc";	
$password="TY8BqYRdn3Uhzq8T";	

$databaseName = "iqc"; 	   



$picture_root="./../../";
$picture_root_pdf="./../../../";

$default_picture_height='200';

$logo_shirt="logo_shirt.jpg";



// number of description colums
$class_cols=8;

// number of subject colums
$subject_cols=25;


$department_year_list['1999-2000']='1999-2000';
$department_year_list['2000-2001']='2000-2001';
$department_year_list['2001-2002']='2001-2002';
$department_year_list['2002-2003']='2002-2003';
$department_year_list['2003-2004']='2003-2004';
$department_year_list['2004-2005']='2004-2005';
$department_year_list['2005-2006']='2005-2006';
$department_year_list['2006-2007']='2006-2007';
$department_year_list['2007-2008']='2007-2008';
$department_year_list['2008-2009']='2008-2009';
$department_year_list['2009-2010']='2009-2010';
$department_year_list['2010-2011']='2010-2011';
$department_year_list['2011-2012']='2011-2012';
$department_year_list['2012-2013']='2012-2013';
$department_year_list['2013-2014']='2013-2014';
$department_year_list['2014-2015']='2014-2015';
$term_list['1']='1';
$term_list['2']='2';
$term_list['3']='3';
$term_list['4']='4';
$term_list['5']='5';
$term_list['6']='6';

$cluster_list['1']='1';
$cluster_list['2']='2';
$cluster_list['3']='3';
$cluster_list['4']='4';
$cluster_list['5']='5';

$class_hours_list['0']=' ';
$class_hours_list['1']='1';
$class_hours_list['2']='2';
$class_hours_list['3']='3';
$class_hours_list['4']='4';
$class_hours_list['5']='5';
$class_hours_list['6']='6';
$class_hours_list['7']='7';
$class_hours_list['8']='8';
$class_hours_list['9']='9';
$class_hours_list['D']='D';

$junior='1';

$version='v18052012';
$pdf_format='Letter';

$pattern_length=6;

$max_grades=6;

$report_result_header_color='#ACC9FF';//#8DB5FF'
$report_category_header_color='#A0FAAD';
$report_skill_color='#DCEBF5'; //'#CBDCF5';
$report_term_color='#DCEBF5';
$report_average_color='#CBDCF5';



$report_title['1']='1st';
$report_title['2']='2nd';
$report_title['3']='3rd';
$report_title['4']='4th';
$report_title['5']='5th';
$report_title['6']='6th';

$month['1']='January';
$month['2']='February';
$month['3']='March';
$month['4']='April';
$month['5']='May';
$month['6']='June';
$month['7']='July';
$month['8']='August';
$month['9']='September';
$month['10']='October';
$month['11']='November';
$month['12']='December';

//$school_list['SDHS']='SDHS';
//$fixed_school='SDHS';

?>
