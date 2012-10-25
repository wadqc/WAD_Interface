<?php /* Smarty version 2.4.2, created on 2005-02-06 17:39:40
         compiled from presention_subject_select.tpl */ ?>
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
<form action=<?php echo $this->_tpl_vars['date_action']; ?>
 method="POST">

<table>
<tr>
  <td colspan="3" align="center" class="table_data">
    <?php echo $this->_tpl_vars['calendar_day']; ?>

  </td>
</tr>
<tr>
  <td  class="table_data">
   <input type="image" name="down" value="down" src="./buttons/arrow_down.jpg">
  </td>
  <td  class="table_data">
    <?php echo $this->_tpl_vars['month_day_year']; ?>

  </td>
  <td  class="table_data">
    <input type="image" name="up" value="up" src="./buttons/arrow_up.jpg">
  </td>
</tr>
</table>

<table border  bgcolor="#f3f6ff" frame="border" NOSAVE>
  <?php echo $this->_tpl_vars['subject_list']; ?>

</table>

</form>


</body>
</html>