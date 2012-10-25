<?php /* Smarty version 2.4.2, created on 2005-02-10 00:49:02
         compiled from new_teacher.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'new_teacher.tpl', 47, false),
array('function', 'html_select_date', 'new_teacher.tpl', 59, false),)); ?><!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>template verwijzer</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<form action="<?php echo $this->_tpl_vars['action_new_teacher']; ?>
" method="POST" >
<hr>
<font class="table_data_blue_header">Personal</font>
<table>
  <tr>
    <td>
      <table valign="top" align="left">
        <tr>
          <td class="table_data_blue"> Title </td>
	      <td class="table_data">
           <input   name="teacher_title" type="text" value="<?php echo $this->_tpl_vars['default_teacher_title']; ?>
" size="10"> </input>
          </td>
		</tr>
    	<tr>
          <td class="table_data_blue"> Firstname</td>
          <td class="table_data">
           <input   name="teacher_firstname" type="text" value="<?php echo $this->_tpl_vars['default_teacher_firstname']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Middlename </td>
          <td class="table_data">
            <input   name="teacher_middlename" type="text" value="<?php echo $this->_tpl_vars['default_teacher_middlename']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Lastname <font class="table_data_red">*</font></td>
          <td class="table_data">
            <input   name="teacher_lastname" type="text" value="<?php echo $this->_tpl_vars['default_teacher_lastname']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Gender </td>
          <td class="table_data">
            <select name="teacher_sex">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['teacher_sex_options'],'selected' => $this->_tpl_vars['teacher_sex_id']), $this) ; ?>

            </select>
          </td>
        </tr>
       <tr>
          <td class="table_data_blue"> Address </td>
          <td class="table_data">
            <input   name="teacher_address" type="text" value="<?php echo $this->_tpl_vars['default_teacher_address']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Date of birth </td>
          <td class="table_data">  <?php echo $this->_plugins['function']['html_select_date'][0](array('time' => $this->_tpl_vars['teacher_date_of_birth'],'start_year' => "-100",'end_year' => "+5",'prefix' => "teacher_birth_",'year_empty' => "Leeg",'month_empty' => "MM",'day_empty' => "DD",'label' => "false"), $this) ; ?>
  </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Place of birth </td>
	      <td class="table_data">
            <select name="teacher_place_of_birth">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['teacher_place_of_birth_options'],'selected' => $this->_tpl_vars['teacher_place_of_birth_id']), $this) ; ?>

            </select>
         </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Nationality </td>
	      <td class="table_data">
            <select name="teacher_nationality">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['teacher_nationality_options'],'selected' => $this->_tpl_vars['teacher_nationality_id']), $this) ; ?>

            </select>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Religion </td>
	      <td class="table_data">
            <select name="teacher_religion">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['teacher_religion_options'],'selected' => $this->_tpl_vars['teacher_religion_id']), $this) ; ?>

            </select>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Language </td>
	      <td class="table_data">
            <select name="teacher_language">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['teacher_language_options'],'selected' => $this->_tpl_vars['teacher_language_id']), $this) ; ?>

            </select>
          </td>
        </tr>
      </table>
    </td>
    <td valign="top" class="table_data">
      <table valign="top" align="left">
        <tr>
          <td class="table_data_blue"> Home Phone </td>
          <td class="table_data">
            <input   name="teacher_home_phone" type="text" value="<?php echo $this->_tpl_vars['default_teacher_home_phone']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Cell phone </td>
          <td class="table_data">
            <input   name="teacher_cell_phone" type="text" value="<?php echo $this->_tpl_vars['default_teacher_cell_phone']; ?>
" size="30"> </input>
          </td>
        </tr>
		<tr>
          <td class="table_data_blue"> Fax </td>
          <td class="table_data">
            <input   name="teacher_fax" type="text" value="<?php echo $this->_tpl_vars['default_teacher_fax']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Email </td>
          <td class="table_data">
            <input   name="teacher_email" type="text" value="<?php echo $this->_tpl_vars['default_teacher_email']; ?>
" size="30"> </input>
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
          <td>&nbsp;</td>
		</tr>
		<tr>
          <td>&nbsp;</td>
		</tr>
		<tr>
          <td class="table_data_blue"> Merital Status</td>
	      <td class="table_data">
            <select name="teacher_marital_status">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['teacher_marital_status_options'],'selected' => $this->_tpl_vars['teacher_marital_status_id']), $this) ; ?>

            </select>
          </td>
        </tr>
		<tr>
          <td class="table_data_blue"> Name Spouse</td>
          <td class="table_data">
            <input   name="teacher_spouse" type="text" value="<?php echo $this->_tpl_vars['default_teacher_spouse']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Children</td>
	      <td class="table_data">
            <select name="teacher_children">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['teacher_children_options'],'selected' => $this->_tpl_vars['teacher_children_id']), $this) ; ?>

            </select>
          </td>
        </tr>
      </table>
    </td>
    <td valign="top" class="table_data">
         <input type="image" name="picture" value="picture" src="<?php echo $this->_tpl_vars['default_picture']; ?>
">
	</td>
  </tr>
</table>
<hr>
<font class="table_data_blue_header">Employment</font>
<table>
  <tr>
    <td class="table_data_blue"> Date of employment </td>
    <td class="table_data">  <?php echo $this->_plugins['function']['html_select_date'][0](array('time' => $this->_tpl_vars['teacher_date_of_employment'],'start_year' => "-100",'end_year' => "+5",'prefix' => "teacher_employment_",'label' => "false"), $this) ; ?>
  </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Subject(s) to be taught</td>
	<td class="table_data">
      <input   name="teacher_employment_subjects" type="text" value="<?php echo $this->_tpl_vars['default_teacher_employment_subjects']; ?>
" size="30"> </input>
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
      <textarea name="teacher_employment_qualifications" cols="40" rows="5"><?php echo $this->_tpl_vars['default_teacher_employment_qualifications']; ?>
</textarea>
	</td>
	<td class="table_data">
      <textarea name="teacher_employment_certificates" cols="40" rows="5"><?php echo $this->_tpl_vars['default_teacher_employment_certificates']; ?>
</textarea>
    </td>
  </tr>
</table>
<hr>
<font class="table_data_blue_header">Privileges</font>
<table>
  <tr>
    <td class="table_data_blue"> Initials <font class="table_data_red">*</font></td>
    <td class="table_data">
      <input   name="teacher_initials" type="text" value="<?php echo $this->_tpl_vars['default_teacher_initials']; ?>
" size="30"> </input>
    </td>
  <tr>
  </tr>
	<td class="table_data_blue"> Login <font class="table_data_red">*</font></td>
    <td class="table_data">
      <input   name="teacher_login" type="text" value="<?php echo $this->_tpl_vars['default_teacher_login']; ?>
" size="30"> </input>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <table>
	    <tr>
          <td colspan="3" align="center" class="table_data_red">One selection</td>
        </tr>
        <tr>
          <td class="table_data"> <input type="checkbox" <?php echo $this->_tpl_vars['checked_login_level_1']; ?>
 name="login_level_1" value="on"> </td>
          <td class="table_data"> <input type="checkbox" <?php echo $this->_tpl_vars['checked_login_level_2']; ?>
 name="login_level_2" value="on"> </td>
          <td class="table_data"> <input type="checkbox" <?php echo $this->_tpl_vars['checked_login_level_3']; ?>
 name="login_level_3" value="on"> </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Teacher </td>
          <td class="table_data_blue"> Attendance </td>
          <td class="table_data_blue"> Admin </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<font class="table_data_red">* Mandatory field</font>
<hr>
<input type="submit" name="action" value="<?php echo $this->_tpl_vars['teacher_value']; ?>
">
</form>
</body>
</HTML>

