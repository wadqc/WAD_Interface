<?php

require("./database/iqc_data.php") ;
require("./database/iqc/php/includes/setup.php");


$start_page = new Smarty_NM();

$start_page->assign("school_project_name",$school_project_name);
$start_page->assign("school_project_place",$school_project_place);
$start_page->assign("main_logo",$main_logo);

$start_page->display("iqc.tpl");

?>
