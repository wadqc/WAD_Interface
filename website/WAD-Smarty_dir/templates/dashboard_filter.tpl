<!-- source template: dashboard_filter.tpl -->
<script language="javascript" type="text/javascript">
var reloading;

function checkReloading() {
    if (window.location.hash=="#noautoreload") {
        clearTimeout(reloading);
        document.getElementById("refresh").checked=false;
    } else {
        reloading=setTimeout("window.location.reload();", 30000);
        document.getElementById("refresh").checked=true;
    }
}

function toggleAutoRefresh(cb) {
    if (cb.checked) {
        window.location.replace("#");
        reloading=setTimeout("window.location.reload();", 30000);
    } else {
        window.location.replace("#noautoreload");
        clearTimeout(reloading);
    }
}

window.onload=checkReloading;
</script>

<table class="table_selectorbar">
<tr bgcolor="#B8E7FF">
  <td>&nbsp;
    Groepeer op: &nbsp;
    <select name="group_filter" onchange="dashboard_drop_list(group_filter.value,'{$querystring}')" id="group_filter">{html_options options=$group_options selected=$group_select}</select>
  &nbsp;</td>
  <td>&nbsp;
    Automatisch verversen&nbsp;<input type="checkbox" id="refresh" onclick="toggleAutoRefresh(this);">
</tr>
</table>

