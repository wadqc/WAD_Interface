<!-- source template: category_new.tpl -->
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>{$title}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<h1 class="table_data_blue" >{$header}</h1>

<form enctype="multipart/form-data" action="{$action_new_category}" method="POST" >
<table>
  <tr>
    <td class="table_data_blue"> omschrijving</td>
    <td class="table_data">
         <input   name="description" type="text" value="{$default_description}" size="30"> </input>
    </td>
  </tr>
</table>
<input type="submit" name="action" value="{$submit_value}">


</form>
</body>
</HTML>



