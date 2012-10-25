<?php /* Smarty version 2.6.7, created on 2005-06-23 17:08:22
         compiled from report_meeting.tpl */ ?>
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
<form action="<?php echo $this->_tpl_vars['report_action']; ?>
" method="POST" target="_blank">

<table>
<tr>
  <?php echo $this->_tpl_vars['term_factors']; ?>

</tr>

</table>

<table>
  <tr>
     <td colspan="2" align="left" class="template_data"> <input type="submit" value="<?php echo $this->_tpl_vars['report_name']; ?>
"> </td>
  </tr>
  <tr>
     <td class="template_data"> Show average</td>
     <td class="template_data"> <input type="checkbox" name="show_average" value="on" align="left"></td>
  </tr>
</table>



</form>