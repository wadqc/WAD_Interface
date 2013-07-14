<table bgcolor="#6767ff">
<tr>
  <td bgcolor="#F3F6FF" class="template_data"> Selecteer resultaat</td>
  <td bgcolor="#F3F6FF" class="template_data"> <select name="gewenste_processen_id" onchange="selector_drop_list(gewenste_processen_id.value,niveau.value,status.value,'{$selector_fk}','{$analyse_level}','{$v}')" id="gewenste_processen_id"> >{html_options options=$processen_options selected=$processen_id} </select></td>
  <td bgcolor="#F3F6FF" class="template_data"> Niveau</td>
  <td bgcolor="#F3F6FF" class="template_data"> <select name="niveau" onchange="selector_drop_list(gewenste_processen_id.value,niveau.value,status.value,'{$selector_fk}','{$analyse_level}','{$v}')" id="niveau"> {html_options options=$niveau_options selected=$niveau_id} </select></td>
  <td bgcolor="#F3F6FF" class="template_data"> Status</td>
  <td bgcolor="#F3F6FF" class="template_data"> <select name="status" onchange="selector_drop_list(gewenste_processen_id.value,niveau.value,status.value,'{$selector_fk}','{$analyse_level}','{$v}')" id="status"> {html_options options=$status_options selected=$status_id} </select></td>


  <td class="template_data"> <input type="submit" name="action_result" value="{$select_value}"> </td>
  {$row_line}

</tr>
{$menu_line}

</table>

