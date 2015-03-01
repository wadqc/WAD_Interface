<!-- source template: beheer_db_action1_row.tpl -->
<tr bgcolor="{$bgcolor}">
  <td>
    <input type="checkbox" name="{$checkbox_name}" class="checkbox" value="on">
  </td>
  <td class="table_data">
   <a href="{$action_selector}" class="table_data_select">{$selector}</a> 
  </td>
  <td class="table_data">
    {$description}
  </td>
  <td class="table_data">
    {$nr_gewenste_processen}
  </td>
  <td class="table_data">
    {$nr_results_floating}
  </td>
  <td class="table_data">
    {$nr_results_char}
  </td>
  <td class="table_data">
    {$nr_results_object}
  </td>
  <td class="table_data">
    {$nr_results_boolean}
  </td>
</tr>
