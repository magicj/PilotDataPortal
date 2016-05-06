<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

//	echo $_SESSION['MM_PilotRole'];
// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}
$MM_restrictGoTo = "../Index.html";
if (substr($_SESSION['MM_PilotRole'],0,5) <> 'ADMIN' ) {
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
 
   header("Location: ". $MM_restrictGoTo); 
  exit;
 } 
 
$MM_restrictGoTo = "../Index.html";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
   
  header("Location: ". $MM_restrictGoTo); 
  exit;
 } 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Main Menu</title>
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
	color: #FFFFFF;
}
.style11 {
	font-size: 16px;
	font-weight: bold;
	color: #FFFFFF;
}
.style13 {font-size: 14px; font-weight: bold; }
a:link {
	color: #CCCCCC;
}
a:visited {
	color: #FFFFFF;
	font-size: 18px;
	font-weight: bold;
	text-align: center;
}
.style17 {font-size: 14px; font-weight: bold; color: #6699FF; }
.style18 {color: #6699FF}
.style16 {color: #CCCCCC; }
.PortalMenu
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #FFF;
	background-color: #0057AE;
	text-align: center;
	border: 1px solid #06F;
	padding: 1px;
}
.PortalMenuText
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 15px;
	font-weight: bold;
	color: #FFF;
	text-align: center;
	font-variant: normal;
	text-transform: uppercase;
}
-->
</style></head>

<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#555555">
  <tr>
        <td height="573" valign="top" bgcolor="#666666"><table width="96%" height="567" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#414967">
              <tr>
                    <td height="51" bgcolor="#003853"><div align="center"><span class="style11"><span class="style1"><span class="style11">PGC PILOT DATA PORTAL</span></span><span class="style11"> - MAINTENANCE MENU</span></span></div></td>
                    </tr>
              <tr>
                    <td height="508" align="center" valign="top" bgcolor="#4F5359"><div align="center">
                          <table width="92%" cellpadding="2" cellspacing="2">
                                <tr>
                                      <td align="center">&nbsp;</td>
                                      <td align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                      <td width="339" align="center" bgcolor="#004080"><a href="../PGC_OPS/pgc_list_signoffs_select.php" class="style17"><span class="PortalMenuText">LIST/MODIFY PILOT SIGNOFFS</span></a></td>
                                      <td width="337" align="center" bgcolor="#004080"><a href="../PGC_OPS/pgc_list_pilot_rating_select.php" class="PortalMenuText"><span class="PortalMenuText">LIST/MODIFY PILOT RATING</span></a></td>
                                      </tr>
                                <tr>
                                      <td align="center" bgcolor="#004080"><a href="../PGC_OPS/pgc_enter_pilot_signoff.php" class="PortalMenuText"><span class="PortalMenuText">ADD PILOT SIGNOFF - SINGLE</span></a></td>
                                      <td align="center" bgcolor="#004080"><a href="../PGC_OPS/pgc_add_pilot_rating.php" class="PortalMenuText"><span class="PortalMenuText">ADD PILOT RATING - SINGLE</span></a></td>
                                      </tr>
                                <tr>
                                      <td height="25" align="center">&nbsp;</td>
                                      <td align="center">&nbsp;</td>
                                </tr>
                                </table>
                          <table width="92%" cellpadding="2" cellspacing="2">
                                <tr bgcolor="#004242" class="PortalMenuText">
                                      <td width="50%" bgcolor="#004080"><div align="center"><a href="../PGC_OPS/pgc_list_signoffs_nofly.php" class="style17"><span class="PortalMenuText">LIST EXPIRED - CRITICAL </span></a></div></td>
                                      <td width="50%" bgcolor="#004080" class="PortalMenuText"><div align="center"><a href="pgc_list_pilot_expired.php" class="style17"><span class="PortalMenuText">LIST EXPIRED - NOFLY</span></a></div></td>
                                      </tr>
                                <tr bgcolor="#004242" class="PortalMenuText">
                                      <td bgcolor="#004080"><div align="center"><a href="pgc_pilot_report-xls.php" class="style17"><span class="PortalMenuText">LIST  EXPIRED - NOFLY REPORT - XLS </span></a></div></td>
                                      <td bgcolor="#004080" class="PortalMenuText"><div align="center"> <a href="pgc_list_pilot_expired_rpt.php" class="style17"><span class="PortalMenuText">LIST EXPIRED - NOFLY REPORT</span></a></div></td>
                                      </tr>
                          </table>
                          <table width="92%" cellpadding="2" cellspacing="2">
                                <tr>
                                      <td height="25" align="center">&nbsp;</td>
                                      <td align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                      <td width="338" align="center" bgcolor="#004080"><a href="../PGC_OPS/pgc_list_pilot_rating.php" class="style17"><span class="PortalMenuText">LIST ALL PILOT RATINGS</span></a><span class="PortalMenuText"><a href="../PGC_OPS/pgc_list_signoffs_select.php" class="style17"></a></span></td>
                                      <td width="338" align="center" bgcolor="#004080"><a href="../PGC_OPS/pgc_list_pilot_rating_select.php" class="PortalMenuText"><span class="PortalMenuText">LIST/MODIFY PILOT RATING</span></a></td>
                                      </tr>
                                <tr>
                                      <td align="center" bgcolor="#004080"><a href="../PGC_OPS/pgc_list_signoffs_klaus.php" class="style17"><span class="PortalMenuText">MODIFY SIGNOFF STATUS - BY TYPE</span></a><span class="PortalMenuText"><a href="../PGC_OPS/pgc_enter_pilot_signoff.php" class="PortalMenuText"></a></span></td>
                                      <td align="center" bgcolor="#004080"><a href="../PGC_OPS/pgc_add_pilot_rating.php" class="PortalMenuText"><span class="PortalMenuText">ADD PILOT RATING - SINGLE</span></a></td>
                                      </tr>
                                <tr>
                                      <td height="25" align="center">&nbsp;</td>
                                      <td align="center">&nbsp;</td>
                                </tr>
                          </table>
                          <table width="92%" cellpadding="2" cellspacing="2">
                                <tr>
                                      <td width="338" align="center" bgcolor="#004080"><a href="pgc_enter_member_matt.php" class="PortalMenuText"><span class="PortalMenuText">ENTER NEW MEMBER </span></a></td>
                                      <td width="338" align="center" bgcolor="#004080" class="PortalMenuText"><a href="pgc_email_list_xls.php" class="PortalMenuText"><span class="PortalMenuText">ACTIVE E-MAIL ADDRESSES (XLS)</span></a></td>
                                      </tr>
                                <tr>
                                      <td align="center" bgcolor="#004080"><a href="pgc_list_member_status.php" class="PortalMenuText"><span class="PortalMenuText">SET MEMBER ACTIVE STATUS</span></a></td>
                                      <td align="center" bgcolor="#004080" class="PortalMenuText"><a href="pgc_flightlog_xls1.php" class="PortalMenuText"><span class="PortalMenuText">FLIGHT LOG REPORT (XLS)</span></a><span class="PortalMenuText"><a href="../PGC_OPS/pgc_add_pilot_rating.php" class="PortalMenuText"></a></span></td>
                                      </tr>
                                <tr>
                                      <td align="center" bgcolor="#004080"><a href="pgc_class_edit_list.php" class="PortalMenuText"><span class="PortalMenuText">ADD MEMBER ACHIEVEMENTS</span></a></td>
                                      <td align="center" bgcolor="#004080" class="PortalMenuText"><a href="pgc_maintenance_menu.php" class="PortalMenuText"><span class="PortalMenuText">EQUIPMENT MAINTENANCE</span></a></td>
                                      </tr>
                                <tr>
                                      <td height="25" align="center">&nbsp;</td>
                                      <td align="center" class="PortalMenuText">&nbsp;</td>
                                </tr>
                          </table>
                          <table width="92%" cellpadding="2" cellspacing="2">
                                <tr>
                                      <td width="338" align="center" bgcolor="#004080"><a href="pgc_field_duty_list_basic2.php" class="PortalMenuText"><span class="PortalMenuText">ENTER FM &amp; AFM DUTY DATES</span></a></td>
                                      <td width="338" align="center" bgcolor="#004080"><a href="pgc_field_duty_list_cfig.php" class="PortalMenuText"><span class="PortalMenuText">ENTER CFIG &amp; TOW PILOT  DUTY DATES</span></a></td>
                                      </tr>
                                <tr>
                                      <td align="center" bgcolor="#004080"><a href="pgc_field_duty_insert_dates.php" class="PortalMenuText"><span class="PortalMenuText">ADMIN - INSERT CALENDAR DATES</span></a></td>
                                      <td align="center" bgcolor="#004080"><a href="pgc_calendar_edit_list.php" class="PortalMenuText"><span class="PortalMenuText">UPDATE PGC MAIN PAGE CALENDAR</span></a></td>
                                      </tr>
                                <tr>
                                      <td height="25" align="center">&nbsp;</td>
                                      <td align="center">&nbsp;</td>
                                </tr>
                          </table>
                          <table width="92%" cellpadding="2" cellspacing="2">
                                <tr>
                                      <td width="338" align="center" bgcolor="#004080"><span class="PortalMenuText"><a href="pgc_cfig_list_cfigs.php" class="PortalMenuText"><span class="PortalMenuText">UPDATE CFIG LIST</span></a></span></td>
                                      <td width="338" align="center" bgcolor="#004080"><span class="PortalMenuText"><a href="pgc_access_menu.php" class="PortalMenuText"><span class="PortalMenuText">ACCESS ADMIN MENU</span></a></span></td>
                                      </tr>
                                <tr>
                                      <td align="center" bgcolor="#004080"><a href="pgc_jobs_admin.php" class="PortalMenuText"><span class="PortalMenuText">PGC PROJECTS - ADMIN UPDATE</span></a><span class="PortalMenuText"><a href="pgc_field_duty_insert_dates.php" class="PortalMenuText"></a></span></td>
                                      <td align="center" bgcolor="#004080"><a href="pgc_flightlog_edit_history.php" class="PortalMenuText"><span class="PortalMenuText">EDIT FLIGHTLOG - ADMIN UPDATE</span></a><span class="PortalMenuText"><a href="pgc_calendar_edit_list.php" class="PortalMenuText"></a></span></td>
                                      </tr>
                                <tr>
                                      <td align="center">&nbsp;</td>
                                      <td align="center">&nbsp;</td>
                                </tr>
                          </table>
                          </div>
                          <div align="center"></div>
                          <table width="200" height="28" border="1" cellpadding="0" cellspacing="0">
                                <tr>
                                      <td width="200" height="26" align="center" bgcolor="#4F1400"><strong class="style11"><a href="../07_members_only_pw.php" class="style16"><span class="PortalMenuText"> MEMBERS PAGE</span></a></strong></td>
                                      </tr>
                        </table></td>
                    </tr>
            </table></td>
  </tr>
</table>
</body>
</html>