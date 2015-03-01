<!-- source template: beheer_db_dropdown.tpl -->

<table class="table_selectorbar">
<tr bgcolor="#B8E7FF">
  <td>&nbsp;
    DB actie&nbsp;
    <select name="db_action" onchange="beheer_db_drop_list(db_action.value)" id="db_action">{html_options options=$db_action_options selected=$db_action_select}</select>
  &nbsp;</td>
</tr>
</table>

