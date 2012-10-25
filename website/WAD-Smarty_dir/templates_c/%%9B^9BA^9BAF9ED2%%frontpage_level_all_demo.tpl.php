<?php /* Smarty version 2.6.7, created on 2006-02-14 18:10:13
         compiled from frontpage_level_all_demo.tpl */ ?>
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>Kwadraat</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff">


<table cellspacing="0" cellpadding="0" align="left">
  <tr>
    <td>
      <table cellspacing="4" cellpadding="0" align="left">
        <tr>
          <td> <img src="<?php echo $this->_tpl_vars['school_picture']; ?>
" align="left" border="0"> </td>
          <td>
            <table align="left">
              <tr>
                <td>
				  <font class="table_data_red"><?php echo $this->_tpl_vars['user']; ?>
</font>
				</td>
                <td>
			      <a href="logout_demo.php" class="table_data_select" type="text/html" target="_parent" class="href_table_data">Logout</A>
				</td>
              </tr>
		   </table>
          </td>
		  <td> <a href="about.html" name="about" type="image/jpeg" target="_blank"><img src="<?php echo $this->_tpl_vars['application_picture']; ?>
"  border="0"></a> </td>
		  <td><font class="normal_data">BETA release</td>
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
