<?php /* Smarty version 2.6.7, created on 2007-06-07 06:48:33
         compiled from insert_picture_form.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>template verwijzer</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<form action="<?php echo $this->_tpl_vars['action_new_student']; ?>
" method="POST" >

<hr>
<table>
  <tr>
    <td><a HREF="<?php echo $this->_tpl_vars['upload_action']; ?>
" class="table_data_select">Upload picture from local PC</a> </td>
  </tr>
</table>
<hr>
<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
</h1>



<table valign="top" align="left">
<tr>
  <td>
    <table valign="top" align="left">
     <?php echo $this->_tpl_vars['dir_content']; ?>

    </table>
  </td>
</tr>
<tr>
  <td>
    <table valign="top" width="100%" align="left">
     <?php echo $this->_tpl_vars['table_rows']; ?>

    </table>
  </td>
</tr>
</table>
</form>
</body>
</HTML>