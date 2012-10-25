<?php /* Smarty version 2.6.7, created on 2006-03-10 13:41:51
         compiled from credit_term_report_attendance.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'credit_term_report_attendance.tpl', 18, false),)), $this); ?>
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
" method="POST" target="_blank">

<table>
<tr>
  <td class="template_data"> Select a month</td>
  <td class="template_data"> <select name=attendance_month><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['month_options'],'selected' => $this->_tpl_vars['month_id']), $this);?>
 </select></td>
</tr>
<tr>
  <td class="template_data"> School days</td>
  <td class="template_data"> <select name=attendance_day><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['day_options'],'selected' => $this->_tpl_vars['day_id']), $this);?>
 </select></td>
</tr>
   <td colspan="2" align="left" class="template_data"> <input type="submit" name="action" value="Query_month"> </td>
</tr>

</table>







</form>