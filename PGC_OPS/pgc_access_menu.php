<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_access_save_appname.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
require_once('pgc_access_app_check.php');
/* END - PAGE ACCESS CHECKING LOGIC - END */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC APP ACCESS MENU</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
body {
	background-color: #283664;
	background-image: url(../images/Buttons/PGC%20copy.png);
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style16 {color: #CCCCCC; }
a:link {
	color: #CCCCCC;
}
a:visited {
	color: #FFFFFF;
}
.style17 {
	color: #CCCCCC;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
.style57 {color: #FFFFFF; font-weight: bold; }
.style58 {
	font-size: 16px;
	color: #CCCCCC;
}
.MenuText
{
	font-size: 15px;
	font-weight: bold;
	color: #FFF;
}
-->
</style>
</head>
<body>
<table width="900" height="38%" align="center"  cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
      <tr>
        <td height="38" align="center" valign="middle"><div align="center"><span class="style1"> PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="350" valign="top"><table width="95%" height="95%" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#414967">
                <tr>
                    <td width="1562" height="26" valign="middle" class="style57"><div align="center" class="style57 style58">
                        <p class="MenuText">APPLICATION ACCESS CONTROL SYSTEM</p>
</div></td>
                </tr>
                <tr>
                    <td align="center" valign="middle"><table width="74%" cellspacing="3" cellpadding="3">
                          <tr>
                                <td align="center" bgcolor="#173A75"><a href="pgc_access_application_list.php" class="MenuText" >APP LIST PLUS LAST ACTIVITY</span></a></td>
                                <td align="center" bgcolor="#173A75"><a href="pgc_access_grouplist.php" class="MenuText">ADD GROUP LIST ITEM </a></td>
                          </tr>
                          <tr>
                                <td align="center" bgcolor="#173A75"><a href="pgc_access_app_groups.php" class="MenuText">ADD GROUPS TO APP</a></td>
                                <td align="center" bgcolor="#173A75"><a href="pgc_access_app_group_list.php" class="MenuText">APPLICATION ASSIGNED GROUPS </a></td>
                          </tr>
                          <tr>
                                <td align="center" bgcolor="#173A75"><a href="pgc_access_app_member.php" class="MenuText">ADD MEMBERS TO GROUPS </a></td>
                                <td align="center" bgcolor="#173A75"><a href="pgc_access_member_group_list.php" class="MenuText">MEMBER ASSIGNED GROUPS </a></td>
                          </tr>
                          <tr>
                                <td height="21" align="center" bgcolor="#173A75">&nbsp;</td>
                                <td align="center" bgcolor="#173A75"><a href="pgc_list_member_role.php" class="MenuText">EDIT  ADMIN ROLE (LEGACY)</a></td>
                          </tr>
                    </table></td>
                </tr>
                <tr>
                    <td height="24" class="style16"><div align="center"><a href="pgc_portal_menu.php" class="style17">BACK TO MAINTENANCE MENU </a></div></td>
                </tr>
            </table></td>
      </tr>
</table>
</body>
</html>