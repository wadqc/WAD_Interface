<?php /* Smarty version 2.6.7, created on 2012-05-27 18:17:34
         compiled from new_users.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>Image Quality Control</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<form action="<?php echo $this->_tpl_vars['action_new_users']; ?>
" method="POST" >


<hr>
<font class="table_data_blue_header"> User </font>
<table>
       
        <tr>
          <td class="table_data_blue"> Voornaam</td>
          <td class="table_data">
           <input   name="users_firstname" type="text" value="<?php echo $this->_tpl_vars['default_users_firstname']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Initialen </td>
          <td class="table_data">
            <input   name="users_initials" type="text" value="<?php echo $this->_tpl_vars['default_users_initials']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Achternaam <font class="table_data_red">*</font></td>
          <td class="table_data"> 
            <input   name="users_lastname" type="text" value="<?php echo $this->_tpl_vars['default_users_lastname']; ?>
" size="30"> </input>
          </td>
          <td class="table_data_blue"> <?php echo $this->_tpl_vars['message_lastname']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Telefoon </td>
          <td class="table_data">
            <input   name="users_phone" type="text" value="<?php echo $this->_tpl_vars['default_users_phone']; ?>
" size="30"> </input>
          </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Email </td>
          <td class="table_data"> 
            <input   name="users_email" type="text" value="<?php echo $this->_tpl_vars['default_users_email']; ?>
" size="30"> </input>
          </td>
        </tr>




</table>


<hr>
<font class="table_data_blue_header">Privileges</font>
<table>
   </tr>
	<td class="table_data_blue"> Login <font class="table_data_red">*</font></td>
    <td class="table_data">
      <input   name="users_login" type="text" value="<?php echo $this->_tpl_vars['default_users_login']; ?>
" size="30"> </input>
    </td>
    <td class="table_data_blue"> <?php echo $this->_tpl_vars['message_login']; ?>
 </td>
  </tr>
  <tr>
    <td colspan="2">
      <table>
	    <tr>
          <td colspan="5" align="center" class="table_data_red">Maak een unieke keuze</td>
        </tr>
        <tr>
          <td class="table_data"> <input type="checkbox" <?php echo $this->_tpl_vars['checked_login_level_1']; ?>
 name="login_level_1" value="on"> </td>
          <td class="table_data"> <input type="checkbox" <?php echo $this->_tpl_vars['checked_login_level_2']; ?>
 name="login_level_2" value="on"> </td>
          <td class="table_data"> <input type="checkbox" <?php echo $this->_tpl_vars['checked_login_level_3']; ?>
 name="login_level_3" value="on"> </td>
	    <td class="table_data"> <input type="checkbox" <?php echo $this->_tpl_vars['checked_login_level_4']; ?>
 name="login_level_4" value="on"> </td>
          <td class="table_data"> <input type="checkbox" <?php echo $this->_tpl_vars['checked_login_level_5']; ?>
 name="login_level_5" value="on"> </td>
          <td class="table_data_blue"> <?php echo $this->_tpl_vars['message_level']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Admin </td>
		  <td class="table_data_blue"> Management </td>
		  <td class="table_data_blue"> Attendance </td>
		  <td class="table_data_blue"> users </td>
          <td class="table_data_blue"> Secretary </td>
		</tr>
      </table>
    </td>
  </tr>
</table>
<font class="table_data_red">* Verplicht veld</font>
<hr>
<input type="submit" name="action" value="<?php echo $this->_tpl_vars['users_value']; ?>
">
</form>
</body>
</HTML>