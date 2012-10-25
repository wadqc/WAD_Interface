<?php /* Smarty version 2.6.7, created on 2005-06-07 15:10:01
         compiled from credit_term.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'credit_term.tpl', 18, false),)), $this); ?>
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

<form action="<?php echo $this->_tpl_vars['credit_action']; ?>
" method="POST" >

<table>
<tr>
<td class="template_data"> Select a term</td>
  <td class="template_data"> <select name=term><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['term_options'],'selected' => $this->_tpl_vars['term_id']), $this);?>
 </select></td>
  <td class="template_data"> <input type="submit" name="action" value="Query_term"> </td>
</tr>

</table>







</form>