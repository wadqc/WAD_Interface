<?php /* Smarty version 2.4.2, created on 2005-02-08 15:17:48
         compiled from mentor_select.tpl */ ?>
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
<form action="<?php echo $this->_tpl_vars['mentor_action']; ?>
" method="POST">

<table border bgcolor="#f3f6ff" frame="border">
  <?php echo $this->_tpl_vars['mentor_list_all']; ?>

  <tr>
    <td class="table_data_blue">
      <font><B>First_name</B></font>
    </td>
    <td class="table_data_blue">
      <font><B>Last_name</B></font>
    </td>
	<td class="table_data_blue">
      <font><B>Mentor</B></font>
    </td>
  </tr>
 <?php echo $this->_tpl_vars['mentor_list']; ?>

</table>
</form>






</body>
</html>