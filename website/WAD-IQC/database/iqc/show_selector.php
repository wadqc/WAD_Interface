<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$table_selector='selector';


$v=$_GET['v'];


$selector_Stmt="SELECT * from $table_selector
order by $table_selector.name"; 


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

if (!($result_selector= mysql_query($selector_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selector_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


$table_selector='';

$status=5;

$j=0;
while (($field_selector = mysql_fetch_object($result_selector)))
{
  
   $b=($j%2);
   $bgcolor=''; 
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }   

   $table_data = new Smarty_NM();
   
   if ($j==0) //define header data
   {
     $table_selector=$table_data->fetch("selector_result_header.tpl");
   }

   $action=sprintf("show_results.php?selector_fk=%d&analyse_level=%s&gewenste_processen_id=-1&status=$status&v=$v&t=%d",$field_selector->pk,$field_selector->analyselevel,time()); 
   //$action=sprintf("show_results_taste2.php?selector_fk=%d&analyse_level=%s&gewenste_processen_id=-1&t=%d",$field_selector->pk,$field_selector->analyselevel,time());   

   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("selector",$field_selector->name);
   $table_data->assign("description",$field_selector->description);
   $table_data->assign("action_selector",$action);
      
   $table_selector.=$table_data->fetch("selector_select_row.tpl");

   $j++;
}


mysql_free_result($result_selector);  

$data = new Smarty_NM();
$data->assign("Title","Selector Results");
$data->assign("header","");
$data->assign("selector_list",$table_selector);

$data->display("selector_result.tpl");





?>