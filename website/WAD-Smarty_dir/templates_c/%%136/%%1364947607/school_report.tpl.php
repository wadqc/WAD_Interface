<?php /* Smarty version 2.4.2, created on 2005-02-09 12:20:45
         compiled from school_report.tpl */ ?>
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns="http://www.w3.org/TR/REC-html40">
<head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>template verwijzer</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<title>Report</title>

<body>
<table width="100%">
  <tbody>
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

<hr align="center" noshade size="1">
<table>
  <tbody>
    <tr>
      <td class="report_header_data">Student</td>
      <td class="report_header_data"><?php echo $this->_tpl_vars['student_name']; ?>
</td>
    </tr>
    <tr>
      <td class="report_header_data">Department</td>
      <td class="report_header_data"><?php echo $this->_tpl_vars['department']; ?>
</td>
    </tr>
    <tr>
      <td class="report_header_data">Class</td>
      <td class="report_header_data"><?php echo $this->_tpl_vars['class']; ?>
</td>
    </tr>
  </tbody>
</table>
<hr align="center" size="1" noshade>


<table>
  <tr>
    <td class="report_sub_tittle_data">Results</td>
    <td width="100pix" class="report_sub_tittle_data"> </td>
    <td class="report_sub_tittle_data">Absenteism</td>
  </tr>
  <tr>
  <td>
    <table bgcolor="#bebebe">
      <?php echo $this->_tpl_vars['results_table']; ?>

    </table>
  </td>
  <td width="100pix"></td>
  <td>
   <?php echo $this->_tpl_vars['presention_table']; ?>

  </td>
 </tr>
</table>

<hr align="center" noshade size="1">
<p align="left" class="report_sub_tittle_data"><?php echo $this->_tpl_vars['signature_info']; ?>
 </p>
<div style="page-break-after:always"></div>

</body>

</html>