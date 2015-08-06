<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$table_analysemodule_cfg='analysemodule_cfg';


$pk=0;
if (!empty($_GET['pk']))
{
  $pk=$_GET['pk'];
}


$analysemodule_cfg_Stmt="SELECT  $table_analysemodule_cfg.filename as 'filename', $table_analysemodule_cfg.filepath as 'filepath'
from  $table_analysemodule_cfg
where $table_analysemodule_cfg.pk=$pk";


// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!($result_object= $link->query($analysemodule_cfg_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $analysemodule_cfg_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}

$field_results = $result_object->fetch_object();

$file_name='../../../' . $field_results->filepath . $field_results->filename;

if (!file_exists($file_name)) { die("<b>Fout: config file '" . $field_results->filename . "' niet aanwezig.</b>"); }

    //$file_extension = strtolower(substr(strrchr($file_name,"."),1));
    $file_size = filesize($file_name);

    $offset = 0;
    $length = $file_size;

    //read the data from the file
    $handle = fopen($file_name, 'r');
    $buffer = '';
    fseek($handle, $offset);
    $buffer = fread($handle, $length);
    fclose($handle);

    echo '<pre>';
    echo htmlentities($buffer);
    echo '</pre>';

    flush();

?>
