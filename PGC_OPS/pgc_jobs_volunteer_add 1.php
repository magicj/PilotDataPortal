<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php 
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
$CancelGoTo = "pgc_jobs_modify.php?". $_SESSION['LAST_PROJECT_ID'];
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT IGNORE INTO pgc_job_volunteers (job_id, post_id, job_volunteer_name,   dup_check_key) VALUES (%s, %s, %s, %s)",
                       
                       GetSQLValueString($_SESSION['LAST_JOB_KEY'], "text"),
                       GetSQLValueString($_SESSION['MM_PilotName'], "text"),
                       GetSQLValueString($_POST['job_volunteer_name'], "text"),
                       GetSQLValueString($_SESSION['LAST_JOB_KEY'] . $_POST['job_volunteer_name'], "text")
					   );

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

   $insertGoTo = "pgc_jobs_modify.php?". $_SESSION['LAST_PROJECT_ID'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['job_id'])) {
  $colname_Recordset1 = $_GET['job_id'];
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_job_volunteers WHERE job_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_PGC, $PGC);
$query_pgc_members = "SELECT USER_ID, NAME, active FROM pgc_members ORDER BY NAME ASC";
$pgc_members = mysql_query($query_pgc_members, $PGC) or die(mysql_error());
$row_pgc_members = mysql_fetch_assoc($pgc_members);
$totalRows_pgc_members = mysql_num_rows($pgc_members);

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
	font-size: 14px;
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
	color: #333333;
	font-weight: bold;
}
.VolunteerRow {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000;
}
.ProjectText {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000;
}
-->
</style>
</head>

<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
    <tr>
        <td bgcolor="#004080"><div align="center" class="style38">PGC PROJECTS - VOLUNTEER ADD</div></td>
    </tr>
    <tr>
        <td height="481"><table width="100%" height="517" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
            
            <tr>
                <td height="511" colspan="5" valign="top"><p>&nbsp;</p>
                  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                    <table align="center" class="style27">
                      <tr valign="baseline">
                        <td width="207" align="right" nowrap="nowrap" bgcolor="#CCCCCC" class="JobText">Volunteer Name:</td>
                        <td width="236" bgcolor="#CCCCCC"><select name="job_volunteer_name" size="1" class="ProjectText" id="job_volunteer_name">
                          <?php
do {  
?>
                          <option value="<?php echo $row_pgc_members['NAME']?>"<?php if (!(strcmp($row_pgc_members['NAME'], $row_Recordset1['job_sponsor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_pgc_members['NAME']?></option>
                            <?php
} while ($row_pgc_members = mysql_fetch_assoc($pgc_members));
  $rows = mysql_num_rows($pgc_members);
  if($rows > 0) {
      mysql_data_seek($pgc_members, 0);
	  $row_pgc_members = mysql_fetch_assoc($pgc_members);
  }
?>
                        </select></td>
                      </tr>
                      <tr valign="baseline">
                        <td height="39" colspan="2" align="right" nowrap="nowrap" bgcolor="#CCCCCC"><table width="90%" align="center" cellpadding="4" cellspacing="1">
                          <tr>
                            <td width="51%" align="center"><input type="image" name="submit" value="Input record" src="Graphics/SaveSq.png" style="border:0;" /></td>
                            <td width="49%" align="center"><a href=<?php echo $CancelGoTo?>><img src="Graphics/ReturnSq.png" alt="Return" width="130" height="30" border="0" /></a></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="form1" />
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

mysql_free_result($pgc_members);
?>
