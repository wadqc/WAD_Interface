<table class="table_selectorbar">
<tr bgcolor="#B8E7FF">
  <td>&nbsp;
    Periode&nbsp;
    <select name="date_filter" onchange="processor_status_drop_list(date_filter.value,status.value,selector.value)" id="date_filter">{html_options options=$date_options selected=$date_select}</select>
  &nbsp;</td>
  <td>&nbsp;
    Status&nbsp;
    <select name="status" onchange="processor_status_drop_list(date_filter.value,status.value,selector.value)" id="status"> {html_options options=$status_options selected=$status_id} </select></td>
<td>&nbsp;
    Selector&nbsp;
    <select name="selector" onchange="processor_status_drop_list(date_filter.value,status.value,selector.value)" id="selector"> {html_options options=$selector_options selected=$selector_id} </select></td>
  <!-- <td><input type="submit" name="action_result" value="Query"></td> --> 
</tr>
</table>

