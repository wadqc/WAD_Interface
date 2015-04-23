<?php 

require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$pk=$_GET['pk'];


$executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));



$table_selector_category='selector_categorie';
$table_selector='selector';

$addStmt = "Insert into $table_selector_category(omschrijving) values ('%s')";
$update_Stmt = "Update $table_selector_category set omschrijving='%s' where $table_selector_category.pk='%d'";
$select_Stmt= "select * from $table_selector_category where $table_selector_category.pk='%d'";
$select1_Stmt = "select * from $table_selector_category where omschrijving='%s'";
$del_category_Stmt = "delete from  $table_selector_category where $table_selector_category.pk='%d'";

$selector_Stmt= "select * from $table_selector where $table_selector.selector_categorie_fk='%d'";

// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



if(!empty($_POST['action']))
{
  $description=$link->real_escape_string($_POST['description']);

  // nieuwe categorie
  if ($pk==0) {

     // FIXME: check of categorie al bestaat
     if (!($result = $link->query(sprintf($select1_Stmt,$description)))) {
         DisplayErrMsg(sprintf("Error in executing %s stmt", $select1_Stmt)) ;
         DisplayErrMsg(sprintf("error: %s", $link->error)) ;
         exit() ;
     }
     if(mysqli_num_rows($result)>0) {
         printf("Fout: categorie bestaat al!");
         exit();
     }

     if (!($link->query(sprintf($addStmt,$description)))) {
         DisplayErrMsg(sprintf("Error in executing %s stmt", $addStmt)) ;
         DisplayErrMsg(sprintf("error: %s", $link->error)) ;
         exit() ;
     }
  }

  // updaten van bestaande categorie
  if ($pk>0) { 
     if (!($link->query(sprintf($update_Stmt,$description,$pk))))  
      {
        DisplayErrMsg(sprintf("Error in executing %s stmt", $stmt)) ;
        DisplayErrMsg(sprintf("error: %s", $link->error)) ;
        exit() ;
      }
  }

}


// ga na POST weer terug naar de category pagina
if (!empty($_POST['action']))
{
  $executestring.=sprintf("create_category.php?t=%d",time());
  header($executestring);
  exit();
}



//////////////////////////////////////////////////////////////////////////////////////////
// if it will get to here it is either the first time or it returned from add/modify filename
///////////////////////////////////////////////////////////////////////////////////////////


$category = new Smarty_NM();



if ($pk==-1)         //delete
{
  $limit=0;
  if (!empty($_POST['category']))
  {
    $category=$_POST['category'];
    $category_ref_key=array_keys($category);
    $limit=sizeof($category_ref_key);
  } 
  $i=0;

  while ($i<$limit) // loop for $pk
  {
    if ($category[$category_ref_key[$i]]=='on')
    {
      // controleer eerst of er nog selectoren zijn gekoppeld aan de categorie
      if (!($result_selector=$link->query(sprintf($selector_Stmt,$category_ref_key[$i])))) {
        DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($selector_Stmt,$category_ref_key[$i])));
        DisplayErrMsg(sprintf("error: %s", $link->error)) ;
        exit() ;
      }

      $count=0; $selectorlist=array();
      while ($field_selector = $result_selector->fetch_object() )
      {
        $count++;
        array_push($selectorlist,$field_selector->name);
      }
      $result_selector->close();

      if ($count) {
         print("Fout: categorie is in gebruik door de volgende selector(en): ".implode(', ',$selectorlist));
         exit();
      }    

      // categorie niet in gebruik dus mag worden gedelete
      if (!($result_category= $link->query(sprintf($del_category_Stmt,$category_ref_key[$i])))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $subject_Stmt)) ;
      DisplayErrMsg(sprintf("error: %s", $link->error)) ;
      exit() ;}
    
    }
    $i++;
  }

  $executestring.=sprintf("create_category.php?t=%d",time());
  header($executestring);
  exit();
}




if ($pk==0)   //add
{
  $category->assign("title","Nieuwe categorie");
  $category->assign("header","Nieuwe categorie");
  $category->assign("submit_value","Add");
}

if ($pk>0)   //insert part of update
{
  //$category_Stmt = "SELECT * from $table_selector_category where $table_selector_category.pk='$pk' ";

  // Connect to the Database
  $link = new mysqli($hostName, $userName, $password, $databaseName);

  /* check connection */
  if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
  }
  
  if (!($result_category= $link->query(sprintf($select_Stmt,$pk)))) {
     DisplayErrMsg(sprintf("Error in executing %s stmt", $mpc_class_Stmt)) ;
     DisplayErrMsg(sprintf("error: %s", $link->error)) ;
     exit() ;
  }
    
  $new = $result_category->fetch_object();

  $category->assign("title","Update categorie");
  $category->assign("header","Update categorie");
  $category->assign("default_description",$new->omschrijving);  
  
  $result_category->close();
  
  $category->assign("submit_value","Update");
}

  $category->assign("action_new_category",sprintf("new_category.php?pk=%d&t=%d",$pk,time()));
    

  $category->display("category_new.tpl");

   
?>
