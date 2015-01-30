<!-- source template: study_view.tpl -->
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>IQC</title>
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <link rel="stylesheet" type="text/css" media="all" href="./java/js/tablekit/css/style.css"/>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
  <script type="text/javascript" language="JavaScript" src="./java/scripts.js"></script> 
  <!-- tbv tablekit (sorteerbare tabellen); zet refresh uit bij aanpassing sortering -->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js"></script>
  <script type="text/javascript" src="./java/js/tablekit/fabtabulous.js"></script>
  <script type="text/javascript" src="./java/js/tablekit/tablekit.js"></script>
  <script language="javascript" type="text/javascript">
        function disable_refresh_on_column_sort() {
                var anchors = document.getElementsByClassName('table_data_header_bold');
                for(var i = 0; i < anchors.length; i++) {
                    var anchor = anchors[i];
                    anchor.onclick = function() {
                        document.getElementById("refresh").checked=false;
                        window.location.replace("#noautoreload");
                        clearTimeout(reloading);
                    }
                }
        }
  </script>

</head>
<body bgcolor="#F3F6FF">
<form action="{$form_action}" method="POST">
<br>
<br>

{$selection_list}

<br>
<br>
<table NOSAVE="true" class="table_general sortable">
  {$study_list}
</table>

<script>disable_refresh_on_column_sort();</script>

</form>
</html>
