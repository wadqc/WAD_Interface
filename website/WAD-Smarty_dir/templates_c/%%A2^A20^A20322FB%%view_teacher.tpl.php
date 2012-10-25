<?php /* Smarty version 2.6.7, created on 2007-11-03 03:16:02
         compiled from view_teacher.tpl */ ?>
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
<hr>
<font class="table_data_blue_header">Personal</font>
<table>
  <tr>
    <td>
      <table valign="top" align="left">
        <tr>
          <td class="table_data_blue"> Title </td>
	      <td class="table_data"> <?php echo $this->_tpl_vars['default_teacher_title']; ?>
 </td>
		</tr>
    	<tr>
          <td class="table_data_blue"> Firstname  </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['default_teacher_firstname']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Middlename </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['default_teacher_middlename']; ?>
  </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Lastname </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['default_teacher_lastname']; ?>
  </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Gender </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['teacher_sex_id']; ?>
    </td>
        </tr>
       <tr>
          <td class="table_data_blue"> Address </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['default_teacher_address']; ?>
  </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Date of birth </td>
          <td class="table_data">  <?php echo $this->_tpl_vars['teacher_date_of_birth']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Place of birth </td>
	      <td class="table_data">  <?php echo $this->_tpl_vars['teacher_place_of_birth_id']; ?>
  </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Nationality </td>
	      <td class="table_data"> <?php echo $this->_tpl_vars['teacher_nationality_id']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Religion </td>
	      <td class="table_data"> <?php echo $this->_tpl_vars['teacher_religion_id']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Language </td>
	      <td class="table_data">  <?php echo $this->_tpl_vars['teacher_language_id']; ?>
 </td>
        </tr>
      </table>
    </td>
    <td valign="top" class="table_data">
      <table valign="top" align="left">
        <tr>
          <td class="table_data_blue"> Home Phone </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['default_teacher_home_phone']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Cell phone </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['default_teacher_cell_phone']; ?>
 </td>
        </tr>
		<tr>
          <td class="table_data_blue"> Fax </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['default_teacher_fax']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Email </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['default_teacher_email']; ?>
 </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
		</tr>
		<tr>
          <td>&nbsp;</td>
		</tr>
		<tr>
          <td>&nbsp;</td>
		</tr>
		<tr>
          <td class="table_data_blue"> Marital Status</td>
	      <td class="table_data"> <?php echo $this->_tpl_vars['teacher_marital_status_id']; ?>
 </td>
        </tr>
		<tr>
          <td class="table_data_blue"> Name Spouse</td>
          <td class="table_data"> <?php echo $this->_tpl_vars['default_teacher_spouse']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Children</td>
	      <td class="table_data"> <?php echo $this->_tpl_vars['teacher_children_id']; ?>
 </td>
        </tr>
      </table>
    </td>
    <td valign="top" class="table_data"> <img src="<?php echo $this->_tpl_vars['default_picture']; ?>
" border=0> </td>
  </tr>
</table>
<hr>
<font class="table_data_blue_header">Employment</font>
<table>
  <tr>
    <td class="table_data_blue"> Date of employment </td>
    <td class="table_data">  <?php echo $this->_tpl_vars['teacher_date_of_employment']; ?>
  </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Subject(s) to be taught</td>
	<td class="table_data"> <?php echo $this->_tpl_vars['default_teacher_employment_subjects']; ?>
</td>
  </tr>
</table>
<table>
  <tr>
    <td class="table_data_blue"> Qualifications </td>
    <td class="table_data_blue"> Certificates/Courses </td>
  </tr>
  <tr>
	<td class="table_data">
      <textarea cols="40" rows="5"><?php echo $this->_tpl_vars['default_teacher_employment_qualifications']; ?>
</textarea>
	</td>
	<td class="table_data">
      <textarea cols="40" rows="5"><?php echo $this->_tpl_vars['default_teacher_employment_certificates']; ?>
</textarea>
    </td>
  </tr>
</table>
<hr>
<font class="table_data_blue_header">Priveleges</font>
<table>
  <tr>
    <td class="table_data_blue"> Initials </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['default_teacher_initials']; ?>
 </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Login </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['default_teacher_login']; ?>
 </td>
  </tr>
  <tr>
    <td colspan="2">
      <table>
        <tr>
          <td class="table_data"> <input type="radio" <?php echo $this->_tpl_vars['checked_login_level_1']; ?>
> </td>
          <td class="table_data"> <input type="radio" <?php echo $this->_tpl_vars['checked_login_level_2']; ?>
> </td>
          <td class="table_data"> <input type="radio" <?php echo $this->_tpl_vars['checked_login_level_3']; ?>
> </td>
		  <td class="table_data"> <input type="radio" <?php echo $this->_tpl_vars['checked_login_level_4']; ?>
> </td>
          <td class="table_data"> <input type="radio" <?php echo $this->_tpl_vars['checked_login_level_5']; ?>
> </td>
        </tr>
        <tr>
          <td class="table_data"> Admin </td>
          <td class="table_data"> Management </td>
          <td class="table_data"> Attendance </td>
          <td class="table_data"> Teacher </td>
          <td class="table_data"> Secretary </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<hr>
</body>
</HTML>

