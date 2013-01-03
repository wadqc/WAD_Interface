<table bgcolor="#6767ff">
<tr>
  <td bgcolor="#F3F6FF" class="template_data"> Selecteer resultaat</td>
  <td bgcolor="#F3F6FF" class="template_data"> <select name="gewenste_processen_id" >{html_options options=$processen_options selected=$processen_id} </select></td>
  <td bgcolor="#F3F6FF" class="template_data"> Niveau</td>
  <td bgcolor="#F3F6FF" class="template_data"> <select name="niveau" >{html_options options=$niveau_options selected=$niveau_id} </select></td>
  <td class="template_data"> <input type="submit" name="action_result" value="Query"> </td>
</tr>
</table>

