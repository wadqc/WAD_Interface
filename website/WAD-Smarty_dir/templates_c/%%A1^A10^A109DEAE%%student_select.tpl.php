<?php /* Smarty version 2.6.7, created on 2007-06-07 06:44:04
         compiled from student_select.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'student_select.tpl', 37, false),)), $this); ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>show_patient_template</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
  <script type="text/javascript" language="JavaScript" src="./java/scripts.js"></script>
</head>
<body bgcolor="#F3F6FF">
<h1 align="left" class="table_data_blue"><?php echo $this->_tpl_vars['header']; ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['header_statistics']; ?>
&nbsp;&nbsp; <a HREF="<?php echo $this->_tpl_vars['student_thumbs_action']; ?>
" class="table_data_select">Student thumbs</a> </h1>

<form action="<?php echo $this->_tpl_vars['form_action']; ?>
" method="POST">


<table NOSAVE="true" width="100%" border="true" bgcolor="#f3f6ff" frame="border" id="mainTable">
  <?php echo $this->_tpl_vars['student_list']; ?>

</table>

<table bgcolor="#6767ff">
<tr>
  <td bgcolor="#F3F6FF" class="template_data">Selection</td>
  <td bgcolor="#f3f6ff" class="template_data"> <select name="transfer_action">
    <option value="transfer" >transfer</option>
	<option value="print" >print</option>
	<option value="lock" >lock</option>
	<option value="lock all" >lock all</option>
	<option value="unlock" >unlock</option>
	<option value="unlock all" >unlock all</option>
    <option value="delete" >delete</option>
    </select><input type="submit" value="Go!">
  </td>
</tr>
<tr>
  <td bgcolor="#F3F6FF" class="template_data"> Select a year</td>
  <td bgcolor="#F3F6FF" class="template_data"> <select name="year_t" onchange="student_drop_list(year_t.value,school_t.value,department_t.value,grade_t.value,class_t.value,'<?php echo $this->_tpl_vars['school']; ?>
','<?php echo $this->_tpl_vars['department']; ?>
','<?php echo $this->_tpl_vars['school_year']; ?>
','<?php echo $this->_tpl_vars['grade']; ?>
','<?php echo $this->_tpl_vars['class']; ?>
','<?php echo $this->_tpl_vars['v']; ?>
')" id="year_t"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['year_options'],'selected' => $this->_tpl_vars['year_id']), $this);?>
 </select></td>
</tr>
<tr>
  <td bgcolor="#F3F6FF" class="template_data"> Select a school</td>
  <td bgcolor="#F3F6FF" class="template_data"> <select name="school_t" onchange="student_drop_list(year_t.value,school_t.value,department_t.value,grade_t.value,class_t.value,'<?php echo $this->_tpl_vars['school']; ?>
','<?php echo $this->_tpl_vars['department']; ?>
','<?php echo $this->_tpl_vars['school_year']; ?>
','<?php echo $this->_tpl_vars['grade']; ?>
','<?php echo $this->_tpl_vars['class']; ?>
','<?php echo $this->_tpl_vars['v']; ?>
')" id="school_t"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['school_options'],'selected' => $this->_tpl_vars['school_id']), $this);?>
 </select></td>
</tr>
<tr>
  <td bgcolor="#F3F6FF" class="template_data"> Select a department</td>
  <td bgcolor="#F3F6FF" class="template_data"> <select name="department_t" onchange="student_drop_list(year_t.value,school_t.value,department_t.value,grade_t.value,class_t.value,'<?php echo $this->_tpl_vars['school']; ?>
','<?php echo $this->_tpl_vars['department']; ?>
','<?php echo $this->_tpl_vars['school_year']; ?>
','<?php echo $this->_tpl_vars['grade']; ?>
','<?php echo $this->_tpl_vars['class']; ?>
','<?php echo $this->_tpl_vars['v']; ?>
')" id="department_t"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['department_options'],'selected' => $this->_tpl_vars['department_id']), $this);?>
 </select></td>
</tr>
<tr>
  <td bgcolor="#F3F6FF" class="template_data"> Select a grade</td>
  <td bgcolor="#F3F6FF" class="template_data"> <select name="grade_t" onchange="student_drop_list(year_t.value,school_t.value,department_t.value,grade_t.value,class_t.value,'<?php echo $this->_tpl_vars['school']; ?>
','<?php echo $this->_tpl_vars['department']; ?>
','<?php echo $this->_tpl_vars['school_year']; ?>
','<?php echo $this->_tpl_vars['grade']; ?>
','<?php echo $this->_tpl_vars['class']; ?>
','<?php echo $this->_tpl_vars['v']; ?>
')" id="grade_t"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['grade_options'],'selected' => $this->_tpl_vars['grade_id']), $this);?>
 </select></td>
</tr>
<tr>
  <td bgcolor="#F3F6FF" class="template_data"> Select a class</td>
  <td bgcolor="#F3F6FF" class="template_data"> <select name="class_t" id="class_t"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['class_options'],'selected' => $this->_tpl_vars['klas_id']), $this);?>
 </select></td>
</tr>
</table>


<?php echo $this->_tpl_vars['new_student']; ?>



</form>
