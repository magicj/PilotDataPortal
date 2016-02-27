<?php require_once('../Connections/PGC.php'); ?>
<?php
//error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
$session_pilotname = $_SESSION['MM_PilotName'];
$session_email = $_SESSION['MM_Username']; 
$session_duty_role = $_SESSION['MM_duty_role'];
require_once('pgc_check_login.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal</title>
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
}
.style16 {
	color: #FFFFFF;
	font-size: 16px;
}
a:link {
	color: #E6E3DF;
}
a:visited {
	color: #E6E3DF;
}
a:active {
	color: #FFFFCC;
}
.style19 {color: #CCCCCC; font-style: italic; font-weight: bold; }
.style20 {	font-size: 16px;
	font-weight: bold;
	color: #FFCCCC;
}
.style24 {font-size: 16px; font-weight: bold; color: #CCCCCC; }
.style28 {font-size: 12px}
.style23 {font-size: 16px; font-weight: bold; color: #FFCCCC; font-style: italic; }
.style44 {color: #999999;
	font-weight: bold;
}
.style32 {font-weight: bold; color: #000000; }
.style43 {font-size: 16px; }
#form1 table tr .style20
{
	color: #FFF;
}
.style32 .style43 p
{
	color: #FFF;
}
-->
</style></head>

<body>
<p>&nbsp;</p>
<table width="800" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td width="1002"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="190" bgcolor="#3E3E5E"><table width="99%" height="186" border="0" align="center" cellpadding="5" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="25"><div align="center">
            <table width="99%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                      <td bgcolor="#333366"><div align="center"><span class="style24">FIELD DUTY - SELECT SESSION DUTY DAY</span></div></td>
                </tr>
                </table>
            </div></td>
      </tr>
      
      <tr>
        <td height="108" align="center" valign="top"><p>&nbsp;</p>
              <table width="600" border="1" align="center" cellpadding="2" cellspacing="2" bgcolor="#6666FF">
                    <tr>
                          <td width="214" height="30" align="center" valign="middle" bgcolor="#6666FF" class="style32"><div align="center" class="style43"><?php echo $_SESSION['MM_PilotName']; ?></div></td>
                          <td width="50" align="center" valign="middle" bgcolor="#6666FF" class="style32"><span class="style43"><?php echo $_SESSION['MM_duty_role']; ?></span>&nbsp;</td>
                          <td width="214" align="center" valign="middle" bgcolor="#6666FF" class="style32"><div align="center" class="style43"><?php echo $_SESSION['MM_Username']; ?></div></td>
                    </tr>
              </table>
              <table width="600" border="1" align="center" cellpadding="2" cellspacing="2" bgcolor="#6666FF">
                    <tr>
                          <td width="381" height="163" valign="middle" bgcolor="#6666FF" class="style32"><div align="center" class="style43">
                                <p>&nbsp;</p>
                                <p>You are not a designated Field Manager or Assistant Field Manager for this session. Contact the the PGC Duty Manager for more information.</p>
                                <form id="form1" name="form1" method="post" action="../07_members_only_pw.php">
                                      <input type="submit" name="Submit " id="Submit " value="Return to Member's Page" />
                                </form>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                          </div></td>
                    </tr>
              </table>
              <p class="style16">&nbsp;</p>
              <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td height="33"><div align="center" class="style20"></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

