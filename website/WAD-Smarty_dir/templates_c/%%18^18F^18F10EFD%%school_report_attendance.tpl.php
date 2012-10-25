<?php /* Smarty version 2.6.7, created on 2006-03-10 13:41:54
         compiled from school_report_attendance.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>Term Report</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>

<body bgcolor="white">

<table width="100%">
    <tr>
      <td align="center" class="report_tittle_data"><img src="<?php echo $this->_tpl_vars['picture_logo']; ?>
" align="middle" border="0"></td>
	</tr>
    <tr>
      <td align="center" class="report_tittle_data"><?php echo $this->_tpl_vars['header_name']; ?>
</td>
	</tr>
	<tr>
      <td align="center" class="report_header_data"><?php echo $this->_tpl_vars['term_info']; ?>
</td>
    </tr>
</table>

<hr align="center" noshade size="1px">
<p><b>Student absenteism (days)</b></p>
<table>
   <?php echo $this->_tpl_vars['attendance_list']; ?>

 </table>
<hr align="center" size="1px" noshade>
<p><b>Student statistics</b></p>
<table>
   <tr>
      <td align="center" class="table_data_blue_header">Date</td>
	  <td align="center" class="table_data_blue_header">Males</td>
	  <td align="center" class="table_data_blue_header">Females</td>
	</tr>
	<tr bgcolor="#B8E7FF">
      <td align="center" class="table_data"><?php echo $this->_tpl_vars['start_date']; ?>
</td>
	  <td align="center" class="table_data"><?php echo $this->_tpl_vars['start_males']; ?>
</td>
	  <td align="center" class="table_data"><?php echo $this->_tpl_vars['start_females']; ?>
</td>
	</tr>
	<tr>
      <td align="center" class="table_data"><?php echo $this->_tpl_vars['stop_date']; ?>
</td>
	  <td align="center" class="table_data"><?php echo $this->_tpl_vars['stop_males']; ?>
</td>
	  <td align="center" class="table_data"><?php echo $this->_tpl_vars['stop_females']; ?>
</td>
	</tr>
 </table>
<p><b>Written in <?php echo $this->_tpl_vars['in_comment']; ?>
</b></p>
<table>
   <?php echo $this->_tpl_vars['student_in']; ?>

 </table>
<p><b>Written out <?php echo $this->_tpl_vars['out_comment']; ?>
</b></p>
<table>
   <?php echo $this->_tpl_vars['student_out']; ?>

 </table>

<hr align="center" size="1px" noshade>
</body>

</html>