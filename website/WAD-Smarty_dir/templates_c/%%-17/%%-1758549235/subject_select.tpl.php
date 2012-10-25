<?php /* Smarty version 2.4.2, created on 2005-02-07 20:45:23
         compiled from subject_select.tpl */ ?>
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
<form action="<?php echo $this->_tpl_vars['subject_action']; ?>
" method="POST">


<table border="true" bgcolor="#f3f6ff" frame="border">
  <?php echo $this->_tpl_vars['subject_select_all']; ?>

  <?php echo $this->_tpl_vars['subject_list']; ?>

</table>

</form>






</body>
</html>