<?php

error_reporting( E_ALL & ~E_NOTICE );


if (!session_id())
session_start();

  if(!empty($_SESSION['user_name']))
  {
    $user=$_SESSION['user_name'];
  }
  if(empty($_SESSION['user_name']))
  {
    $user=0;
  }



$hostName="localhost";		
$userName="wad";	
$password="wad";	


$databaseName = "iqc"; 	   



$picture_dir="./pictures/";


// number of mark colums for 1 term 
$mark_cols=8;

// number of exam colums 
$exam_cols=4;


//month (numerical) at which a new school year will start
$start_month=8;





//$school_list['SDHS']='SDHS';
//$fixed_school='SDHS';

?>
