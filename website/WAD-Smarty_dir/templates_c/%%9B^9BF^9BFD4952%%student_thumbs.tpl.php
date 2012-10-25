<?php /* Smarty version 2.6.7, created on 2007-06-07 09:20:54
         compiled from student_thumbs.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>template verwijzer</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Microsoft FrontPage 5.0">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<form action="<?php echo $this->_tpl_vars['action_new_student']; ?>
" method="POST" >


<table align="left" width="100%"> <tr> <td align="left" valign="bottom" class="table_data_blue" colspan="8"> <?php echo $this->_tpl_vars['header']; ?>
 <a href="<?php echo $this->_tpl_vars['action_print']; ?>
" type="image/jpeg" target="_blank" class="table_data_select" onmouseover="javascript:document.images['<?php echo $this->_tpl_vars['print_image_name']; ?>
'].src = './logo_pictures/print_icon_selected.jpg'" onmouseout="javascript:document.images['<?php echo $this->_tpl_vars['print_image_name']; ?>
'].src = './logo_pictures/print_icon.jpg'"><img src="./logo_pictures/print_icon.jpg" name="<?php echo $this->_tpl_vars['print_image_name']; ?>
" align="left" border=0></a>         </td>  </tr> 
     <?php echo $this->_tpl_vars['table_rows']; ?>

</table>

</form>
</body>
</HTML>