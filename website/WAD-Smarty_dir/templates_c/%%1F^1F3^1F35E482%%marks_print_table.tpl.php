<?php /* Smarty version 2.6.7, created on 2005-06-02 15:10:22
         compiled from marks_print_table.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/printer/styles.css" type="text/css">
  <title>Grades print</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="white">
<h1 class="table_data_header" ><?php echo $this->_tpl_vars['header']; ?>
 Class average: <?php echo $this->_tpl_vars['average']; ?>
</h1>

<table NOSAVE="true" border="1" bgcolor="#a9a9a9" frame="border">
   <tr bgcolor="white"><td colspan="3" align="right" class="table_data_header">Description</td><?php echo $this->_tpl_vars['description_input']; ?>
</tr>
   <tr bgcolor="white"><td colspan="3" align="right" class="table_data_header">Date</td><?php echo $this->_tpl_vars['date_input']; ?>
</tr>
   <tr bgcolor="white"><td colspan="3" align="right" class="table_data_header">Weight</td><?php echo $this->_tpl_vars['weigth_input']; ?>
</tr>
   <tr bgcolor="white"><td class="table_data_header">First&nbsp;Name</td><td class="table_data_header">Last&nbsp;Name</td><td class="table_data_header">Report</td><?php echo $this->_tpl_vars['mr']; ?>
</tr>
   <?php echo $this->_tpl_vars['student_marks']; ?>

</table>

</body>
</HTML>