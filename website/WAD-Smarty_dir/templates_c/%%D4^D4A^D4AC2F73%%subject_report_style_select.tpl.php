<?php /* Smarty version 2.6.7, created on 2005-12-20 12:40:35
         compiled from subject_report_style_select.tpl */ ?>
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
<h1 class="table_data_blue" >Report Content </h1>
<form action="<?php echo $this->_tpl_vars['form_action']; ?>
" method="POST">


<table NOSAVE="true" width="100%" border="true" bgcolor="#f3f6ff" frame="border">
  <?php echo $this->_tpl_vars['subject_list']; ?>

</table>


<a href="<?php echo $this->_tpl_vars['new_subject']; ?>
" class="table_data_select">arrange subjects</a>



<h1 class="table_data_blue" >Report Results </h1>

<table NOSAVE="true" width="100%" border="true" bgcolor="#f3f6ff" frame="border">
  <?php echo $this->_tpl_vars['report_list']; ?>

</table>
<a href="<?php echo $this->_tpl_vars['new_report']; ?>
" class="table_data_select">modify report</a>



</form>
</body>
</html>