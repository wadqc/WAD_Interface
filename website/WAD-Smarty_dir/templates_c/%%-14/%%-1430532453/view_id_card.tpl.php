<?php /* Smarty version 2.4.2, created on 2005-02-04 19:47:46
         compiled from view_id_card.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>Open school (ID cards)</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">
<table border="1">
<tr>
  <td>
  <table>
  <tr align="left" valign="center">
    <td valign="top">
     <table>
       <tr>
         <td class="table_data_blue"> Number </td>
         <td class="table_data"> <?php echo $this->_tpl_vars['student_number']; ?>
</td>
       </tr>
       <tr>
         <td class="table_data_blue"> First name </td>
         <td class="table_data"> <?php echo $this->_tpl_vars['student_firstname']; ?>
 </td>
       </tr>
	   <tr>
         <td class="table_data_blue"> Middle name </td>
         <td class="table_data"> <?php echo $this->_tpl_vars['student_middlename']; ?>
 </td>
       </tr>
       <tr>
         <td class="table_data_blue"> Lastname </td>
         <td class="table_data"> <?php echo $this->_tpl_vars['student_lastname']; ?>
 </td>
       </tr>
       <tr>
         <td class="table_data_blue"> Sex </td>
         <td class="table_data"> <?php echo $this->_tpl_vars['student_sex']; ?>
 </td>
       </tr>
       <tr>
         <td class="table_data_blue"> Date of Birth </td>
         <td class="table_data"> <?php echo $this->_tpl_vars['student_date_of_birth']; ?>
</td>
       </tr>
	   <tr>
         <td class="table_data_blue"> Lives with </td>
         <td class="table_data"> <?php echo $this->_tpl_vars['student_lives_with']; ?>
 </td>
       </tr>
       <tr>
         <td class="table_data_blue"> Address </td>
         <td class="table_data"> <?php echo $this->_tpl_vars['student_address']; ?>
 </td>
       </tr>
	   <tr>
          <td class="table_data_blue"> Department </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['student_department']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Class </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['student_class']; ?>
 </td>
        </tr>
     </table>
    </td>
    <td valign="top">
       <img src="<?php echo $this->_tpl_vars['picture_student']; ?>
" align="top" border="0">
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top">
      <img src="<?php echo $this->_tpl_vars['picture_barcode']; ?>
" align="middle" border="0">
    </td>
  </tr>
  </table>
  </td>
  </tr>
</table>
 <div<?php echo $this->_tpl_vars['page_break']; ?>
></div>

</body>
</HTML>