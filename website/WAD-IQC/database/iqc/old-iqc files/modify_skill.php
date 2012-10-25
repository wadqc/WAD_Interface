<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$skill_ref=$_GET['skill_ref'];


$table_school='school';
$table_year='year';
$table_skill='skill';


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



$skill = new Smarty_NM();


//$skill->assign("time_skill",time());

$skill->assign("submit_value","Modify");  

  
  $skill_Stmt = "SELECT * from $table_school, $table_year, $table_skill where 
  $table_school.school_ref=$table_year.school_ref and
  $table_year.year_ref=$table_skill.year_ref and  
  $table_skill.skill_ref=$skill_ref";
 
  
  if (!($result_skill= mysql_query($skill_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
  if (!($field_skill = mysql_fetch_object($result_skill)))
  {
    DisplayErrMsg("Internal error: the entry does not exist") ;
    exit() ;
  }

  $skill->assign("default_number",$field_skill->number);
  $skill->assign("default_skill",$field_skill->skill);
  $skill->assign("default_abreviation",$field_skill->abreviation);


  $school_year=$field_skill->year;
    
  mysql_free_result($result_skill);


  
  $skill->assign("action_new_skill",sprintf("update_skill.php?school=$school&school_year=$school_year&skill_ref=$skill_ref&t=%d",time()));  
  $skill->assign("term",$school_year);

  $skill->display("new_skill.tpl");
 
?>











