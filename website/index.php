<?php

require("./WAD-IQC/database/iqc/php/includes/setup.php");


$start_page = new Smarty_NM();

$main_logo=sprintf("./../WAD-logo_pictures/logo_iqc.jpg");

$start_page->assign("main_logo",$main_logo);

$start_page->display("wad_startpage.tpl");

?>
