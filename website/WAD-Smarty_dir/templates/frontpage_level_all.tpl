<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>Image Qualtity Control</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff">


<table cellspacing="0" cellpadding="0" align="left">
  <tr>
    <td>
      <table cellspacing="4" cellpadding="0" align="left">
        <tr>
          <td> <a href="{$application_link}" name="about" type="image/jpeg" target="_blank"><img src="{$application_picture}"  border="0"></a> </td>
          <td valign="top">
            <table align="left">
              <tr>
                <td nowrap>
				  <font class="table_data_red">{$user}</font>
				</td>
                <td>
			      <a href="logout.php" class="table_data_select" type="text/html" target="_parent" class="href_table_data">Logout</A>
				</td>
              </tr>
            </table>
          </td>
      	  <td><font class="normal_data">{$version}</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table>
        <tr>
          {$top_row}
		</tr>
	  </table>
	  <table>
        <tr>
          {$bottom_row}
		</tr>
	  </table>
	</td>
  </tr>
</table>

</body>
</html>

