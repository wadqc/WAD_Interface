<?php /* Smarty version 2.6.7, created on 2005-09-15 14:20:25
         compiled from report_calculation_term_values.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>template verwijzer</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">



<table width="50%">
<tr>
  <td colspan="2" align="center" valign="center">
    <h2 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
</h1>
  </td>
</tr>
<tr>
  <td align="left" valign="top">
    <table>
      <tr>
        <?php echo $this->_tpl_vars['term_factors']; ?>

       </tr>
    </table>
  </td>
  <td align="right" valign="top">
    <table>
      <tr>
        <td colspan="2" align="left" class="template_data"> <br> </td>
      </tr>
      <tr>
        <td class="template_data"> Alternative tittle</td>
        <td class="table_data"> <?php echo $this->_tpl_vars['default_alternative_tittle']; ?>
</td>
      </tr>
      <tr>
        <td class="template_data"> Show average</td>
        <td class="table_data"> <?php echo $this->_tpl_vars['checked_show_average']; ?>
</td>
      </tr>
      <tr>
        <td class="template_data"> Honor Term</td>
	    <td class="table_data"> <?php echo $this->_tpl_vars['term_honor_id']; ?>
</td>
      </tr>
   </table>
 </td>
</tr>
<tr>
  <td colspan="2" align="center" valign="center">
    <hr>
  </td>
</tr>
</table>
