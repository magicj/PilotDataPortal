<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php'?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE IGNORE pgc_pilot_signoffs SET 30_day_email = DATE_ADD(CURDATE(), INTERVAL 5 YEAR), signoff_type=%s, signoff_date=%s, instructor=%s, delete_record=%s WHERE signoffID=%s",
                       GetSQLValueString($_POST['signoff_type'], "text"),
                       GetSQLValueString($_POST['signoff_date'], "date"),
                       GetSQLValueString($_POST['instructor'], "text"),
                       GetSQLValueString($_POST['delete_record'], "text"),
                       GetSQLValueString($_POST['signoffID'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
  //$updateGoTo = 'http://www.pgcsoaring.org'.$_SESSION[last_query];
  $updateGoTo = 'http://' . $_SERVER['HTTP_HOST']  .$_SESSION[last_query];
  if (isset($_SERVER['xQUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsSignoffs = "-1";
if (isset($_GET['signoffID'])) {
  $colname_rsSignoffs = (get_magic_quotes_gpc()) ? $_GET['signoffID'] : addslashes($_GET['signoffID']);
}
mysql_select_db($database_PGC, $PGC);
$query_rsSignoffs = sprintf("SELECT * FROM pgc_pilot_signoffs WHERE signoffID = %s", $colname_rsSignoffs);
$rsSignoffs = mysql_query($query_rsSignoffs, $PGC) or die(mysql_error());
$row_rsSignoffs = mysql_fetch_assoc($rsSignoffs);
$totalRows_rsSignoffs = mysql_num_rows($rsSignoffs);

mysql_select_db($database_PGC, $PGC);
$query_rsSignoffType = "SELECT description FROM pgc_signoff_types ORDER BY sort_order ASC";
$rsSignoffType = mysql_query($query_rsSignoffType, $PGC) or die(mysql_error());
$row_rsSignoffType = mysql_fetch_assoc($rsSignoffType);
$totalRows_rsSignoffType = mysql_num_rows($rsSignoffType);

mysql_select_db($database_PGC, $PGC);
$query_rsInstructors = "SELECT Name FROM pgc_instructors";
$rsInstructors = mysql_query($query_rsInstructors, $PGC) or die(mysql_error());
$row_rsInstructors = mysql_fetch_assoc($rsInstructors);
$totalRows_rsInstructors = mysql_num_rows($rsInstructors);
?>
<?php 
// echo $_SESSION[last_query]; 
// $updateGoTo = "pgc_list_signoffs_select.php";
?>

<?php
require_once('pgc_signoff_table_updates.php')
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - MODIFY or DELETE Signoff </title>
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
.style16 {color: #CCCCCC; }
a:link {
	color: #FFFF99;
}
-->
</style></head>

<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#5B6971">
  <tr>
    <td bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="476" bgcolor="#666666"><table width="92%" height="456" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#005B5B">
      <tr>
        <td height="36" bgcolor="#4F5359"><div align="center"><span class="style11">MODIFY or DELETE PILOT SIGNOFF</span></div></td>
      </tr>
      <tr>
        <td height="373" align="center" valign="top" bgcolor="#4F5359">&nbsp;
            <p>&nbsp;</p>
            <p>
          </p>
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table align="center" cellpadding="3" cellspacing="3" bgcolor="#666666">
              <tr valign="baseline">
                <td width="122" height="26" align="right" valign="middle" nowrap bgcolor="#0E4656"><div align="left"><em><strong>SIGNOFF ID </strong></em></div></td>
                <td width="232" valign="middle" bgcolor="#0F4E55"><div align="left"><strong><?php echo $row_rsSignoffs['signoffID']; ?></strong></div></td>
              </tr>

              <tr valign="baseline">
                <td height="23" align="right" valign="middle" nowrap bgcolor="#0E4656"><div align="left"><em><strong>PILOT NAME </strong></em></div></td>
                <td valign="middle" bgcolor="#0F4E55"><div align="left"><strong><?php echo $row_rsSignoffs['pilot_name']; ?></strong></div></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap bgcolor="#0E4656"><div align="left"><em><strong>SIGNOFF TYPE </strong></em></div></td>
                <td valign="middle" bgcolor="#0F4E55"><div align="left">
                    <select name="signoff_type">
                      <?php
do {  
?><option value="<?php echo $row_rsSignoffType['description']?>"<?php if (!(strcmp($row_rsSignoffType['description'], $_SESSION['signoff_type']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsSignoffType['description']?></option>
                      <?php
} while ($row_rsSignoffType = mysql_fetch_assoc($rsSignoffType));
  $rows = mysql_num_rows($rsSignoffType);
  if($rows > 0) {
      mysql_data_seek($rsSignoffType, 0);
	  $row_rsSignoffType = mysql_fetch_assoc($rsSignoffType);
  }
?>
                    </select>
                </div></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap bgcolor="#0E4656"><div align="left"><em><strong>SIGNOFF DATE </strong></em></div></td>
                <td valign="middle" bgcolor="#0F4E55"><div align="left">
                    <input type="text" name="signoff_date" value="<?php echo $_SESSION['signoff_date']; ?>" size="32">
                </div></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap bgcolor="#0E4656"><div align="left"><em><strong>INSTRUCTOR</strong></em></div></td>
                <td valign="middle" bgcolor="#0F4E55"><div align="left">
                    <select name="instructor">
                      <?php
do {  
?><option value="<?php echo $row_rsInstructors['Name']?>"<?php if (!(strcmp($row_rsInstructors['Name'], $_SESSION['instructor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsInstructors['Name']?></option>
                      <?php
} while ($row_rsInstructors = mysql_fetch_assoc($rsInstructors));
  $rows = mysql_num_rows($rsInstructors);
  if($rows > 0) {
      mysql_data_seek($rsInstructors, 0);
	  $row_rsInstructors = mysql_fetch_assoc($rsInstructors);
  }
?>
                    </select>
                </div></td>
              </tr>

              <tr valign="baseline">
                <td align="right" valign="middle" nowrap bgcolor="#0E4656"><div align="left"><em><strong>DELETE RECORD </strong></em></div></td>
                <td valign="middle" bgcolor="#0F4E55"><div align="left">
                    <select name="delete_record">
                        <option value="NO">NO</option>
                        <option value="YES">YES</option>
                    </select>
                </div></td>
              </tr>
              <tr valign="baseline">
                <td height="54" colspan="2" align="right" valign="middle" nowrap bgcolor="#0E4656">
                        <p align="center">
                          <input type="submit" value="Update record"></p>
                  </td>
                </tr>
            </table>
            <input type="hidden" name="MM_update" value="form1">
            <input type="hidden" name="signoffID" value="<?php echo $row_rsSignoffs['signoffID']; ?>">
          </form>
          <form id="form2" name="form2" method="post" action="">
            <label></label>
            <label></label>
            <label></label>
            <label></label>
          </form>          
          <p>&nbsp;</p>
          </td>
      </tr>
      <tr>
        <td height="37" align="center" valign="top" bgcolor="#4F5359"><strong class="style11"><a href="../PGC_OPS/pgc_portal_menu.php" class="style16">BACK TO MAIN</a> </strong></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

<?php
//
///* Also in pgc_modify_signoff_detail.php
//
///* Do Updates - Make this a function */
//mysql_select_db($database_PGC, $PGC);
//
///* Purge Deletions */
//$deleteSQL = "DELETE FROM pgc_pilot_signoffs WHERE delete_record = 'YES'";
//$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());
//
///* Set both dates to 0000-00-00 */
//$runSQL = "UPDATE pgc_pilot_signoffs SET expire_date = '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Set Expired to OK */
//$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'OK'";  
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Set Expired to NG */
//$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'Expired-C' WHERE signoff_date ='0000-00-00' OR signoff_date = NULL";  
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
//
///* Calc 90 Exact Day Expiry */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 90 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 90 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Calc 730 Exact Day Expiry */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 730 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 730 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Calc 365 Exact Day Expiry */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 365 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 365 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Calc 730 Month End Expiry */ 
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = LAST_DAY(DATE_ADD(A.signoff_date, INTERVAL 730 DAY)) WHERE A.signoff_type = B.description AND B.duration_days = 730 AND B.expires = 'YES' AND B.eom_expiry = 'YES' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Calc 365 Month End Expiry */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = LAST_DAY(DATE_ADD(A.signoff_date, INTERVAL 365 DAY)) WHERE A.signoff_type = B.description AND B.duration_days = 365 AND B.expires = 'YES' AND B.eom_expiry = 'YES' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Set Expired to NG */
//$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'Not Valid' WHERE signoff_date ='0000-00-00' OR signoff_date = NULL";  
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Set Expired to NG */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-A' WHERE (A.expire_date < CURDATE()) AND B.expires = 'YES' AND B.group_id = 'A' AND A.signoff_type = B.description";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-B' WHERE A.expire_date < CURDATE() AND B.expires = 'YES' AND B.group_id = 'B' AND A.signoff_type = B.description";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-C' WHERE A.expire_date < CURDATE() AND B.expires = 'YES' AND B.group_id = 'C' AND A.signoff_type = B.description";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* NULL Non Expiring  */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = NULL WHERE A.signoff_type = B.description AND B.expires ='NO'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* UPDATE Pilot Ratings */
//$runSQL = "UPDATE pgc_pilots SET pgc_ratings = ''";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
//$runSQL = "UPDATE pgc_pilots SET pgc_ratings = (SELECT GROUP_CONCAT(DISTINCT pgc_rating SEPARATOR ', ') FROM pgc_pilot_ratings WHERE pgc_pilots.pilot_name = pgc_pilot_ratings.pilot_name GROUP BY pilot_name)";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());


mysql_free_result($rsSignoffs);

mysql_free_result($rsSignoffType);

mysql_free_result($rsInstructors);
?>