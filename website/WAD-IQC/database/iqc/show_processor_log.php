<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$table_resultaten_object='resultaten_object';


$pk=0;
if (!empty($_GET['pk']))
{
  $pk=$_GET['pk'];
}



// check for logfile result (by definition "volgnummer=999")
$results_object_Stmt="SELECT $table_resultaten_object.object_naam_pad as 'object_naam_pad', $table_resultaten_object.omschrijving as 'omschrijving' from  $table_resultaten_object
where $table_resultaten_object.gewenste_processen_fk=$pk and $table_resultaten_object.volgnummer=999";



// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!($result_object= $link->query($results_object_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $results_object_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}


$table_resultaten_object='';
$name_row='';
$picture_row='';

$field_results = $result_object->fetch_object();

$picture = new Smarty_NM();
$description_name = new Smarty_NM();
 


$file_name=$field_results->object_naam_pad;


 if (!file_exists($file_name)) { die("<b>Geen logfile aanwezig.</b>"); }
   
    $file_extension = strtolower(substr(strrchr($file_name,"."),1));
    $file_size = filesize($file_name);
    $md5_sum = md5_file($file_name);
   
    if (isset($_SERVER['HTTP_RANGE'])) {
        $partial_content = true;
        $range = explode("-", $_SERVER['HTTP_RANGE']);
        $offset = intval($range[0]);
        $length = intval($range[1]) - $offset;
    }
    else {
        $partial_content = false;
        $offset = 0;
        $length = $file_size;
    }
   
    //read the data from the file
    $handle = fopen($file_name, 'r');
    $buffer = '';
    fseek($handle, $offset);
    $buffer = fread($handle, $length);
    $md5_sum = md5($buffer);
    if ($partial_content) $data_size = intval($range[1]) - intval($range[0]);
    else $data_size = $file_size;
    fclose($handle);
   
    // send the headers and data
    header("Content-Length: " . $data_size);
    header("Content-md5: " . $md5_sum);
    header("Accept-Ranges: bytes");   
    if ($partial_content) header('Content-Range: bytes ' . $offset . '-' . ($offset + $length) . '/' . $file_size);
    header("Connection: close");
    //header("Content-type: " . $ctype);
    header("Content-type: text/plain");

    //if($file_extension!='txt'){
    //	header('Content-Disposition: attachment; filename=' . $file_name);
    //}
    
    echo $buffer;
    flush();



?>
