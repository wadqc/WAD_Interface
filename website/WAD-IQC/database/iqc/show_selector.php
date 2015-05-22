<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$table_selector='selector';
$table_selector_categorie='selector_categorie';
$table_selector_user='selector_user';
$table_users='users';
$table_gewenste_processen='gewenste_processen';
$v=$_GET['v'];


//$selector_Stmt="SELECT $table_selector.pk as 'pk', $table_selector.name as 'name', $table_selector.description as 'description', $table_selector.analyselevel as 'analyselevel',$table_selector_categorie.omschrijving as 'omschrijving' from $table_selector inner join $table_selector_categorie on 
//$table_selector.selector_categorie_fk=$table_selector_categorie.pk
//order by $table_selector.name"; 

$selector_Stmt="SELECT $table_selector.pk as 'pk', $table_selector.name as 'name', $table_selector.description as 'description', $table_selector.analyselevel as 'analyselevel',
$table_selector.modaliteit as 'modaliteit', $table_selector.lokatie as 'lokatie', $table_selector.qc_frequentie as 'qc_frequentie', $table_selector_user.selector_pk as 'selector_pk',
$table_selector_categorie.omschrijving as 'category',$table_gewenste_processen.creation_time 
from ((($table_selector left join $table_selector_categorie on $table_selector.selector_categorie_fk=$table_selector_categorie.pk) left join $table_gewenste_processen on $table_selector.pk=$table_gewenste_processen.selector_fk ) inner join $table_selector_user on $table_selector.pk=$table_selector_user.selector_pk) inner join $table_users on $table_selector_user.user_pk=$table_users.pk where $table_users.login='%s'  group by $table_selector.pk order by $table_selector.name, $table_gewenste_processen.pk desc";



$selector_Stmt=sprintf($selector_Stmt,$user);
//printf($selector_Stmt,$user);
//exit();

// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


if (!($result_selector= $link->query($selector_Stmt) )) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selector_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", $link->error(), mysql_error($link))) ;
   exit() ;
}


$table_selector='';

$status=5;

$j=0;
while ($field_selector = $result_selector->fetch_object() )
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
 

   if ($field_selector->category==$omschrijving_dosis_categorie)
   { 
     $action=sprintf("show_results_dose.php?selector_fk=%d&analyse_level=%s&gewenste_processen_id=-1&status=$status&v=$v&t=%d",$field_selector->pk,$field_selector->analyselevel,time()); 
   }
   else
   {
     $action=sprintf("show_results.php?selector_fk=%d&analyse_level=%s&gewenste_processen_id=-1&status=$status&v=$v&t=%d",$field_selector->pk,$field_selector->analyselevel,time()); 
   }  


   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("analysemodule",$field_selector->name);
   $table_data->assign("action",$action);
   $table_data->assign("category",$field_selector->category);
   $table_data->assign("modality",$field_selector->modaliteit);
   $table_data->assign("location",$field_selector->lokatie);
   $table_data->assign("datetime",$field_selector->creation_time);
   
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