<?php 

require("../globals.php") ;
require("./common.php") ;
require("./selector_function.php") ;

require("./php/includes/setup.php");


$table_gewenste_processen='gewenste_processen';
$table_resultaten_status='resultaten_status';










  //Selector
  if (!empty($_GET['selector_fk']))
  {
    $selector_fk=$_GET['selector_fk'];
  }
  if (!empty($_GET['analyse_level']))
  {
    $analyse_level=$_GET['analyse_level'];
  }
  if (!empty($_GET['gewenste_processen_id']))
  {
    $gewenste_processen_id=$_GET['gewenste_processen_id'];
  }
  if (!empty($_POST['gewenste_processen_id']))
  {
    $gewenste_processen_id=$_POST['gewenste_processen_id'];
  }
  if (!empty($_GET['v']))
  {
    $v=$_GET['v'];
  }


$select_Stmt= "select * from $table_resultaten_status where $table_resultaten_status.gewenste_processen_fk='%d'";

$delete_Stmt = "delete from  $table_resultaten_status where $table_resultaten_status.gewenste_processen_fk='%d'";

$update_Stmt = "update $table_gewenste_processen set status='%d' where pk='%d'";



// Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

// Select the Database
  if (!mysql_select_db($databaseName, $link)) {
    DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }

  

  if (!($result_select= mysql_query(sprintf($select_Stmt,$gewenste_processen_id), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($select_Stmt,$gewenste_processen_id) )) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
  }
  
  if (!($field_results = mysql_fetch_object($result_select) ))
  {
   $initialen=$field_results->initialen;
  }
   
  mysql_free_result($result_select);  
 

  
 
  $status=5;
  
  //update 
  if (!mysql_query(sprintf($update_Stmt,$status,$gewenste_processen_id),$link)) {
  DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($update_Stmt,$status,$gewenste_processen_id)  )) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
  }

  //delete
  if(!mysql_query(sprintf($delete_Stmt,$gewenste_processen_id),$link)) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($delete_Stmt,$gewenste_processen_id) )) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  } 

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= sprintf("show_results.php?selector_fk=%d&analyse_level=%s&gewenste_processen_id=-1&v=%d&t=%d",$selector_fk,$analyse_level,$v,time());
  header($executestring);
  exit();


?>