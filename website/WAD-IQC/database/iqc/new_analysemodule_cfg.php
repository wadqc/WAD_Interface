<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

// add new cfg : GET pk = 0
// na toevoegen: GET pk = 0
//               $_POST['action'] = "Add"
// update cfg  : GET pk = pk van cfg in analysemodule_cfg tabel
// na updaten  : GET pk = pk van cfg in analysemodule_cfg tabel
//               $_POST['action'] = "Update"
// delete cfg  : GET pk = -1 (via FORM action in POST)
//               $_POST['analysemodule_cfg[pk]'] = "on"  (pk van te deleten cfg)
//               $_POST['action'] = ""

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









// Aanroep na toevoegen (pk=0) of na updaten (pk>0)van config
if(!empty($_POST['action']))
{
 
  
  $error    = $_FILES['uploadedfile']['error']; // 0 = success, 4 = no file uploaded
  $description=$_POST['description'];
  
  
  // add new analysemodule cfg
  if ($pk==0)
  { 
    $filename=basename( $_FILES['uploadedfile']['name']);
    $filepath_root="WAD-IQC/uploads/analysemodule_cfg/";
    $filepath = $filepath_root.basename( $_FILES['uploadedfile']['name']); 

    $target_path=__DIR__ . '/../../../' . $filepath;

    if (file_exists($target_path)) {
       echo "Config \"$filename\" already exists! Please rename config and try to upload again, or click on config filename to update the module.";
       exit();
    }

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
  // update analysemodule cfg
  if ($pk>0)
  { 
    if ($error==4)    // "no file uploaded" -> alleen omschrijving aanpassen
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
       // delete eerst de oude config
       if (!($result_analysemodule_cfg=$link->query(sprintf($select_Stmt,$pk)))) {
         DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
         DisplayErrMsg(sprintf("error: %s", $link->error)) ;
         exit() ;
       }
       $field_analysemodule_cfg = $result_analysemodule_cfg->fetch_object();
       $filename_db=$field_analysemodule_cfg->filename;
       $filepath_db=$field_analysemodule_cfg->filepath;
       $result_analysemodule_cfg->close();
       $target_folder_db =__DIR__ . '/../../../' . $filepath_db;
       $target_path_db = $target_folder_db . $filename_db;
       if (!unlink($target_path_db))
       {
          echo ("Error deleting old config \"$filename_db\"");
          exit();
       }
       // kopieer de nieuwe upload naar de analysemodule_cfg folder
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
// if it will get to here it is either the first time or it returned from add/modify config
///////////////////////////////////////////////////////////////////////////////////////////


$analysemodule_cfg = new Smarty_NM();



if ($pk==-1)         //delete
{
  $limit=0;
  if (!empty($_POST['analysemodule_cfg']))
  {
    $analysemodule_cfg=$_POST['analysemodule_cfg'];            // array vd vorm { [pk1] = "on", [pk2] = "on", .. }
    $analysemodule_cfg_ref_key=array_keys($analysemodule_cfg); // array met aangevinkte pk's
    $limit=sizeof($analysemodule_cfg_ref_key);                 // aantal aangevinkte configs
  } 
  $i=0;

  while ($i<$limit) // loop for $pk
  {
    if ($analysemodule_cfg[$analysemodule_cfg_ref_key[$i]]=='on')
    {
      // haal config filename op uit DB op basis van pk
      if (!($result_analysemodule_cfg= $link->query(sprintf($select_Stmt,$analysemodule_cfg_ref_key[$i])))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;
      }
      $field_analysemodule_cfg = $result_analysemodule_cfg->fetch_object();
      $filename=$field_analysemodule_cfg->filename;
      $filepath=$field_analysemodule_cfg->filepath;
      $result_analysemodule_cfg->close();

      $target_folder =__DIR__ . '/../../../' . $filepath;
      $target_path = $target_folder . $filename;
      if (!unlink($target_path))
      {
         echo ("Error deleting \"$filename\"");
         exit();
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
