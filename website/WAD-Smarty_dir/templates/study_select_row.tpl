<!-- source template: study_select_row.tpl -->
<tr bgcolor="{$bgcolor}">
  <td>
    <input type="checkbox" name="{$checkbox_name}" class="checkbox" value="on">
  </td>
  <td>
     <a href="{$action}" class="table_data_select">{$patient_id}</a>
  </td>
  {* <td class="table_data">
    {$patient_id}
  </td> *}
  <td class="table_data">
    {$study_description}
  </td>
  <td class="table_data">
    {$study_datetime}
  </td>
  <td class="table_data">
    {$accession_number}
  </td>
  <td class="table_data">
    {$status}
  </td>  
</tr>
