<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php 
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pgc_jobs SET post_date=%s, post_id=%s, job_sponsor=%s, job_sponsor_email=%s, job_leader=%s, job_leader_email=%s, job_name=%s, job_description=%s, job_materials=%s, job_volunteers_required=%s, job_volunteers=%s, job_volunteers_email=%s, job_status=%s, job_comments=%s, job_completed=%s WHERE job_key=%s",
                       GetSQLValueString($_POST['post_date'], "date"),
                       GetSQLValueString($_POST['post_id'], "text"),
                       GetSQLValueString($_POST['job_sponsor'], "text"),
                       GetSQLValueString($_POST['job_sponsor_email'], "text"),
                       GetSQLValueString($_POST['job_leader'], "text"),
                       GetSQLValueString($_POST['job_leader_email'], "text"),
                       GetSQLValueString($_POST['job_name'], "text"),
                       GetSQLValueString($_POST['job_description'], "text"),
                       GetSQLValueString($_POST['job_materials'], "text"),
                       GetSQLValueString($_POST['job_volunteers_required'], "int"),
                       GetSQLValueString($_POST['job_volunteers'], "text"),
                       GetSQLValueString($_POST['job_volunteers_email'], "text"),
                       GetSQLValueString($_POST['job_status'], "text"),
                       GetSQLValueString($_POST['job_comments'], "text"),
                       GetSQLValueString($_POST['job_completed'], "date"),
                       GetSQLValueString($_POST['job_key'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "xxxxxxxxxxxx";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_jobs";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Projects</title>
<style type="text/css">
<!--
body {
	background-color: #333333;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
.style27 {
	font-size: 18px;
	font-weight: bold;
	color: #F2F2FF;
	text-align: left;
}
a:link {
	color: #FFFF9B;
}
a:visited {
	color: #FFFF9B;
}
.style30 {
	color: #FFFFFF;
	font-weight: bold;
	font-style: italic;
}
.style31 {color: #C5C5C5}
.style32 {
	font-size: 14px;
	text-align: center;
}
.style33 {font-size: 14px; font-weight: bold; }
.style36 {color: #E6E6E6; font-weight: bold; font-style: italic; }
.style37 {color: #E6E6E6; }
.style38 {
	font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.JobText {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #F4F4F4;
}
-->
</style>
</head>

<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
    <tr>
        <td bgcolor="#004080"><div align="center" class="style38">PGC PROJECTS - MODIFY</div></td>
    </tr>
    <tr>
        <td height="481"><table width="100%" height="517" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
            
            <tr>
                <td height="511" colspan="5" valign="top"><p>&nbsp;</p>
              <p>&nbsp;</p>
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                <table align="center">
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Job_key:</td>
                    <td><?php echo $row_Recordset1['job_key']; ?></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Post_date:</td>
                    <td><input type="text" name="post_date" value="<?php echo htmlentities($row_Recordset1['post_date'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Post_id:</td>
                    <td><input type="text" name="post_id" value="<?php echo htmlentities($row_Recordset1['post_id'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Job_sponsor:</td>
                    <td><input type="text" name="job_sponsor" value="<?php echo htmlentities($row_Recordset1['job_sponsor'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Job_sponsor_email:</td>
                    <td><input type="text" name="job_sponsor_email" value="<?php echo htmlentities($row_Recordset1['job_sponsor_email'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Job_leader:</td>
                    <td><input type="text" name="job_leader" value="<?php echo htmlentities($row_Recordset1['job_leader'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Job_leader_email:</td>
                    <td><input type="text" name="job_leader_email" value="<?php echo htmlentities($row_Recordset1['job_leader_email'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Job_name:</td>
                    <td><input type="text" name="job_name" value="<?php echo htmlentities($row_Recordset1['job_name'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Job_description:</td>
                    <td><input type="text" name="job_description" value="<?php echo htmlentities($row_Recordset1['job_description'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Job_materials:</td>
                    <td><input type="text" name="job_materials" value="<?php echo htmlentities($row_Recordset1['job_materials'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Job_volunteers_required:</td>
                    <td><input type="text" name="job_volunteers_required" value="<?php echo htmlentities($row_Recordset1['job_volunteers_required'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Job_volunteers:</td>
                    <td><input type="text" name="job_volunteers" value="<?php echo htmlentities($row_Recordset1['job_volunteers'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Job_volunteers_email:</td>
                    <td><input type="text" name="job_volunteers_email" value="<?php echo htmlentities($row_Recordset1['job_volunteers_email'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Job_status:</td>
                    <td><input type="text" name="job_status" value="<?php echo htmlentities($row_Recordset1['job_status'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Job_comments:</td>
                    <td><input type="text" name="job_comments" value="<?php echo htmlentities($row_Recordset1['job_comments'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Job_completed:</td>
                    <td><input type="text" name="job_completed" value="<?php echo htmlentities($row_Recordset1['job_completed'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td><input type="submit" value="Update record" /></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_update" value="form1" />
                <input type="hidden" name="job_key" value="<?php echo $row_Recordset1['job_key']; ?>" />
              </form>
              <p>&nbsp;</p></td>
            </tr>
            
      </table></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
