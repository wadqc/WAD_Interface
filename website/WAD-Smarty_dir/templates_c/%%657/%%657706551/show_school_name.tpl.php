<?php /* Smarty version 2.4.2, created on 2005-02-02 22:13:36
         compiled from show_school_name.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'show_school_name.tpl', 16, false),)); ?><!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Open School</title>
  <link   rel="StyleSheet" href="../mpc/css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff">
<img src="<?php echo $this->_tpl_vars['login_picure_src']; ?>
" border="0">
<form action="<?php echo $this->_tpl_vars['school_action']; ?>
" method="POST">
<table NOSAVE="true" bgcolor="#f3f6ff">
  <tr>
      <td class="template_data"> School name</td>
      <td class="template_data"> <select name="school"><?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['school_list'],'selected' => $this->_tpl_vars['school_id']), $this) ; ?>
 </select></td>
      <td class="template_data"> <input type="submit" name="submit" value="submit"> </td>
  </tr>
</table>
</form>
</body>
</html>