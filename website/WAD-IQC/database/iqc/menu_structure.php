<?php 

require("../globals.php") ;

//admin privileges
if (!empty($user_level_1))
{


$level['top']['Admin']=1;
$level['top']['Selector']=2;
$level['top']['Other']=3;

$level['Admin']['Users']=1;
$action['Admin']['Users']='../iqc/create_users.php';

$level['Selector']['Test Files']=1;
$level['Selector']['Config Files']=2;
$level['Selector']['Selector']=3;


$action['Selector']['Test Files']='../iqc/create_analysemodule.php';
$action['Selector']['Config Files']='../iqc/create_analysemodule_cfg.php';
$action['Selector']['Selector']='../iqc/create_selector.php';



$level['Other']['WIP']=1;

$action['Other']['WIP']='../iqc/create_other.php';

}

?>