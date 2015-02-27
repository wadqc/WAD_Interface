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
    //$executestring = sprintf("Location: http://%s/",$_SERVER['HTTP_HOST'].$_SERVER['CONTEXT_PREFIX']);
    $executestring.= sprintf("Location: ../../../WAD-IQC/database/login/main_login_iqc.php?message=$message");
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


$hostName="localhost";		
$userName="iqc";	
$password="TY8BqYRdn3Uhzq8T";	

$databaseName = "iqc"; 	   

// Version of WAD_Interface
$version = "1.1.0";



$picture_root="./../../";
$picture_root_pdf="./../../../";

$default_picture_height='200';


$report_result_header_color='#ACC9FF';//#8DB5FF'
$report_category_header_color='#A0FAAD';
$report_skill_color='#DCEBF5'; //'#CBDCF5';
$report_term_color='#DCEBF5';
$report_average_color='#CBDCF5';





$analyselevel_list['study']='study';
$analyselevel_list['series']='series';
$analyselevel_list['instance']='instance';

$groups_list['0'] = '';
$groups_list['1'] = 'categorie';
$groups_list['2'] = 'modaliteit';
$groups_list['3'] = 'lokatie';

$qc_frequency_list['NULL']='';
$qc_frequency_list['1']='dagelijks';
$qc_frequency_list['7']='wekelijks';
$qc_frequency_list['14']='tweewekelijks';
$qc_frequency_list['30']='maandelijks';
$qc_frequency_list['91']='kwartaal';
$qc_frequency_list['365']='jaarlijks';


//mail settings


$mail_host = "smtp.mz.local";
$mail_port = "25";
//als authorisatie bij de mailserver nodig is dan ook onderstaande parameters invullen
$mail_auth = "0";
$mail_username = "";
$mail_password = "";


?>
