<script language="javascript" type="text/javascript">
var reloading;

function checkReloading() {
    if (window.location.hash=="#noautoreload") {
        clearTimeout(reloading);
        document.getElementById("refresh").checked=false;
    } else {
        reloading=setTimeout("window.location.reload();", 5000);
        document.getElementById("refresh").checked=true;
    }
}

function toggleAutoRefresh(cb) {
    if (cb.checked) {
        window.location.replace("#");
        reloading=setTimeout("window.location.reload();", 5000);
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
    Periode&nbsp;
    <select name="date_filter" onchange="processor_status_drop_list(date_filter.value,status.value)" id="date_filter">{html_options options=$date_options selected=$date_select}</select>
  &nbsp;</td>
  <td>&nbsp;
    Status&nbsp;
    <select name="status" onchange="processor_status_drop_list(date_filter.value,status.value)" id="status"> {html_options options=$status_options selected=$status_id} </select></td>
  <!-- <td><input type="submit" name="action_result" value="Query"></td> --> 
  <td>&nbsp;
    Automatisch verversen&nbsp;<input type="checkbox" id="refresh" onclick="toggleAutoRefresh(this);">
</tr>
</table>

