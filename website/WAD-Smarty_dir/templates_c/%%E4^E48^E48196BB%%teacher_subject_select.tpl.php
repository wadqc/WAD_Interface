<?php /* Smarty version 2.6.7, created on 2007-08-07 07:02:19
         compiled from teacher_subject_select.tpl */ ?>
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
<form action="teacher_subject_add.php?school=<?php echo $this->_tpl_vars['school']; ?>
&school_year=<?php echo $this->_tpl_vars['school_year']; ?>
&year_ref=<?php echo $this->_tpl_vars['year_ref']; ?>
" method="POST">

<table border bgcolor="#f3f6ff" frame="border" NOSAVE>
  <tr><?php echo $this->_tpl_vars['header_content']; ?>
</tr>
  <tr><?php echo $this->_tpl_vars['content']; ?>
</tr>
</table>


<input type="submit" name="submit_button" value="Submit">
</form>






</body>
</html>