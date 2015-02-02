<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$pk=$_GET['pk'];


$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
$target_path = sprintf("%s%s/../../",$site_root,dirname($_SERVER['PHP_SELF'])); 



$table_test_file='test_file';
$addStmt = "Insert into $table_test_file(omschrijving,filenaam,filenaam_pad) values ('%s','%s','%s')";
$update_Stmt = "Update $table_test_file set omschrijving='%s',filenaam='%s',filenaam_pad='%s' where $table_test_file.pk='%d'";
$update_Stmt1 = "Update $table_test_file set omschrijving='%s' where $table_test_file.pk='%d'";

$select_Stmt= "select * from $table_test_file where $table_test_file.pk='%d'";
$select_Stmt1= "select * from $table_test_file where $table_test_file.filenaam_pad='%s'";


$del_test_file_Stmt = "delete from  $table_test_file where $table_test_file.pk='%d'";

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
    $filenaam_pad = "uploads/test_files/".basename( $_FILES['uploadedfile']['name']); 
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

       $filenaam_pad = "uploads/test_files/".basename( $_FILES['uploadedfile']['name']); 
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
  $executestring.=sprintf("create_test_files.php?t=%d",time());
  header($executestring);
  exit();
}




//////////////////////////////////////////////////////////////////////////////////////////
// if it will get to here it is either the first time or it returned from add/modify picture
///////////////////////////////////////////////////////////////////////////////////////////


$test_file = new Smarty_NM();



if ($pk==-1)         //delete
{
  $limit=0;
  if (!empty($_POST['test_file']))
  {
    $test_file=$_POST['test_file'];
    $test_file_ref_key=array_keys($test_file);
    $limit=sizeof($test_file_ref_key);
  } 
  $i=0;

  while ($i<$limit) // loop for $pk
  {
    if ($test_file[$test_file_ref_key[$i]]=='on')
    {
    
      if (!($result_test_file= $link->query(sprintf($select_Stmt,$test_file_ref_key[$i])))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
      }
      $field_test_file = $result_test_file->fetch_object();
      $filenaam_pad=$field_test_file->filenaam_pad;
      $result_test_file->close();

      if (!($result_test_file= $link->query(sprintf($select_Stmt1,$filenaam_pad)))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
      }
      $counter=0;
      while ($field_test_file = $result_test_file->fetch_object() )
      {
        $counter++;
      }
      $result_test_file->close();
      if ($counter==1) //only 1 row that contains filenaam_pad
      {
        $target_path=$target_path.$filenaam_pad;
        //printf("target=%s",$target_path);
        //exit();
        unlink($target_path);
      } 
      if (!($result_test_file= $link->query(sprintf($del_test_file_Stmt,$test_file_ref_key[$i])))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;}
    
    }
    $i++;
  }

  $executestring.=sprintf("create_test_files.php?t=%d",time());
  header($executestring);
  exit();
}







if ($pk==0)   //add
{
  $test_file->assign("submit_value","Add");  
}

if ($pk>0)   //insert part of update
{
  $table_test_file='test_file';
  $test_file_Stmt = "SELECT * from $table_test_file where
  $table_test_file.pk='$pk' ";

  // Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
  
  if (!($result_test_file= $link->query($test_file_Stmt))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
     DisplayErrMsg(sprintf("error: %s", $link->error)) ;
     exit() ;
  }
    
  $new = $result_test_file->fetch_object();

  $test_file->assign("title","Test file");
  $test_file->assign("header","Test file");

  
  $test_file->assign("default_omschrijving",$new->omschrijving);
  $test_file->assign("default_filenaam",$new->filenaam);
  $test_file->assign("default_filenaam_pad",$new->filenaam_pad);
  
  
  $result_test_file->close();
  
  $test_file->assign("submit_value","Update");
}

  $test_file->assign("action_new_file",sprintf("new_test_file.php?pk=%d&t=%d",$pk,time()));

    

  $test_file->display("file_new.tpl");

   
?>












