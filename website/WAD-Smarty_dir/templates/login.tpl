<!-- source template: login.tpl -->
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="../iqc/css/styles.css" type="text/css">
  <title>WAD-QC</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
  <link rel="shortcut icon" href="{$favicon}">
  <script language="JavaScript" type="text/javascript">
     function breakout_of_frame()
     {
       if (top.location != location) {
         top.location.href = document.location.href ;
       }
     }
   </script>
</head>
<body onLoad="javascript:breakout_of_frame(); document.first.user_name.focus();" bgcolor="#F3F6FF">
<img src="{$login_picure_src}" border="0">

<form name="first" action="{$login_action}" method="POST">

<table>
<tr>
  <td class="template_data"> {$message}</td>
</tr>

<tr>
  <td class="template_data"> Gebruikersnaam</td>
  <td class="template_data"> <input type="text" name="user_name" value="{$default_login}" size="16" maxlength="20"></td>
</tr>
<tr>
  <td class="template_data"> Wachtwoord</td>
  <td class="template_data"><input type="password" name="user_password" size=16 maxlength=20></td>
</tr>

<tr>
  <td class="template_data"> <input type="submit" value="{$login_submit}"> </td>
  <td></td>
</tr>

<tr>
  <td class="table_data"><br><br><a href="{$application_link}" name="about" target="_blank">About WAD-QC</a></td>
</tr>
</table>

</form>
