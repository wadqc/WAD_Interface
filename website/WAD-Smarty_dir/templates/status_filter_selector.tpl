<table class="table_selectorbar">
<tr bgcolor="#B8E7FF">
  <td>&nbsp;
    Periode&nbsp;
    <select name="date_filter" onchange="selector_status_drop_list(date_filter.value,status.value,'{$querystring}')" id="date_filter">{html_options options=$date_options selected=$date_select}</select>
  &nbsp;</td>
  <td>&nbsp;
    Status&nbsp;
    <select name="status" onchange="selector_status_drop_list(date_filter.value,status.value,'{$querystring}')" id="status"> {html_options options=$status_options selected=$status_id} </select></td>
  <!-- <td><input type="submit" name="action_result" value="Query"></td> --> 
</tr>
</table>

