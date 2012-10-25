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
$userName="iqc";	
$password="TY8BqYRdn3Uhzq8T";	


$databaseName = "iqc"; 	   



$picture_dir="./pictures/";



?>
