<table bgcolor="#6767ff">
<tr>
  <td bgcolor="#F3F6FF" class="template_data"> Periode: </td>
  <td bgcolor="#F3F6FF" class="template_data"> <select name="date_filter" onchange="processor_status_drop_list(date_filter.value,status.value)" id="date_filter">{html_options options=$date_options selected=$date_select} </select></td>
  <td bgcolor="#F3F6FF" class="template_data"> Status: </td>
  <td bgcolor="#F3F6FF" class="template_data"> <select name="status" onchange="processor_status_drop_list(date_filter.value,status.value)" id="status"> {html_options options=$status_options selected=$status_id} </select></td>
  <td class="template_data"> <!-- <input type="submit" name="action_result" value="Query"> --> </td>
</tr>
</table>

