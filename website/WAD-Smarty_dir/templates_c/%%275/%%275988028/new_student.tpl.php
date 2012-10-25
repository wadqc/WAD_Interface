<?php /* Smarty version 2.4.2, created on 2005-02-09 12:05:00
         compiled from new_student.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'new_student.tpl', 47, false),
array('function', 'html_select_date', 'new_student.tpl', 53, false),)); ?><!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>template verwijzer</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<form action="<?php echo $this->_tpl_vars['action_new_student']; ?>
" method="POST" >
<hr>
<font class="table_data_blue_header">Personal</font>
<table>
  <tr>
    <td>
      <table valign="top" align="left">
        <tr>
          <td class="table_data_blue"> Firstname</td>
          <td class="table_data">
           <input   name="student_firstname" type="text" value="<?php echo $this->_tpl_vars['default_student_firstname']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Middlename </td>
          <td class="table_data">
            <input   name="student_middlename" type="text" value="<?php echo $this->_tpl_vars['default_student_middlename']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Lastname </td>
          <td class="table_data">
            <input   name="student_lastname" type="text" value="<?php echo $this->_tpl_vars['default_student_lastname']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Callname </td>
          <td class="table_data">
            <input   name="student_callname" type="text" value="<?php echo $this->_tpl_vars['default_student_callname']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Gender </td>
          <td class="table_data">
            <select name="student_sex">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['student_sex_options'],'selected' => $this->_tpl_vars['student_sex_id']), $this) ; ?>

            </select>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Date of birth </td>
          <td class="table_data">  <?php echo $this->_plugins['function']['html_select_date'][0](array('time' => $this->_tpl_vars['student_date_of_birth'],'start_year' => "-100",'end_year' => "+5",'prefix' => "student_",'label' => "false"), $this) ; ?>
  </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Place of birth </td>
	      <td class="table_data">
            <select name="student_place_of_birth">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['student_place_of_birth_options'],'selected' => $this->_tpl_vars['student_place_of_birth_id']), $this) ; ?>

            </select>
         </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Nationality </td>
	      <td class="table_data">
            <select name="student_nationality">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['student_nationality_options'],'selected' => $this->_tpl_vars['student_nationality_id']), $this) ; ?>

            </select>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Residence Permit No.</td>
          <td class="table_data">
            <input   name="student_residence_permit" type="text" value="<?php echo $this->_tpl_vars['default_student_residence_permit']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Religion </td>
	      <td class="table_data">
            <select name="student_religion">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['student_religion_options'],'selected' => $this->_tpl_vars['student_religion_id']), $this) ; ?>

            </select>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Language </td>
	      <td class="table_data">
            <select name="student_language">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['student_language_options'],'selected' => $this->_tpl_vars['student_language_id']), $this) ; ?>

            </select>
          </td>
        </tr>
      </table>
    </td>
    <td valign="top" class="table_data">
      <table valign="top" align="left">
        <tr>
          <td class="table_data_blue"> Username </td>
          <td class="table_data">
            <input   name="student_username" type="text" value="<?php echo $this->_tpl_vars['default_student_username']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Password </td>
          <td class="table_data">
            <input   name="student_password" type="text" value="<?php echo $this->_tpl_vars['default_student_password']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Email </td>
          <td class="table_data">
            <input   name="student_email" type="text" value="<?php echo $this->_tpl_vars['default_student_email']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> General </td>
          <td class="table_data">
            <input   name="student_general" type="text" value="<?php echo $this->_tpl_vars['default_student_general']; ?>
" size="30"> </input>
          </td>
        </tr>
		<tr>
		  <td class="table_data_blue"> Old Id </td>
	      <td class="table_data">
            <input name="student_transportation" type="text" value="<?php echo $this->_tpl_vars['student_transportation_id']; ?>
" size="30"></input>
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
<font class="table_data_blue_header">Registration</font>
<table>
  <tr>
    <td class="table_data_blue"> Entrance exams </td>
  </tr>
  <tr>
    <td>
      <table>
	    <tr>
          <td class="table_data_blue"> English </td>
          <td class="table_data">
            <input type="text" name="registration_entry_language" value="<?php echo $this->_tpl_vars['default_registration_entry_language']; ?>
" size="3"> </input>
          </td>
          <td class="table_data_blue"> Math </td>
          <td class="table_data">
            <input   name="registration_entry_math" type="text" value="<?php echo $this->_tpl_vars['default_registration_entry_math']; ?>
" size="3"> </input>
          </td>
          <td class="table_data_blue"> General Skills </td>
          <td class="table_data">
            <input   name="registration_entry_general" type="text" value="<?php echo $this->_tpl_vars['default_registration_entry_general']; ?>
" size="3"> </input>
          </td>
        </tr>
	  </table>
    </td>
  </tr>
  <tr>
    <td>
      <table>
        <tr>
          <td class="table_data_blue"> Comes from </td>
          <td class="table_data">
            <select name="registration_comes_from">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['registration_comes_from_options'],'selected' => $this->_tpl_vars['registration_comes_from_id']), $this) ; ?>

            </select>
          </td>
		</tr>
	  </table>
	 </td>
  </tr>
  <tr>
  <table>
    <tr>
      <td>
        <table>
          <tr>
            <td class="table_data_blue"> School:<?php echo $this->_tpl_vars['school']; ?>
</td>
		  </tr>
		  <tr>
            <td class="table_data_blue"> Registration date </td>
		  </tr>
		  <tr>
            <td class="table_data">  <?php echo $this->_plugins['function']['html_select_date'][0](array('time' => $this->_tpl_vars['registration_school_in'],'start_year' => "-100",'end_year' => "+5",'prefix' => "school_in_",'label' => "false"), $this) ; ?>
  </td>
          </tr>
		  <tr>
		    <td class="table_data_blue"> Written out date </td>
          </tr>
		  <tr>
		    <td class="table_data">  <?php echo $this->_plugins['function']['html_select_date'][0](array('time' => $this->_tpl_vars['registration_school_out'],'start_year' => "-100",'end_year' => "+5",'prefix' => "school_out_",'label' => "false"), $this) ; ?>
  </td>
		  </tr>
        </table>
      </td>
      <td>
        <table>
          <tr>
            <td class="table_data_blue"> Department:<?php echo $this->_tpl_vars['department']; ?>
</td>
		  </tr>
		  <tr>
            <td class="table_data_blue"> Registration date </td>
		  </tr>
		  <tr>
            <td class="table_data">  <?php echo $this->_plugins['function']['html_select_date'][0](array('time' => $this->_tpl_vars['registration_department_in'],'start_year' => "-100",'end_year' => "+5",'prefix' => "department_in_",'label' => "false"), $this) ; ?>
  </td>
		  </tr>
		  <tr>
		    <td class="table_data_blue"> Written out date </td>
		  </tr>
		  <tr>
		    <td class="table_data">  <?php echo $this->_plugins['function']['html_select_date'][0](array('time' => $this->_tpl_vars['registration_department_out'],'start_year' => "-100",'end_year' => "+5",'prefix' => "department_out_",'label' => "false"), $this) ; ?>
  </td>
          </tr>
        </table>
      </td>
      <td>
        <table>
          <tr>
            <td class="table_data_blue"> Profile </td>
            <td class="table_data_blue"> <select name="registration_profile"><?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['registration_profile_options'],'selected' => $this->_tpl_vars['registration_profile_id']), $this) ; ?>
 </select></td>
          </tr>
		</table>
	  </td>
    </tr>
  </table>
  </tr>
  <tr>
    <td>
      <table>
        <tr>
          <td class="table_data_blue"> Went to </td>
          <td class="table_data">
            <input   name="registration_went_to" type="text" value="<?php echo $this->_tpl_vars['default_registration_went_to']; ?>
" size="30"> </input>
          </td>
          <td class="table_data_blue"> Reason out </td>
          <td class="table_data">
            <select name="registration_reason_out">
              <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['registration_reason_out_options'],'selected' => $this->_tpl_vars['registration_reason_out_id']), $this) ; ?>

            </select>
          </td>
		</tr>
	  </table>
	</td>
  </tr>
</table>
<hr>
<font class="table_data_blue_header">Medical</font>
<table>
  <tr>
    <td class="table_data_blue"> Doctor </td>
    <td class="table_data">
         <select name="medical_doctor_ref">
           <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['medical_doctor_options'],'selected' => $this->_tpl_vars['medical_doctor_id']), $this) ; ?>

         </select>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Vaccination card </td>
    <td class="table_data">
         <select name="medical_vaccination_card">
           <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['medical_vaccination_card_options'],'selected' => $this->_tpl_vars['medical_vaccination_card_id']), $this) ; ?>

         </select>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Medical Problems </td>
    <td class="table_data">
         <input   name="medical_problems" type="text" value="<?php echo $this->_tpl_vars['default_medical_problems']; ?>
" size="30"> </input>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Medication </td>
    <td class="table_data">
         <input   name="medical_medication" type="text" value="<?php echo $this->_tpl_vars['default_medical_medication']; ?>
" size="30"> </input>
    </td>
  </tr>
</table>
<hr>
<font class="table_data_blue_header">Parental data</font>
<table>
  <tr>
    <td class="table_data_blue"> Student lives with </td>
    <td class="table_data">
      <select name="student_lives_with">
        <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['student_lives_with_options'],'selected' => $this->_tpl_vars['student_lives_with_id']), $this) ; ?>

      </select>
    </td>
  </tr>
</table>
<?php echo $this->_tpl_vars['table_buttons']; ?>

<?php echo $this->_tpl_vars['table_fmg']; ?>

<input type="submit" name="action" value="<?php echo $this->_tpl_vars['submit_value']; ?>
">
</form>
</body>
</HTML>

