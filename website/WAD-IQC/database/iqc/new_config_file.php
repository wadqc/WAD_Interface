<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$pk=$_GET['pk'];


$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
$target_path = sprintf("%s%s/../../",$site_root,dirname($_SERVER['PHP_SELF'])); 



$table_config_file='config_file';
$addStmt = "Insert into $table_config_file(omschrijving,filenaam,filenaam_pad) values ('%s','%s','%s')";
$update_Stmt = "Update $table_config_file set omschrijving='%s',filenaam='%s',filenaam_pad='%s' where $table_config_file.pk='%d'";
$update_Stmt1 = "Update $table_config_file set omschrijving='%s' where $table_config_file.pk='%d'";

$select_Stmt= "select * from $table_config_file where $table_config_file.pk='%d'";
$select_Stmt1= "select * from $table_config_file where $table_config_file.filenaam_pad='%s'";


$del_config_file_Stmt = "delete from  $table_config_file where $table_config_file.pk='%d'";

// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}










if(!empty($_POST['action']))
{
 
  
  $error    = $_FILES['uploadedfile']['error'];
  $omschrijving=$_POST['omschrijving'];
  
  

  if ($pk==0)
  { 
    $filenaam=basename( $_FILES['uploadedfile']['name']);
    $filenaam_pad = "uploads/config_files/".basename( $_FILES['uploadedfile']['name']); 
    $target_path=$target_path.$filenaam_pad;
  
    if ( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path) )
    {
    // echo "The file ".  basename( $_FILES['uploadedfile']['name'])." has been uploaded";
    } else
    {
     echo "There was an error uploading the file, please try again!";
     exit();
    }



    if (!($link->query(sprintf($addStmt,$omschrijving,$filenaam,$filenaam_pad)))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
    }
  }
  if ($pk>0)
  { 
    if ($error==4)    
    {
      if (!($link->query(sprintf($update_Stmt1,$omschrijving,$pk))))  
      {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
        DisplayErrMsg(sprintf("error: %s", $link->error)) ;
        exit() ;
      }
    }
    if ($error==0)    
    {
       $filenaam=basename( $_FILES['uploadedfile']['name']);

       $filenaam_pad = "uploads/config_files/".basename( $_FILES['uploadedfile']['name']); 
       $target_path=$target_path.$filenaam_pad;
  
       if ( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path) )
       {
         // echo "The file ".  basename( $_FILES['uploadedfile']['name'])." has been uploaded";
       } else
       {
          echo "There was an error uploading the file, please try again!";
          exit();
       }


       if (!($link->query(sprintf($update_Stmt,$omschrijving,$filenaam,$filenaam_pad,$pk)))) 
       {   
        DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
        DisplayErrMsg(sprintf("error: %s", $link->error)) ;
        exit() ;
       }

    }
    
  }

  
}

if (!empty($_POST['action']))
{
  $executestring.=sprintf("create_config_files.php?t=%d",time());
  header($executestring);
  exit();
}




//////////////////////////////////////////////////////////////////////////////////////////
// if it will get to here it is either the first time or it returned from add/modify picture
///////////////////////////////////////////////////////////////////////////////////////////


$config_file = new Smarty_NM();



if ($pk==-1)         //delete
{
  $limit=0;
  if (!empty($_POST['config_file']))
  {
    $config_file=$_POST['config_file'];
    $config_file_ref_key=array_keys($config_file);
    $limit=sizeof($config_file_ref_key);
  } 
  $i=0;

  while ($i<$limit) // loop for $pk
  {
    if ($config_file[$config_file_ref_key[$i]]=='on')
    {
    
      if (!($result_config_file= $link->query(sprintf($select_Stmt,$config_file_ref_key[$i])))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
      }
      $field_config_file = $result_config_file->fetch_object();
      $filenaam_pad=$field_config_file->filenaam_pad;
      $result_config_file->close();

      if (!($result_config_file= $link->query(sprintf($select_Stmt1,$filenaam_pad)))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
      }
      $counter=0;
      while ($field_config_file = $result_config_file->fetch_object() )
      {
        $counter++;
      }
      $result_config_file->close();
      if ($counter==1) //only 1 row that contains filenaam_pad
      {
        $target_path=$target_path.$filenaam_pad;
        //printf("target=%s",$target_path);
        //exit();
        unlink($target_path);
      } 
      if (!($result_config_file= $link->query(sprintf($del_config_file_Stmt,$config_file_ref_key[$i])))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($del_config_file_Stmt,$config_file_ref_key[$i]) ) ) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;}
    }
    $i++;
  }

  $executestring.=sprintf("create_config_files.php?t=%d",time());
  header($executestring);
  exit();
}







if ($pk==0)   //add
{
  $config_file->assign("submit_value","Add");  
}

if ($pk>0)   //insert part of update
{
  $table_config_file='config_file';
  $config_file_Stmt = "SELECT * from $table_config_file where
  $table_config_file.pk='$pk' ";

  // Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
  
  if (!($result_config_file= $link->query($config_file_Stmt))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
     DisplayErrMsg(sprintf("error: %s", $link->error)) ;
     exit() ;
  }
    
  $new = $result_config_file->fetch_object();

  $config_file->assign("title","Config file");
  $config_file->assign("header","Config file");

  
  $config_file->assign("default_omschrijving",$new->omschrijving);
  $config_file->assign("default_filenaam",$new->filenaam);
  $config_file->assign("default_filenaam_pad",$new->filenaam_pad);
  
  
  $result_config_file->close();
  
  $config_file->assign("submit_value","Update");
}

  $config_file->assign("action_new_file",sprintf("new_config_file.php?pk=%d&t=%d",$pk,time()));

    

  $config_file->display("file_new.tpl");

   
?>












