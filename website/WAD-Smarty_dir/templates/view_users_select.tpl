<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>WAD-QC</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<form action="{$action_new_teacher}" method="POST" >
<hr>
<font class="table_data_blue_header">User </font>
<table>
       
        <tr>
         <td class="table_data_blue"> First Name  </td>
         <td class="table_data"> {$default_users_firstname} </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Initials </td>
          <td class="table_data"> {$default_users_initials}  </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Last Name </td>
          <td class="table_data"> {$default_users_lastname}  </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Phone </td>
          <td class="table_data"> {$default_users_phone} </td>
        </tr>
        <tr>
          <td class="table_data_blue"> Email </td>
          <td class="table_data"> {$default_users_email} </td>
        </tr>
</table>

<hr>

<font class="table_data_blue_header">Priveleges</font>
<table>
  <tr>
    <td class="table_data_blue"> Login </td>
    <td class="table_data"> {$default_users_login} </td>
  </tr>
  <tr>
    <td colspan="2">
      <table>
        <tr>
          <td class="table_data"> <input type="radio" {$checked_login_level_1}> </td>
          <td class="table_data"> <input type="radio" {$checked_login_level_2}> </td>
          <td class="table_data"> <input type="radio" {$checked_login_level_3}> </td>
        </tr>
        <tr>
          <td class="table_data"> Admin </td>
          <td class="table_data"> Technician </td>
          <td class="table_data"> Vendor </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<hr>
<hr>
<table>
  <tr>
    <td><a HREF="{$action_modify}" class="table_data_select">{$content_modify}</a>{$separator}<a HREF="{$action_delete}" class="table_data_select">{$content_delete}</a>  </td>
  </tr>
</table>
<hr>



</form>
</body>
</HTML>


