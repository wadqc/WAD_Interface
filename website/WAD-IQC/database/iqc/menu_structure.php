<?php 

require("../globals.php") ;

//admin privileges
if (!empty($user_level_1))
{

$level['top']['Results']  = 1;
$level['top']['Status']   = 2;
$level['top']['Selector'] = 3;
$level['top']['Admin']    = 4;

// Default action for top menu entries
$action['top']['Results'] =  '../iqc/show_selector.php';     // Selector
$action['top']['Status'] =   '../iqc/frontpage-bottom.html'; // none
$action['top']['Selector'] = '../iqc/frontpage-bottom.html'; // none
$action['top']['Admin']    = '../iqc/create_users.php';      // Users

// Default bottom menu selection for top menu entries
$default_selected_bottom['top']['Results']  = 1;   // Selector
$default_selected_bottom['top']['Status']   = 100; // none
$default_selected_bottom['top']['Selector'] = 100; // none
$default_selected_bottom['top']['Admin']    = 1;   // Users


$level['Results']['Selector']=1;
$level['Results']['Dashboard']=2;

$action['Results']['Selector']='../iqc/show_selector.php';
$action['Results']['Dashboard']='../iqc/show_dashboard.php';


$level['Status']['Selector']=1;
$level['Status']['Processor']=2;

$action['Status']['Selector']='../iqc/status-collector.php';
$action['Status']['Processor']='../iqc/status-processor.php';


$level['Selector']['Modules']=1;
$level['Selector']['Config Files']=2;
$level['Selector']['Categorie']=3;
$level['Selector']['Selector']=4;

$action['Selector']['Modules']='../iqc/create_analysemodule.php';
$action['Selector']['Config Files']='../iqc/create_analysemodule_cfg.php';
$action['Selector']['Categorie']='../iqc/create_category.php';
$action['Selector']['Selector']='../iqc/create_selector.php';


$level['Admin']['Users']=1;
$action['Admin']['Users']='../iqc/create_users.php';

}

//non admin privileges
if (empty($user_level_1))
{

$level['top']['Results']=1;
$level['top']['Status']=2;

$action['top']['Results']='../iqc/show_selector.php';
$action['top']['Status']='../iqc/frontpage-bottom.html';


$level['Results']['Selector']=1;
$level['Results']['Dashboard']=1;

$action['Results']['Selector']='../iqc/show_selector.php';
$action['Results']['Dashboard']='../iqc/show_dashboard.php';


$level['Status']['Selector']=1;
$level['Status']['Processor']=2;

$action['Status']['Selector']='../iqc/status-collector.php';
$action['Status']['Processor']='../iqc/status-processor.php';

}













?>
