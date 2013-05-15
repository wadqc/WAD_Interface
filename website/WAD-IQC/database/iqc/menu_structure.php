<?php 

require("../globals.php") ;

//admin privileges
if (!empty($user_level_1))
{


$level['top']['Admin']=1;
$level['top']['Selector']=2;
$level['top']['Results']=3;
$level['top']['Status']=4;

$level['Admin']['Users']=1;
$action['Admin']['Users']='../iqc/create_users.php';

$level['Selector']['Modules']=1;
$level['Selector']['Config Files']=2;
$level['Selector']['Selector']=3;


$action['Selector']['Modules']='../iqc/create_analysemodule.php';
$action['Selector']['Config Files']='../iqc/create_analysemodule_cfg.php';
$action['Selector']['Selector']='../iqc/create_selector.php';



$level['Results']['Selector']=1;

$action['Results']['Selector']='../iqc/show_selector.php';

$level['Status']['Collector Selector']=1;
$level['Status']['Processor']=2;


$action['Status']['Collector Selector']='../iqc/status-collector.php';
$action['Status']['Processor']='../iqc/status-processor.php';



}

//non admin privileges
if (empty($user_level_1))
{


//$level['top']['Admin']=1;
$level['top']['Selector']=2;
$level['top']['Results']=3;

//$level['Admin']['Users']=1;
//$action['Admin']['Users']='../iqc/create_users.php';

$level['Selector']['Test Files']=1;
$level['Selector']['Config Files']=2;
$level['Selector']['Selector']=3;


$action['Selector']['Test Files']='../iqc/create_analysemodule.php';
$action['Selector']['Config Files']='../iqc/create_analysemodule_cfg.php';
$action['Selector']['Selector']='../iqc/create_selector.php';


$level['Results']['Selector']=1;

$action['Results']['Selector']='../iqc/show_selector.php';



}













?>