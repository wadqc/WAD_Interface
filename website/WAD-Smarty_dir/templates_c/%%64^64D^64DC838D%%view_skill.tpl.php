<?php /* Smarty version 2.6.7, created on 2009-11-16 11:43:04
         compiled from view_skill.tpl */ ?>
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
<h1 class="table_data_blue" >School year <?php echo $this->_tpl_vars['year']; ?>
</h1>
<table>
  <tr align="left" valign="center">
    <td valign="top">
<table>
  <tr>
    <td class="keuze_data"> skill </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['skill']; ?>

    </td>
  </tr>
  <tr>
    <td class="keuze_data"> Number </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['number']; ?>
 </td>
  </tr>
</table>
</td>


<td valign="top">
 <table>
  <?php echo $this->_tpl_vars['year_content']; ?>

 </table>
</td>
</tr>
<tr>
  <td class="keuze_data"> <a HREF="<?php echo $this->_tpl_vars['action_modify']; ?>
" class="href_table_data">Modify</a> /
  <a HREF="<?php echo $this->_tpl_vars['action_delete']; ?>
" class="href_table_data">Delete</a>
  </td>
</tr>
</table>
</body>
</HTML>