<?php /* Smarty version 2.6.7, created on 2010-06-07 21:15:07
         compiled from school_report.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head >
  <link   rel="StyleSheet" href="./css/printer/styles.css" type="text/css">
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
<table>
  <tr>
    <td>
      <table>
        <tr>
          <td width="100p" class="report_header_data">Student</td>
          <td class="report_header_data"><?php echo $this->_tpl_vars['student_name']; ?>
 <font class="report_row_data" >(<?php echo $this->_tpl_vars['student_date_of_birth']; ?>
) </font></td>
        </tr>
        <tr>
          <td width="100p" class="report_row_data">Department</td>
          <td class="report_row_data"><?php echo $this->_tpl_vars['department']; ?>
</td>
        </tr>
        <tr>
          <td width="100p"class="report_row_data">Class</td>
          <td class="report_row_data"><?php echo $this->_tpl_vars['class']; ?>
</td>
        </tr>
        <tr>
          <td width="100p" class="report_row_data">Mentor</td>
          <td class="report_row_data"><?php echo $this->_tpl_vars['mentor']; ?>
</td>
       </tr>
     </table>
   </td>
   <td>
     <table>
       <?php echo $this->_tpl_vars['table_report_year']; ?>

	 </table>
   </td>
  </tr>
</table>

<hr align="center" size="1px" noshade>


<table>
  <tr>
    <td rowspan="3" align="left" valign="top">
      <table bgcolor="black">
        <?php echo $this->_tpl_vars['results_table']; ?>

      </table>
    </td>
    <td align="left" valign="top">
	    <?php echo $this->_tpl_vars['presention_table']; ?>

    </td>
  </tr>
  <tr>
    <td align="left" valign="bottom">
        <?php echo $this->_tpl_vars['skill_score_table']; ?>

    </td>
  </tr>
  <tr>
    <td align="left" valign="bottom">
        <?php echo $this->_tpl_vars['comment_table']; ?>

    </td>
  </tr>
</table>

<hr align="center" noshade size="1px">
<br>

<p align="left" class="report_sub_tittle_data"><?php echo $this->_tpl_vars['signature_info']; ?>
 </p>
<div style="page-break-after:always"></div>

</body>

</html>