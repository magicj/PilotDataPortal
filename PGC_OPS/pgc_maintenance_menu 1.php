<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC INVENTORY - EDIT ITEM</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
body {
	background-color: #333333;
}
.style1 {
	font-size: 18px;
	font-weight: bold;
	color: #999999;
}
.style16 {color: #CCCCCC; }
a:link {
	color: #CCCCCC;
}
a:visited {
	color: #CCCCCC;
}
.style17 {
	color: #CCCCCC;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
.style42 {
	font-size: 16px;
	font-weight: bold;
	font-style: italic;
	color: #E2E2E2;
}
.style54 {
	font-size: 14px;
	font-weight: bold;
	color: #FF6600;
}
.style58 {color: #FFFFFF; }
.style60 {color: #999999; font-size: 18px; font-weight: bold; font-style: italic; }
.style61 {color: #EEEEEE; }
-->
</style>
</head>
<body>
<table width="1200" height="95%" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="521" bgcolor="#666666"><table width="95%" height="95%" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#003648">
                        <tr>
                          <td width="1562" height="26" valign="middle" bgcolor="#005B5B"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="35%">&nbsp;</td>
                              <td width="30%"><div align="center"><span class="style42">PGC EQUIPMENT  MAINTENANCE MENU </span></div></td>
                              <td width="35%"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="52%" class="style54"><div align="center"></div></td>
                                  <td width="5%">&nbsp;</td>
                                  <td width="43%">&nbsp;</td>
                                </tr>
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="464" align="center" valign="top" bgcolor="#005B5B"><p>&nbsp;</p>
                            <p class="style60">&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <table width="502" border="0" cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                                                      <tr>
                                                              <td bgcolor="#392B73" class="style17"><div align="center">REPORTS</div></td>
                                                              <td bgcolor="#392B73" class="style17"><div align="center">MAINTENANCE CONTROL </div></td>
                                                      </tr>
                                                      <tr>
                                                              <td bgcolor="#48597B" class="style17"><div align="center" class="style61"><a href="pgc_work_view.php">EQUIPMENT WORK HISTORY </a></div></td>
                                                              <td bgcolor="#48597B" class="style17"><div align="center" class="style61"><a href="pgc_squawk_view.php">SQUAWK WORK</a></div></td>
                                                      </tr>
                                                      <tr>
                                                        <td width="238" bgcolor="#48597B" class="style17"><div align="center" class="style58"><a href="pgc_squawk_view.php"><span class="style16"><span class="style61"></span></span></a><a href="pgc_stock_used_view.php">STOCK USED HISTORY </a></div></td>
                                                        <td width="239" bgcolor="#48597B" class="style17"><div align="center" class="style61"><a href="pgc_inventory_list.php">HARDWARE INVENTORY LIST </a> </div></td>
                                                      </tr>
                                                    </table>
                                                    <p>&nbsp;</p></td>
                        </tr>
                        <tr>
                          <td height="24" bgcolor="#005B5B" class="style16"><div align="center"><a href="../07_members_only_pw.php" class="style17">BACK TO MEMBER'S PAGE </a></div></td>
                        </tr>
        </table></td>
      </tr>
</table>
</body>
</html>
