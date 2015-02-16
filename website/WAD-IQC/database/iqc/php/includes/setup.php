<?php

// deze file wordt aangeroepen vanuit:
//   WAD-IQC/database/login
//   WAD-IQC/database/main
//   WAD-IQC/database/iqc
// dus $home_path geeft vanuit deze locaties de relatieve locatie
// van de site-root.

$home_path="../../..";
$SMARTY_folder=sprintf("%s/WAD-Smarty",$home_path);

// gebruikt in show_results.php (vanuit database/iqc/)
$logo_log_file="logo_pictures/log_file.jpg";
$logo_pdf_file="logo_pictures/pdf_file.jpg";
$logo_obj_file="logo_pictures/object_file.jpg";

// load Smarty library files


//define('SMARTY_folder',$home_path/WAD-Smarty');
require($SMARTY_folder.'/Smarty.class.php');

// a good place to load application library files, example:
// require('guestbook/guestbook.lib.php');


class Smarty_NM extends Smarty
{

   //function Smarty_NM() 
   function __construct()
   {
   
                //$home_path=$_SERVER['CONTEXT_DOCUMENT_ROOT'];
                $home_path="../../..";

   		// Class Constructor. These automatically get set with each new instance.

		//$this->Smarty();
                parent::__construct();

		$this->template_dir = sprintf("%s/WAD-Smarty_dir/templates",$home_path);
		$this->compile_dir = sprintf("%s/WAD-Smarty_dir/templates_c",$home_path);
		$this->config_dir = sprintf("%s/WAD-Smarty_dir/configs",$home_path);
		$this->cache_dir = sprintf("%s/WAD-Smarty_dir/cache",$home_path); 
		
		$this->caching = false;
		$this->assign('app_name','Image Quality Control');
 }

}
  


?>
