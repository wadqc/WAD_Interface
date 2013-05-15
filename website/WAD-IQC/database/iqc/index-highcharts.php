<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");



 

$data = new Smarty_NM();
//$data->assign("Title","Selector");
//$data->assign("header","Selector");
//$data->assign("form_action",sprintf("new_selector.php?pk=-1&t=%d",time() ) );
//$data->assign("file_list",$table_selector);

//$new_selector=sprintf("<a href=\"new_selector.php?pk=0&selector_patient_fk=0&selector_study_fk=0&selector_series_fk=0&selector_instance_fk=0&t=%d\">Add new selector</a>",time());


//$data->assign("new_file",$new_selector);

$data->display("wad_highcharts.tpl");
 

?>
