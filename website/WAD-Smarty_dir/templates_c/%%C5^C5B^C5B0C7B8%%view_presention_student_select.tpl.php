<?php /* Smarty version 2.6.7, created on 2005-04-07 09:07:54
         compiled from view_presention_student_select.tpl */ ?>
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


<table NOSAVE="true" width="100%" border="true" bgcolor="#f3f6ff" frame="border">
  <tr>
    <td><font color="blue"><b>Number</b></font></td>
    <td><font color="blue"><b>First Name</b></font></td>
    <td><font color="blue"><b>Last Name</b></font></td>
    <td><font color="blue"><b>Profile</b></font></td>
  </tr>
  <?php echo $this->_tpl_vars['student_list']; ?>

</table>


</body>
</html>