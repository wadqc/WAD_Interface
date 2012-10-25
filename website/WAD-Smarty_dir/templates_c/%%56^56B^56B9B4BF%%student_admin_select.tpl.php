<?php /* Smarty version 2.6.7, created on 2007-08-27 08:59:56
         compiled from student_admin_select.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>show_patient_template</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff">
<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
</h1>
<form action="<?php echo $this->_tpl_vars['student_admin_action']; ?>
" method="POST">
<table border bgcolor="#f3f6ff" frame="border">
  <?php echo $this->_tpl_vars['admin_list_all']; ?>

  <tr>
    <td rowspan="2" align="center" valign="center" class="table_data_blue">
      <font><B>First Name</B></font>
    </td>
	<td rowspan="2" align="center" valign="center" class="table_data_blue">
      <font><B>Last Name</B></font>
    </td>
    <td colspan="5" align="center" class="table_data_blue">
      <font><B>class hours</B></font>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue">
      <font><B>Mo</B></font>
    </td>
	<td class="table_data_blue">
      <font><B>Tu</B></font>
    </td>
	<td class="table_data_blue">
      <font><B>We</B></font>
    </td>
	<td class="table_data_blue">
      <font><B>Th</B></font>
    </td>
	<td class="table_data_blue">
      <font><B>Fr</B></font>
    </td>
  </tr>
 <?php echo $this->_tpl_vars['admin_list']; ?>

</table>

</form>






</body>
</html>