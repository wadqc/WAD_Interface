<!-- source template: users_select_row.tpl -->
<tr bgcolor="{$bgcolor}">
  <td>
    <input type="checkbox" name="{$checkbox_name}" value="on">
  </td>
  <td class="table_data">
    {$login}
  </td>
  <td class="table_data">
    {$firstname}
  </td>
  <td>
     <a href="{$action}" class="table_data_select">{$lastname}</a>
  </td>
  <td class="table_data">
    {$initials}
  </td>
  <td class="table_data">
    {$phone}
  </td>
  <td class="table_data">
    {$email}
  </td>
  <td class="table_data">
    {$prefmodality}
  </td>
</tr>
