<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$pk=$_GET['pk'];


$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));
$target_path = sprintf("%s%s/../../",$site_root,dirname($_SERVER['PHP_SELF'])); 



$table_analysemodule='analysemodule';
$addStmt = "Insert into $table_analysemodule(description,filename,filepath) values ('%s','%s','%s')";
$update_Stmt = "Update $table_analysemodule set description='%s',filename='%s',filepath='%s' where $table_analysemodule.pk='%d'";
$update_Stmt1 = "Update $table_analysemodule set description='%s' where $table_analysemodule.pk='%d'";

$select_Stmt= "select * from $table_analysemodule where $table_analysemodule.pk='%d'";
$select_Stmt1= "select * from $table_analysemodule where $table_analysemodule.filepath='%s'";


$del_analysemodule_Stmt = "delete from  $table_analysemodule where $table_analysemodule.pk='%d'";

// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
exit() ;
}

// Select the Database
if (!mysql_select_db($databaseName, $link)) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}










if(!empty($_POST['action']))
{
 
  
  $error    = $_FILES['uploadedfile']['error'];
  $description=$_POST['description'];
  
  

  if ($pk==0)
  { 
    $filename=basename( $_FILES['uploadedfile']['name']);
    $filepath = "WAD-IQC/uploads/analysemodule/".basename( $_FILES['uploadedfile']['name']); 
    $target_path=$_SERVER['DOCUMENT_ROOT'].'/'.$filepath;
	
    if ( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path) )
    {
    // echo "The file ".  basename( $_FILES['uploadedfile']['name'])." has been uploaded";
    } else
    {
     echo "There was an error uploading the file, please try again!";
     exit();
    }



    if (!(mysql_query(sprintf($addStmt,$description,$filename,$filepath),$link))) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    }
  }
  if ($pk>0)
  { 
    if ($error==4)    
    {
      if (!(mysql_query(sprintf($update_Stmt1,$description,$pk),$link)))  
      {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
      }
    }
    if ($error==0)    
    {
       $filename=basename( $_FILES['uploadedfile']['name']);

       $filepath = "WAD-IQC/uploads/analysemodule/".basename( $_FILES['uploadedfile']['name']); 
       $target_path=$_SERVER['DOCUMENT_ROOT'].'/'.$filepath;

	   //$target_path=$site_root.$filepath;
  
       if ( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path) )
       {
         // echo "The file ".  basename( $_FILES['uploadedfile']['name'])." has been uploaded";
       } else
       {
          echo "There was an error uploading the file, please try again!";
          exit();
       }


       if (!(mysql_query(sprintf($update_Stmt,$description,$filename,$filepath,$pk),$link))) 
       {   
        DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
        DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
        exit() ;
       }

    }
    
  }

  
}

if (!empty($_POST['action']))
{
  $executestring.=sprintf("create_analysemodule.php?t=%d",time());
  header($executestring);
  exit();
}




//////////////////////////////////////////////////////////////////////////////////////////
// if it will get to here it is either the first time or it returned from add/modify picture
///////////////////////////////////////////////////////////////////////////////////////////


$analysemodule = new Smarty_NM();



if ($pk==-1)         //delete
{
  $limit=0;
  if (!empty($_POST['analysemodule']))
  {
    $analysemodule=$_POST['analysemodule'];
    $analysemodule_ref_key=array_keys($analysemodule);
    $limit=sizeof($analysemodule_ref_key);
  } 
  $i=0;

  while ($i<$limit) // loop for $pk
  {
    if ($analysemodule[$analysemodule_ref_key[$i]]=='on')
    {
    
      if (!($result_analysemodule= mysql_query(sprintf($select_Stmt,$analysemodule_ref_key[$i]), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
      $field_analysemodule = mysql_fetch_object($result_analysemodule);
      $filepath=$field_analysemodule->filepath;
      mysql_free_result($result_analysemodule);

      if (!($result_analysemodule= mysql_query(sprintf($select_Stmt1,$filepath), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
      $counter=0;
      while ($field_analysemodule = mysql_fetch_object($result_analysemodule) )
      {
        $counter++;
      }
      mysql_free_result($result_analysemodule);
      if ($counter==1) //only 1 row that contains filepath
      {
        $target_path=$target_path.$filepath;
        //printf("target=%s",$target_path);
        //exit();
        unlink($target_path);
      } 
      if (!($result_analysemodule= mysql_query(sprintf($del_analysemodule_Stmt,$analysemodule_ref_key[$i]),$link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;}
    
    }
    $i++;
  }

  $executestring.=sprintf("create_analysemodule.php?t=%d",time());
  header($executestring);
  exit();
}







if ($pk==0)   //add
{
  $analysemodule->assign("submit_value","Add");  
}

if ($pk>0)   //insert part of update
{
  $table_analysemodule='analysemodule';
  $analysemodule_Stmt = "SELECT * from $table_analysemodule where
  $table_analysemodule.pk='$pk' ";

  // Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

  // Select the Database
  if (!mysql_select_db($databaseName, $link)) {
    DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }
  
  if (!($result_analysemodule= mysql_query($analysemodule_Stmt, $link))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
     DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
     exit() ;
  }
    
  $new = mysql_fetch_object($result_analysemodule);

  $analysemodule->assign("title","Test file");
  $analysemodule->assign("header","Test file");

  
  $analysemodule->assign("default_description",$new->description);
  $analysemodule->assign("default_filename",$new->filename);
  $analysemodule->assign("default_filepath",$new->filepath);
  
  
  mysql_free_result($result_analysemodule);
  
  $analysemodule->assign("submit_value","Update");
}

  $analysemodule->assign("action_new_file",sprintf("new_analysemodule.php?pk=%d&t=%d",$pk,time()));

    

  $analysemodule->display("file_new.tpl");

   
?>












