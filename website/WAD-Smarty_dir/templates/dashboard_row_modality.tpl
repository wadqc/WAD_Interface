<!-- source template: dashboard_row_modality.tpl -->
<tr bgcolor="{$bgcolor}">
  <td class="table_data">
   <a href="{$action_modality}" class="table_data_select">{$modality}</a> 
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
</tr>
