<?

require("../globals.php") ;
require("./common.php") ;

$school=$_GET['school'];
$school_year=$_GET['school_year'];
$year_ref=$_GET['year_ref'];
$score_ref=$_GET['score_ref'];

$description=$_POST['description'];
$score=$_POST['score'];
$selected_score='';
if (!empty($_POST['selected_score']))
{
  $selected_score=$_POST['selected_score'];
}


$table_score='score';

$updateStmt_score = "Update $table_score set
description='%s', score='%s', selected_score='%s' where
$table_score.score_ref='%d'";

$updateStmt_score_selected = "Update $table_score set
selected_score='' where
$table_score.selected_score='on' and  
$table_score.year_ref='%d'";



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


if ($selected_score=='on')
{
  //reset curent default values
  if (!(mysql_query(sprintf($updateStmt_score_selected,$year_ref), $link))) {
  DisplayErrMsg(sprintf("Error in executing %s stmt", $selectStmt_score)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
  }
}

if (!mysql_query(sprintf($updateStmt_score,$description,$score,$selected_score,$score_ref),$link)) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $updateStmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}

  $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
  
  $executestring.= sprintf("create_score.php?school=$school&school_year=$school_year&t=%d",time());
  header($executestring);
  exit();
?>














