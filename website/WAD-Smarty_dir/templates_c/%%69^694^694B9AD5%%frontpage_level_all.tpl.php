<?php /* Smarty version 2.6.7, created on 2012-05-25 13:11:29
         compiled from frontpage_level_all.tpl */ ?>
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
          <td> <a href="about.html" name="about" type="image/jpeg" target="_blank"><img src="<?php echo $this->_tpl_vars['application_picture']; ?>
"  border="0"></a> </td>
          <td valign="top">
            <table align="left">
              <tr>
                <td nowrap>
				  <font class="table_data_red"><?php echo $this->_tpl_vars['user']; ?>
</font>
				</td>
                <td>
			      <a href="logout.php" class="table_data_select" type="text/html" target="_parent" class="href_table_data">Logout</A>
				</td>
              </tr>
            </table>
          </td>
      	  <td><font class="normal_data"><?php echo $this->_tpl_vars['version']; ?>
</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table>
        <tr>
          <?php echo $this->_tpl_vars['top_row']; ?>

		</tr>
	  </table>
	  <table>
        <tr>
          <?php echo $this->_tpl_vars['bottom_row']; ?>

		</tr>
	  </table>
	</td>
  </tr>
</table>

</body>
</html>
