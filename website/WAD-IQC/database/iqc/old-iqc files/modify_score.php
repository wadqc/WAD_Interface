<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$score_ref=$_GET['score_ref'];


$table_school='school';
$table_year='year';
$table_score='score';


// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",
                             $hostName, $userName)) ;
   exit() ;
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}



$score = new Smarty_NM();


//$score->assign("time_score",time());

$score->assign("submit_value","Modify");  

  
  $score_Stmt = "SELECT * from $table_school, $table_year, $table_score where 
  $table_school.school_ref=$table_year.school_ref and
  $table_year.year_ref=$table_score.year_ref and  
  $table_score.score_ref=$score_ref";
 
  
  if (!($result_score= mysql_query($score_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  if (!($field_score = mysql_fetch_object($result_score)))
  {
    DisplayErrMsg("Internal error: the entry does not exist") ;
    exit() ;
  }

  $score->assign("default_description",$field_score->description);
  $score->assign("default_score",$field_score->score);
  $default_selected_score='';
  if ($field_score->selected_score=='on')
  {
    $default_selected_score='checked';
  }
  $score->assign("default_selected_score",$default_selected_score);
  
  $school_year=$field_score->year;
  
  $year_ref=$field_score->year_ref;
  
  mysql_free_result($result_score);


  
  $score->assign("action_new_score",sprintf("update_score.php?school=$school&school_year=$school_year&year_ref=$year_ref&score_ref=$score_ref&t=%d",time()));  
  $score->assign("header",sprintf("Modify Score") );

  $score->display("new_score.tpl");
 
?>











