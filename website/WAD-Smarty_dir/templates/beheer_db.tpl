<!-- source template: beheer_db.tpl -->
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Beheer DB</title>
  <link rel="StyleSheet" href="./css/styles.css" type="text/css">
  <link rel="stylesheet" type="text/css" media="all" href="./java/js/tablekit/css/style.css"/>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
  <script type="text/javascript" language="JavaScript" src="./java/scripts.js"></script> 
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js"></script>
  <script type="text/javascript" src="./java/js/tablekit/fabtabulous.js"></script>
  <script type="text/javascript" src="./java/js/tablekit/tablekit.js"></script>


</head>
<body bgcolor="#F3F6FF">

<div data-alert class="alert-box alert">
    Waarschuwing: wees voorzichtig met handelingen op deze pagina!
</div>

<h1 class="table_data_blue" >{$header} </h1>

<form action="{$form_action}" method="POST">

{$action_list}

<br/>

{if isset($action_name)}
<table class="table_selectorbar">
<tr bgcolor="#B8E7FF">
  <td>&nbsp;&nbsp;{$action_text}
    &nbsp;&nbsp;<select name="confirm_action"><option value="{$action_name}">{$action_name}</option></select>
    &nbsp;&nbsp;<input type="submit" value="Go!">
  </td>
</tr>
</table>
<br/>
{/if}

{if isset($action_result)}
{$action_result}
<br/>
<br/>
{/if}

{if isset($toggle)}
<input type="checkbox" onClick="toggle_checkboxes(this)"/>Toggle All<br/>
<br/>
{/if}

{if isset($table_list)}
<table NOSAVE="true" class="table_general sortable">
  {$table_list}
</table>
{/if}

</form>

</body>
</html>
