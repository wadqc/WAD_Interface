<?php /* Smarty version 2.4.2, created on 2005-02-06 23:03:44
         compiled from score_select.tpl */ ?>
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
<form action="<?php echo $this->_tpl_vars['action']; ?>
" method="POST">





<table>
  <tbody>
    <tr>
      <td>
	    <table border bgcolor="#f3f6ff" frame="border" NOSAVE>
          <?php echo $this->_tpl_vars['subject_list']; ?>

        </table>
      </td>
      <td width="50pixel">  </td>
      <td align="right" valign="top">
	    <table border bgcolor="#f3f6ff" frame="border" NOSAVE>
          <?php echo $this->_tpl_vars['explenation_list']; ?>

        </table>
     </td>
    </tr>
  </tbody>
</table>






<input type="submit" name="submit_button" value="Submit">
</form>






</body>
</html>