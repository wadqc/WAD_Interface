<?php /* Smarty version 2.4.2, created on 2005-02-09 12:20:35
         compiled from report_term.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'report_term.tpl', 40, false),)); ?><!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>template verwijzer</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">


<form action="<?php echo $this->_tpl_vars['report_action']; ?>
" method="POST" target="_blank">

<table>
<tr>
  <?php echo $this->_tpl_vars['term_factors']; ?>

</tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
</table>

<table>
<tr>
<td class="template_data"> Select a term</td>
  <td class="template_data"> <select name=term><?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['term_options'],'selected' => $this->_tpl_vars['term_id']), $this) ; ?>
 </select></td>
  <td class="template_data"> <input type="submit" value="<?php echo $this->_tpl_vars['report_name']; ?>
"> </td>
</tr>

</table>






</form>