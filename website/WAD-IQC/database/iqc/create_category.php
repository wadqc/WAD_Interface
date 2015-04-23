<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



$table_selector_category='selector_categorie';

$category_Stmt = "SELECT * from $table_selector_category
                  order by $table_selector_category.omschrijving";

// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!($result_category= $link->query($category_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $category_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}


$table_category='';
 
$j=0;
while (($field_category = $result_category->fetch_object()))
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
     $table_category=$table_data->fetch("category_header.tpl");
   }
   $action=sprintf("new_category.php?pk=%d&t=%d",$field_category->pk,time());
   $checkbox_name=sprintf("category[%d]",$field_category->pk);
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("checkbox_name",$checkbox_name);
   $table_data->assign("description",$field_category->omschrijving);
   $table_data->assign("action",$action);
      
   $table_category.=$table_data->fetch("category_row.tpl");

   $j++;
}


$result_category->close();

$data = new Smarty_NM();
$data->assign("Title","Selector categorie&euml;n");
$data->assign("header","Selector categorie&euml;n");
$data->assign("form_action",sprintf("new_category.php?pk=-1&t=%d",time() ) );
$data->assign("category_list",$table_category);

$new_category=sprintf("<a href=\"new_category.php?pk=0&t=%d\">Add new category</a>",time());
$data->assign("new_category",$new_category);

$data->display("category.tpl");
 

?>
