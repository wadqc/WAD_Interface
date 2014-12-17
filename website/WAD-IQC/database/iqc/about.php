<?php

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_config='config';

$versions_Stmt="SELECT * from $table_config where property like 'Version_%'
                order by field(property,'Version_Database','Version_Collector','Version_Selector','Version_Processor')";

// Connect to the Database
if (!($link=@mysql_pconnect($hostName, $userName, $password))) {
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

$result_versions = mysql_query($versions_Stmt, $link);

$table_versions='';

$j=0;
while (($field_config = mysql_fetch_object($result_versions)))
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
     $table_versions=$table_data->fetch("about_versions_header.tpl");
   }

   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("software_onderdeel",str_replace('Version_','',$field_config->property));
   $table_data->assign("software_versie",$field_config->value);
   $table_data->assign("laatste_wijziging",$field_config->date_modified);

   $table_versions.=$table_data->fetch("about_versions_row.tpl");

   $j++;
}

mysql_free_result($result_selector);




$start_page = new Smarty_NM();

$main_logo=sprintf("./../../../WAD-logo_pictures/logo_iqc.jpg");

$start_page->assign("main_logo",$main_logo);
$start_page->assign("versions_list",$table_versions);

$start_page->display("wad_about.tpl");

?>
