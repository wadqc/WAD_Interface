<?php /* Smarty version 2.6.7, created on 2007-06-27 09:34:13
         compiled from view_class.tpl */ ?>
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
<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
</h1>
<table>
  <tr align="left" valign="center">
    <td valign="top">
<table>
  <tr>
    <td class="table_data_blue"> Class </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['class']; ?>

    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Number </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['number']; ?>
 </td>
  </tr>
</table>
</td>


<td valign="top">
 <table>
  <?php echo $this->_tpl_vars['history_content']; ?>

 </table>
</td>
</tr>
<tr>
  <td> <a HREF="<?php echo $this->_tpl_vars['action_modify']; ?>
" class="table_data_select">Modify</a> /
  <a HREF="<?php echo $this->_tpl_vars['action_delete']; ?>
" class="table_data_select">Delete</a>
  </td>
</tr>
</table>
</body>
</HTML>