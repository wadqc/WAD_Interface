<!-- source template: new_selector.tpl -->
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>New Selector</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<form action="{$action_new_selector}" method="POST" >

<font class="table_data_blue_header">{$title}</font>
<hr>
<table>
  <tr>
    <td class="table_data_blue"> Name </td>
    <td class="table_data">
      <input   name="selector_name" type="text" value="{$default_selector_name}" size="50"> </input>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Description</td>
    <td class="table_data">
      <textarea name="selector_description" cols="50" rows="5">{$default_selector_description}</textarea>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Analyse Level </td>
    <td class="table_data">
         <select name="selector_analyselevel">
           {html_options options=$analyselevel_options selected=$analyselevel_id}
         </select>
    </td>
  </tr>

</table>
     
<hr>
<font class="table_data_blue_header">Selector files</font>
<table> 
  <tr>
    <td class="table_data_blue"> Analysemodule </td>
    <td class="table_data">
         <select name="analysemodule_pk">
           {html_options options=$analysemodule_options selected=$analysemodule_id}
         </select>
    </td>
  </tr>
  <tr>
    <td class="table_data_blue"> Analysemodule config </td>
    <td class="table_data">
         <select name="analysemodule_cfg_pk">
           {html_options options=$analysemodule_cfg_options selected=$analysemodule_cfg_id}
         </select>
    </td>
  </tr>
</table>
<hr>
<input type="submit" name="action" value="{$submit_value}">
<hr>
<font class="table_data_blue_header">Constraints</font>
{$table_buttons}
{$table_pssi}

</form>
</body>
</HTML>


