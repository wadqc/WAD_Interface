<!-- source template: selector_select_row.tpl -->
<tr bgcolor="{$bgcolor}">
  <td class="table_data">
   <a href="{$action_selector}" class="table_data_select">{$selector}</a> 
  </td>
  <td class="table_data">
    {$description}
  </td>
  <td class="table_data">
    {$datetime}
  </td>
  <td align="center" class="table_data">
    <img src="status_icons/{$status_img}" height="14" alt="{$status_txt}">
  </td>
  <td align="center" class="{$waarde_class}">
    {$qc_frequency}
  </td>
  <td class="table_data">
    {$category}
  </td>
  <td class="table_data">
    {$modality}
  </td>
  <td class="table_data">
    {$location}
  </td>
</tr>
