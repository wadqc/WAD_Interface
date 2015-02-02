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
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

  

  if (!($result_select= $link->query(sprintf($select_Stmt,$gewenste_processen_id)))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($select_Stmt,$gewenste_processen_id) )) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
  }
  
  if (!($field_results = $result_select->fetch_object() ))
  {
   $initialen=$field_results->initialen;
  }
   
  $result_select->close();  
 

  
 
  $status=5;
  
  //update 
  if (!$link->query(sprintf($update_Stmt,$status,$gewenste_processen_id))) {
  DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($update_Stmt,$status,$gewenste_processen_id)  )) ;
  DisplayErrMsg(sprintf("error: %s", $link->error)) ;
  exit() ;
  }

  //delete
  if(!$link->query(sprintf($delete_Stmt,$gewenste_processen_id))) 
  {
    DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($delete_Stmt,$gewenste_processen_id) )) ;
    DisplayErrMsg(sprintf("error: %s", $link->error)) ;
    exit() ;
  } 

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  $executestring.= sprintf("show_results.php?selector_fk=%d&analyse_level=%s&gewenste_processen_id=-1&v=%d&t=%d",$selector_fk,$analyse_level,$v,time());
  header($executestring);
  exit();


?>