<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$pk=$_GET['pk'];


$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));


$table_analysemodule_cfg='analysemodule_cfg';
$addStmt = "Insert into $table_analysemodule_cfg(description,filename,filepath) values ('%s','%s','%s')";
$update_Stmt = "Update $table_analysemodule_cfg set description='%s',filename='%s',filepath='%s' where $table_analysemodule_cfg.pk='%d'";
$update_Stmt1 = "Update $table_analysemodule_cfg set description='%s' where $table_analysemodule_cfg.pk='%d'";

$select_Stmt= "select * from $table_analysemodule_cfg where $table_analysemodule_cfg.pk='%d'";
$select_Stmt1= "select * from $table_analysemodule_cfg where $table_analysemodule_cfg.filepath='%s'";


$del_analysemodule_cfg_Stmt = "delete from  $table_analysemodule_cfg where $table_analysemodule_cfg.pk='%d'";

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
  $description=$_POST['description'];
  
  

  if ($pk==0)
  { 
    $filename=basename( $_FILES['uploadedfile']['name']);
    $filepath_root="WAD-IQC/uploads/analysemodule_cfg/";
    $filepath = $filepath_root.basename( $_FILES['uploadedfile']['name']); 

    $target_path=__DIR__ . '/../../../' . $filepath;

    if ( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path) )
    {
    // echo "The file ".  basename( $_FILES['uploadedfile']['name'])." has been uploaded";
    } else
    {
     echo "There was an error uploading the file, please try again!";
     exit();
    }



    if (!($link->query(sprintf($addStmt,$description,$filename,$filepath_root)))) 
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
      if (!($link->query(sprintf($update_Stmt1,$description,$pk))))  
      {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
        DisplayErrMsg(sprintf("error: %s", $link->error)) ;
        exit() ;
      }
    }
    if ($error==0)    
    {
       $filename=basename( $_FILES['uploadedfile']['name']);
       $filepath_root="WAD-IQC/uploads/analysemodule_cfg/";
       $filepath = $filepath_root.basename( $_FILES['uploadedfile']['name']); 

       $target_path=__DIR__ . '/../../../' . $filepath;
  
       if ( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path) )
       {
         // echo "The file ".  basename( $_FILES['uploadedfile']['name'])." has been uploaded";
       } else
       {
          echo "There was an error uploading the file, please try again!";
          exit();
       }


       if (!($link->query(sprintf($update_Stmt,$description,$filename,$filepath_root,$pk)))) 
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
  $executestring.=sprintf("create_analysemodule_cfg.php?t=%d",time());
  header($executestring);
  exit();
}




//////////////////////////////////////////////////////////////////////////////////////////
// if it will get to here it is either the first time or it returned from add/modify picture
///////////////////////////////////////////////////////////////////////////////////////////


$analysemodule_cfg = new Smarty_NM();



if ($pk==-1)         //delete
{
  $limit=0;
  if (!empty($_POST['analysemodule_cfg']))
  {
    $analysemodule_cfg=$_POST['analysemodule_cfg'];
    $analysemodule_cfg_ref_key=array_keys($analysemodule_cfg);
    $limit=sizeof($analysemodule_cfg_ref_key);
  } 
  $i=0;

  while ($i<$limit) // loop for $pk
  {
    if ($analysemodule_cfg[$analysemodule_cfg_ref_key[$i]]=='on')
    {
    
      if (!($result_analysemodule_cfg= $link->query(sprintf($select_Stmt,$analysemodule_cfg_ref_key[$i])))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
      }
      $field_analysemodule_cfg = $result_analysemodule_cfg->fetch_object();
      $filepath=$field_analysemodule_cfg->filepath;
      $result_analysemodule_cfg->close();

      if (!($result_analysemodule_cfg= $link->query(sprintf($select_Stmt1,$filepath)))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
      }
      $counter=0;
      while ($field_analysemodule_cfg = $result_analysemodule_cfg->fetch_object() )
      {
        $counter++;
      }
      $result_analysemodule_cfg->close();
      if ($counter==1) //only 1 row that contains filepath
      {
        $target_path=$target_path.$filepath;
        //printf("target=%s",$target_path);
        //exit();
        unlink($target_path);
      } 
      if (!($result_analysemodule_cfg= $link->query(sprintf($del_analysemodule_cfg_Stmt,$analysemodule_cfg_ref_key[$i])))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($del_analysemodule_cfg_Stmt,$analysemodule_cfg_ref_key[$i]) ) ) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;}
    }
    $i++;
  }

  $executestring.=sprintf("create_analysemodule_cfg.php?t=%d",time());
  header($executestring);
  exit();
}







if ($pk==0)   //add
{
  $analysemodule_cfg->assign("submit_value","Add");  
}

if ($pk>0)   //insert part of update
{
  $table_analysemodule_cfg='analysemodule_cfg';
  $analysemodule_cfg_Stmt = "SELECT * from $table_analysemodule_cfg where
  $table_analysemodule_cfg.pk='$pk' ";

  // Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
  
  if (!($result_analysemodule_cfg= $link->query($analysemodule_cfg_Stmt))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
     DisplayErrMsg(sprintf("error: %s", $link->error)) ;
     exit() ;
  }
    
  $new = $result_analysemodule_cfg->fetch_object();

  $analysemodule_cfg->assign("title","Config file");
  $analysemodule_cfg->assign("header","Config file");

  
  $analysemodule_cfg->assign("default_description",$new->description);
  $analysemodule_cfg->assign("default_filename",$new->filename);
  $analysemodule_cfg->assign("default_filepath",$new->filepath);
  
  
  $result_analysemodule_cfg->close();
  
  $analysemodule_cfg->assign("submit_value","Update");
}

  $analysemodule_cfg->assign("action_new_file",sprintf("new_analysemodule_cfg.php?pk=%d&t=%d",$pk,time()));

    

  $analysemodule_cfg->display("file_new.tpl");

   
?>












