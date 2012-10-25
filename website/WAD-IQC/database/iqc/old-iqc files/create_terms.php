<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$school=$_GET['school'];

if (!empty($_GET['school_year']))
{
  $school_year=$_GET['school_year'];
}



$table_school='school';
$table_year='year';
$table_term='term';



$term_Stmt = "SELECT * from $table_school,$table_year,$table_term where 
$table_school.school_ref=$table_year.school_ref and
$table_year.year_ref=$table_term.year_ref and
$table_school.school='$school' and
$table_year.year='$school_year' and 
$table_term.term='%d'
order by $table_term.term";


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

$start_year = substr($school_year,0,4);   
$end_year  = substr($school_year,5,4); 

$term_key=array_keys($term_list);

$data_header = new Smarty_NM();
$data_header->assign("bg_color","#B8E7FF");
$table_term=$data_header->fetch("term_header_row.tpl");
$i=0;
while ($i<sizeof($term_key)) // loop for $term_key
{ 
  if (!($result_term=mysql_query(sprintf($term_Stmt,$term_key[$i]),$link))) {
  DisplayErrMsg(sprintf("Error in executing %s stmt", $term_Stmt)) ;
  DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
  exit() ;
  }
  $checked_term='';
  $checked_lock='';
  $start_date='--';
  $stop_date='--';
  while ($field_term = mysql_fetch_object($result_term))
  {
    $checked_term='checked';
    $start_date=$field_term->start_date;
    $stop_date=$field_term->stop_date;
    if ($field_term->locked=='on')
    {
      $checked_lock='checked';
    }
  }
  mysql_free_result($result_term);
  $b=($i%2);
  if ($b==0)
  {
     $bg_color='#B8E7FF';
  }
  if ($b==1)
  {
     $bgcolor='';
  }
  $data_row = new Smarty_NM();
  $data_row->assign("bg_color","#B8E7FF");
  $data_row->assign("checked_term",$checked_term);
  $start_prefix=sprintf("start_date_%d_",$term_key[$i]);
  $stop_prefix=sprintf("stop_date_%d_",$term_key[$i]);
  $data_row->assign("start_prefix",$start_prefix);
  $data_row->assign("stop_prefix",$stop_prefix);
  $term=sprintf("term[%d]",$term_key[$i]);
  $lock=sprintf("lock[%d]",$term_key[$i]);
  $data_row->assign("term",$term);
  $data_row->assign("lock",$lock);
  $data_row->assign("term_name",$term_key[$i]);
  $data_row->assign("start_year",$start_year);
  $data_row->assign("end_year",$end_year); 

  $data_row->assign("start_date",$start_date);
  $data_row->assign("stop_date",$stop_date);  
  $data_row->assign("checked_lock",$checked_lock);
  $table_term.=$data_row->fetch("term_row.tpl");
  $i++;
} 

$data = new Smarty_NM();
$header=sprintf("%s %s",$school,$school_year);
$data->assign("header",$header);
$data->assign("term_list",$table_term);
$form_action=sprintf("update_term.php?school=$school&school_year=$school_year&t=%d",time());
$data->assign("form_action",$form_action);
$data->display("term_select.tpl");

?>



 
  
