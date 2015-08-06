<!-- source template: file_select_row.tpl -->
<tr bgcolor="{$bgcolor}">
  <td>
    <input type="checkbox" name="{$checkbox_name}" value="on">
  </td>
  <td class="table_data">
    {$description}
  </td>
  <td>
     <a href="{$action_update}" class="table_data_select">{$filename}</a>
  </td>
{if isset($action_show)}
  <td>
     <a href="{$action_show}" class="table_data_select">config weergeven</a>
  </td>
{/if}
</tr>
