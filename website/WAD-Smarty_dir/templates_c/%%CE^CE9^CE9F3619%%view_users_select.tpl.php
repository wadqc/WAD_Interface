<?php /* Smarty version 2.6.7, created on 2012-10-07 15:39:18
         compiled from view_users_select.tpl */ ?>
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

<form action="<?php echo $this->_tpl_vars['action_new_teacher']; ?>
" method="POST" >
<hr>
<font class="table_data_blue_header">User </font>
<table>
       
        <tr>
         <td class="table_data_blue"> Voornaam  </td>
         <td class="table_data"> <?php echo $this->_tpl_vars['default_users_firstname']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Initialen </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['default_users_initials']; ?>
  </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Achternaam </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['default_users_lastname']; ?>
  </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Telefoon </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['default_users_phone']; ?>
 </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Email </td>
          <td class="table_data"> <?php echo $this->_tpl_vars['default_users_email']; ?>
 </td>
        </tr>
</table>

<hr>

<font class="table_data_blue_header">Priveleges</font>
<table>
  <tr>
    <td class="table_data_blue"> Login </td>
    <td class="table_data"> <?php echo $this->_tpl_vars['default_users_login']; ?>
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
          <td class="table_data"> users </td>
          <td class="table_data"> Secretary </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<hr>
<hr>
<table>
  <tr>
    <td><a HREF="<?php echo $this->_tpl_vars['action_modify']; ?>
" class="table_data_select"><?php echo $this->_tpl_vars['content_modify']; ?>
</a><?php echo $this->_tpl_vars['separator']; ?>
<a HREF="<?php echo $this->_tpl_vars['action_delete']; ?>
" class="table_data_select"><?php echo $this->_tpl_vars['content_delete']; ?>
</a>  </td>
  </tr>
</table>
<hr>



</form>
</body>
</HTML>

