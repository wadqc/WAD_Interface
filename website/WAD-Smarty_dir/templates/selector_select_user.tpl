<!-- source template: selector_select.tpl -->
<table class="table_selectorbar">
<tr bgcolor="#B8E7FF">
  <td>&nbsp;
    Datum&nbsp;
    <select name="gewenste_processen_id" onchange="selector_drop_list(gewenste_processen_id.value,niveau.value,status.value,'{$selector_fk}','{$analyse_level}','{$v}')" id="gewenste_processen_id"> >{html_options options=$processen_options selected=$processen_id} </select>
  &nbsp;</td>
  <td>&nbsp;
    Niveau&nbsp;
    <select name="niveau" onchange="selector_drop_list(gewenste_processen_id.value,niveau.value,status.value,'{$selector_fk}','{$analyse_level}','{$v}')" id="niveau"> {html_options options=$niveau_options selected=$niveau_id} </select>
  &nbsp;</td>
  <td>&nbsp;
    Status&nbsp;
    <select name="status" onchange="selector_drop_list(gewenste_processen_id.value,niveau.value,status.value,'{$selector_fk}','{$analyse_level}','{$v}')" id="status"> {html_options options=$status_options selected=$status_id} </select>
  &nbsp;</td>

  {$notitie}    
  {$row_line}

</tr>
{$menu_line}

</table>

