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
}
.style11 {font-size: 16px; font-weight: bold; }
.style13 {font-size: 14px; font-weight: bold; }
a:link {
	color: #CCCCCC;
}
a:visited {
	color: #CCCCCC;
}
.style17 {font-size: 14px; font-weight: bold; color: #6699FF; }
.style18 {color: #6699FF}
.style16 {color: #CCCCCC; }
-->
</style></head>

<body>
<table width="800" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="514"><table width="92%" height="417" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36"><div align="center"><span class="style11">MAIN PORTAL MENU </span></div></td>
      </tr>
      <tr>
        <td height="373"><div align="center">
                <table width="93%" border="0" cellspacing="2" cellpadding="2">
                        <tr bgcolor="#004242">
                            <td width="50%"><div align="center"><span class="style17"><a href="../PGC_OPS/pgc_list_signoffs_select.php" class="style13">LIST/MODIFY PILOT SIGNOFFS </a> </span></div></td>
                            <td width="50%"><div align="center"><a href="../PGC_OPS/pgc_list_pilot_rating_select.php" class="style17">LIST/MODIFY PILOT RATING</a><a href="../PGC_OPS/pgc_add_pilot_rating.php" class="style17"></a></div></td>
                        </tr>
                        <tr bgcolor="#004242">
                            <td><div align="center"><a href="../PGC_OPS/pgc_enter_pilot_signoff.php" class="style17">ADD PILOT SIGNOFF - SINGLE </a> </div></td>
                            <td><div align="center"><a href="../PGC_OPS/pgc_add_pilot_rating.php" class="style17">ADD PILOT RATING - SINGLE</a></div></td>
                        </tr>
                            </table>
            </div>
            <p align="center">&nbsp;</p>
            <div align="center">
                <table width="93%" border="0" cellspacing="2" cellpadding="2">
                    <tr bgcolor="#004242">
                        <td width="50%"><div align="center"><a href="../PGC_OPS/pgc_list_signoffs_nofly.php" class="style17">LIST PILOT SIGNOFFS - EXPIRED </a></div></td>
                        <td width="50%"><div align="center"><a href="../PGC_OPS/pgc_list_pilot_rating.php" class="style17">LIST ALL PILOT RATINGS</a></div></td>
                    </tr>
                    <tr bgcolor="#004242">
                        <td><div align="center"></div></td>
                        <td><div align="center"><a href="pgc_pilot_report-xls.php" class="style17">PGC PILOT REPORT - XLS </a></div></td>
                    </tr>
                </table>
            </div>            
            <p align="center">&nbsp;</p>
            <div align="center">
                <table width="93%" border="0" cellspacing="2" cellpadding="2">

                    <tr bgcolor="#004242">
                        <td width="50%" height="22"><div align="center"><a href="pgc_klaus_updates.php" class="style17">APPLY BATCH DATA UPDATES</a></div></td>
                        <td width="50%"><div align="center"><a href="pgc_list_signoff_types.php" class="style17"><strong>LIST/MODIFY SIGNOFF TYPES</strong></a></div></td>
                    </tr>
                    <tr bgcolor="#004242">
                        <td height="22"><div align="center"><span class="style18"></span></div></td>
                        <td><div align="center"><a href="../PGC_OPS/pgc_insert_signoff_type.php" class="style17"><strong>CREATE NEW SIGNOFF TYPES</strong></a></div></td>
                    </tr>

                </table>
            </div>
            <p>&nbsp;</p>
            <p align="center"><strong class="style11"><a href="../07_members_only_pw.php" class="style16">BACK TO MEMBERS PAGE</a></strong></p>
            </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>