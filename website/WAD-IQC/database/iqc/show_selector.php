<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$table_selector='selector';


$v=$_GET['v'];


$selector_Stmt="SELECT * from $table_selector
order by $table_selector.name"; 


// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!($result_selector= $link->query($selector_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selector_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}


$table_selector='';

$status=5;

$j=0;
while (($field_selector = $result_selector->fetch_object()))
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


$result_selector->close();  

$data = new Smarty_NM();
$data->assign("Title","Selector Results");
$data->assign("header","");
$data->assign("selector_list",$table_selector);

$data->display("selector_result.tpl");





?>