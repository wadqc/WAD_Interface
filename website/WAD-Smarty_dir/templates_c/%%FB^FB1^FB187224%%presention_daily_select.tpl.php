<?php /* Smarty version 2.6.7, created on 2005-04-06 10:57:46
         compiled from presention_daily_select.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Attendance General</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body onLoad="javascript:document.first.student_id.focus();" bgcolor="#F3F6FF">

<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
 </h1>
<form name="first" action="<?php echo $this->_tpl_vars['presention_daily_action']; ?>
" method="POST">

<table border  bgcolor="#f3f6ff" frame="border" NOSAVE>
  <td class="table_data_blue" align="center">
    <input type="text" name="student_id" id="1234">
  </td>
  <td class="table_data_blue" align="center">
     <input type="submit" name="Enter" value="Enter"  class="table_data_blue">
  </td>
</table>

</form>


</body>
</html>