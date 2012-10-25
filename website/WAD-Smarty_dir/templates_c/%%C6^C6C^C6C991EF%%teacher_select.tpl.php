<?php /* Smarty version 2.6.7, created on 2007-06-15 13:33:00
         compiled from teacher_select.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'teacher_select.tpl', 31, false),)), $this); ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>show_patient_template</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#F3F6FF">
<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
 </h1>

<form action="<?php echo $this->_tpl_vars['form_action']; ?>
" method="POST">


<table NOSAVE="true" width="100%" border="true" bgcolor="#f3f6ff" frame="border">
  <?php echo $this->_tpl_vars['teacher_list']; ?>

</table>
<table bgcolor="#6767ff">
<tr>
  <td bgcolor="#F3F6FF" class="template_data">Selection</td>
  <td bgcolor="#f3f6ff" class="template_data"> <select name="transfer_action">
    <option value="transfer" >transfer</option>
    <option value="reset_pwd" >reset_pwd</option>
    <option value="delete" >delete</option>
    </select><input type="submit" value="Go!">
  </td>
</tr>
<tr>
  <td bgcolor="#F3F6FF" class="template_data"> Select a year</td>
  <td bgcolor="#F3F6FF" class="template_data"> <select name="school_year_t"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['year_options'],'selected' => $this->_tpl_vars['year_id']), $this);?>
 </select></td>
</tr>
<tr>
  <td bgcolor="#F3F6FF" class="template_data"> Select a school</td>
  <td bgcolor="#F3F6FF" class="template_data"> <select name="school_t"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['school_options'],'selected' => $this->_tpl_vars['school_id']), $this);?>
 </select></td>
</tr>
</table>


<?php echo $this->_tpl_vars['new_teacher']; ?>



</form>

</body>
</html>