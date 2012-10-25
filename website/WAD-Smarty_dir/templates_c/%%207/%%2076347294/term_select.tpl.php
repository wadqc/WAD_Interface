<?php /* Smarty version 2.4.2, created on 2005-02-06 17:42:01
         compiled from term_select.tpl */ ?>
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
<table border  bgcolor="#f3f6ff" frame="border" NOSAVE>
  <?php echo $this->_tpl_vars['term_list']; ?>

</table>
<input type="submit" name="submit" value="submit"> 
</form>
</body>
</html>