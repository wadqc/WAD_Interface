<?php /* Smarty version 2.6.7, created on 2007-06-01 09:43:38
         compiled from show_school_name.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'show_school_name.tpl', 16, false),)), $this); ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Open School</title>
  <link   rel="StyleSheet" href="../open_school/css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body onLoad="javascript:document.first.submit.focus();" bgcolor="#F3F6FF">
<img src="<?php echo $this->_tpl_vars['login_picure_src']; ?>
" border="0">
<form name="first" action="<?php echo $this->_tpl_vars['school_action']; ?>
" method="POST">
<table NOSAVE="true" bgcolor="#f3f6ff">
  <tr>
      <td class="template_data"> School name</td>
      <td class="template_data"> <select name="school"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['school_list'],'selected' => $this->_tpl_vars['school_id']), $this);?>
 </select></td>
      <td class="template_data"> <input type="submit" name="submit" value="submit"> </td>
  </tr>
</table>
</form>
</body>
</html>