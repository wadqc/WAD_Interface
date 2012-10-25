<?php /* Smarty version 2.4.2, created on 2005-02-04 22:05:06
         compiled from view_student_teacher.tpl */ ?>
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


<h1 class="table_data_blue" ><?php echo $this->_tpl_vars['header']; ?>
</h1>


<hr>
<font class="table_data_blue_header">History</font>
<table>
  <tr>
    <td><?php echo $this->_tpl_vars['klas_content']; ?>
 </td>
  </tr>
</table>
<hr>
<font class="table_data_blue_header">Personal</font>
<table>
  <tr>
    <td>
      <table valign="top" align="left">
        <tr>
          <td class="table_data_blue"> Student id </td>
          <td class="table_data"><?php echo $this->_tpl_vars['student_number']; ?>
 </td>
        </tr>
		<tr>
          <td class="table_data_blue"> Firstname </td>
          <td class="table_data"><?php echo $this->_tpl_vars['student_firstname']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Middlename </td>
          <td class="table_data"><?php echo $this->_tpl_vars['student_middlename']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Lastname </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['student_lastname']; ?>
  </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Callname </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['student_callname']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Gender </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['student_sex']; ?>
     </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Date of birth </td>
          <td class="table_data">  <?php echo $this->_tpl_vars['student_date_of_birth']; ?>
  </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Place of birth </td>
	      <td class="table_data"> <?php echo $this->_tpl_vars['student_place_of_birth']; ?>
   </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Nationality </td>
	      <td class="table_data"> <?php echo $this->_tpl_vars['student_nationality']; ?>
      </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Residence Permit No.</td>
          <td class="table_data"> <?php echo $this->_tpl_vars['student_residence_permit']; ?>

          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Religion </td>
	      <td class="table_data"> <?php echo $this->_tpl_vars['student_religion']; ?>
     </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Language </td>
	      <td class="table_data"> <?php echo $this->_tpl_vars['student_language']; ?>
     </td>
        </tr>
      </table>
    </td>
    <td valign="top" class="table_data">
      <table valign="top" align="left">
        <tr>
          <td class="table_data_blue"> Username </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['student_username']; ?>
  </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Password </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['student_password']; ?>
   </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Email </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['student_email']; ?>
       </td>
        </tr>
        <tr>
          <td class="table_data_blue"> General </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['student_general']; ?>
  </td>
        </tr>
        <tr>
		  <td class="table_data_blue"> Transportation </td>
	      <td class="table_data"> <?php echo $this->_tpl_vars['student_transportation']; ?>
   </td>
        </tr>
      </table>
    </td>
    <td valign="top" class="table_data"> <img src="<?php echo $this->_tpl_vars['student_picture']; ?>
" border=0> </td>
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
          <td class="table_data"> <?php echo $this->_tpl_vars['registration_entry_language']; ?>
 </td>
          <td class="table_data_blue"> Math </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['registration_entry_math']; ?>
 </td>
          <td class="table_data_blue"> General Skills </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['registration_entry_general']; ?>
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
          <td class="table_data"> <?php echo $this->_tpl_vars['registration_comes_from']; ?>
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
            <td class="table_data_blue"> School:<?php echo $this->_tpl_vars['student_school']; ?>
</td>
		  </tr>
		  <tr>
            <td class="table_data_blue"> Registration date </td>
		  </tr>
		  <tr>
            <td class="table_data">  <?php echo $this->_tpl_vars['registration_school_in']; ?>
  </td>
          </tr>
		  <tr>
		    <td class="table_data_blue"> Written out date </td>
          </tr>
		  <tr>
		    <td class="table_data">  <?php echo $this->_tpl_vars['registration_school_out']; ?>
 </td>
		  </tr>
        </table>
      </td>
      <td>
        <table>
          <tr>
            <td class="table_data_blue"> Department:<?php echo $this->_tpl_vars['student_department']; ?>
</td>
		  </tr>
		  <tr>
            <td class="table_data_blue"> Registration date </td>
		  </tr>
		  <tr>
            <td class="table_data">  <?php echo $this->_tpl_vars['registration_department_in']; ?>
  </td>
		  </tr>
		  <tr>
		    <td class="table_data_blue"> Written out date </td>
		  </tr>
		  <tr>
		    <td class="table_data">  <?php echo $this->_tpl_vars['registration_department_out']; ?>
  </td>
          </tr>
        </table>
      </td>
      <td>
        <table>
          <tr>
            <td class="table_data_blue"> Profile </td>
            <td class="table_data"> <?php echo $this->_tpl_vars['student_profile']; ?>
 </td>
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
          <td class="table_data"> <?php echo $this->_tpl_vars['registration_went_to']; ?>

          </td>
          <td class="table_data_blue"> Reason out </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['registration_reason_out']; ?>
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
    <td class="table_data"> <?php echo $this->_tpl_vars['medical_doctor']; ?>
 </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Doctor address </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['medical_doctor_address']; ?>
 </td>
  </tr>
  <tr>
  <tr>
    <td class="table_data_blue"> Doctor Phone </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['medical_doctor_phone']; ?>
 </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Vaccination card </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['medical_vaccination_card']; ?>
  </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Medical Problems </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['medical_problems']; ?>
   </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Medication </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['medical_medication']; ?>
  </td>
  </tr>
</table>
<hr>
<font class="table_data_blue_header">Parental data</font>
<table>
  <tr>
    <td class="table_data_blue"> Student lives with </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['student_lives_with']; ?>
   </td>
  </tr>
</table>
<?php echo $this->_tpl_vars['table_fmg']; ?>

<hr>



</body>
</HTML>

