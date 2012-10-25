<?php /* Smarty version 2.4.2, created on 2005-02-14 17:26:25
         compiled from marks_table.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>template student</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">
<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
</h1>
<form action="<?php echo $this->_tpl_vars['marks_action']; ?>
" method="POST">

<table NOSAVE="true" width="%" border="true" bgcolor="#f3f6ff" frame="border">
   <tr><?php echo $this->_tpl_vars['submit_button']; ?>
<td width="6*" colspan="2" class="table_data"></td><?php echo $this->_tpl_vars['description']; ?>
</tr>
   <tr><td width="6*" colspan="3" class="table_data"></td><?php echo $this->_tpl_vars['description_input']; ?>
</tr>
   <tr><td width="6*" colspan="3" class="table_data"></td><?php echo $this->_tpl_vars['date']; ?>
</tr>
   <tr><td width="6*" colspan="2" class="table_data"></td><td class="table_data">Date</td><?php echo $this->_tpl_vars['date_input']; ?>
</tr>
   <tr><td width="6*" colspan="2" class="table_data"></td><td class="table_data">Weigth</td><?php echo $this->_tpl_vars['weigth_input']; ?>
</tr>
   <tr><td width="2*" class="table_marks_header">First Name</td><td width="2*" class="table_marks_header">Last Name</td><td width="2*" class="table_marks_header">Report</td><?php echo $this->_tpl_vars['mr']; ?>
</tr>
   <?php echo $this->_tpl_vars['student_marks']; ?>

</table>

</form>
</body>
</HTML>