<?php /* Smarty version 2.4.2, created on 2005-02-06 23:03:38
         compiled from subject_term.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'subject_term.tpl', 18, false),)); ?><!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
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

<form action="<?php echo $this->_tpl_vars['subject_action']; ?>
" method="POST">

<table>
<tr>
  <td class="template_data"> Select a subject</td>
  <td colspan="2" class="template_data"> <select name=subject><?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['subject_options'],'selected' => $this->_tpl_vars['subject_id']), $this) ; ?>
 </select></td>
</tr>
<tr>
<tr>
<td class="template_data"> Select a term</td>
  <td class="template_data"> <select name=term><?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['term_options'],'selected' => $this->_tpl_vars['term_id']), $this) ; ?>
 </select></td>
  <td class="template_data"> <input type="submit" name="action" value="Query_class"> </td>
</tr>
<tr>
<tr>
<td class="template_data"> Select a cluster</td>
  <td class="template_data"> <select name=cluster><?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['cluster_options'],'selected' => $this->_tpl_vars['cluster_id']), $this) ; ?>
 </select></td>
  <td class="template_data"> <input type="submit" name="action" value="Query_cluster"> </td>
</tr>

</table>







</form>