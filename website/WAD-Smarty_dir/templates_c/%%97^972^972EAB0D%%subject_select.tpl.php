<?php /* Smarty version 2.6.7, created on 2008-11-23 09:16:49
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

<table width:90%>
<tr>
  <td align="left" valign="top">
     <table NOSAVE="true" border="true" bgcolor="#f3f6ff" frame="border" width:35%>
        <?php echo $this->_tpl_vars['table_student_select']; ?>

	 </table>
  </td>
  <td align="left" valign="top">
    <div id="d1" style="heigth:100px; width:1040px; overflow:auto;">
      <table NOSAVE="true" border="true" bgcolor="#f3f6ff" frame="border" >
         <?php echo $this->_tpl_vars['table_subject_select']; ?>

	  </table>
   </div>
  </td>
</tr>
</table>

</form>






</body>
</html>