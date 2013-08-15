<?php

$home_path=$_SERVER['DOCUMENT_ROOT'];
$SMARTY_folder=sprintf("%s/WAD-Smarty",$home_path);
$logo_log_file="/logo_pictures/log_file.jpg";


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
   
               $home_path=$_SERVER['DOCUMENT_ROOT'];
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
