<?php require_once('../Connections/PGC.php'); ?>
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

$colname_projects = "-1";
if (isset($_GET['job_id'])) {
  $_SESSION['LAST_JOB_KEY'] = $_GET['job_id'];
  $colname_projects = (get_magic_quotes_gpc()) ? $_GET['job_id'] : addslashes($_GET['job_id']);
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $_SESSION['LAST_PROJECT_ID'] = $_SERVER['QUERY_STRING'];	
  $_SERVER['QUERY_STRING'] == '';
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pgc_jobs SET  job_sponsor=%s,   job_leader=%s,  job_name=%s, job_description=%s, job_materials=%s,     job_status=%s, job_comments=%s  WHERE job_key=%s",
                   
                       GetSQLValueString($_POST['job_sponsor'], "text"),                        
                       GetSQLValueString($_POST['job_leader'], "text"),                        
                       GetSQLValueString($_POST['job_name'], "text"),
                       GetSQLValueString($_POST['job_description'], "text"),
                       GetSQLValueString($_POST['job_materials'], "text"),
                       GetSQLValueString($_POST['job_status'], "text"),
                       GetSQLValueString($_POST['job_comments'], "text"),                       
					   GetSQLValueString($colname_projects, "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "pgc_jobs_admin.php?".$_SESSION['last_adminjob_query'];
 /* if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  } */
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_PGC, $PGC);
$query_pgc_members = "SELECT NAME FROM pgc_members WHERE active = 'YES' ORDER BY NAME ASC";
$pgc_members = mysql_query($query_pgc_members, $PGC) or die(mysql_error());
$row_pgc_members = mysql_fetch_assoc($pgc_members);
$totalRows_pgc_members = mysql_num_rows($pgc_members);

mysql_select_db($database_PGC, $PGC);
$query_job_status = "SELECT * FROM pgc_job_status";
$job_status = mysql_query($query_job_status, $PGC) or die(mysql_error());
$row_job_status = mysql_fetch_assoc($job_status);
$totalRows_job_status = mysql_num_rows($job_status);

$maxRows_Volunteeers = 5;
$pageNum_Volunteeers = 0;
if (isset($_GET['pageNum_Volunteeers'])) {
  $pageNum_Volunteeers = $_GET['pageNum_Volunteeers'];
}
$startRow_Volunteeers = $pageNum_Volunteeers * $maxRows_Volunteeers;

$colname_Volunteeers = "-1";
if (isset($_GET['job_id'])) {
  $colname_Volunteeers = $_GET['job_id'];
}
mysql_select_db($database_PGC, $PGC);
$query_Volunteeers = sprintf("SELECT volunteer_key, job_volunteer_name FROM pgc_job_volunteers WHERE pgc_job_volunteers.rec_deleted <> 'YES' AND job_id = %s", GetSQLValueString($colname_Volunteeers, "int"));
$query_limit_Volunteeers = sprintf("%s LIMIT %d, %d", $query_Volunteeers, $startRow_Volunteeers, $maxRows_Volunteeers);
$Volunteeers = mysql_query($query_limit_Volunteeers, $PGC) or die(mysql_error());
$row_Volunteeers = mysql_fetch_assoc($Volunteeers);

if (isset($_GET['totalRows_Volunteeers'])) {
  $totalRows_Volunteeers = $_GET['totalRows_Volunteeers'];
} else {
  $all_Volunteeers = mysql_query($query_Volunteeers);
  $totalRows_Volunteeers = mysql_num_rows($all_Volunteeers);
}
$totalPages_Volunteeers = ceil($totalRows_Volunteeers/$maxRows_Volunteeers)-1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf( "SELECT * FROM pgc_jobs WHERE job_key=%s", GetSQLValueString($colname_projects, "text"));
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
	color: #F4F4F4;
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
        <td bgcolor="#004080"><div align="center" class="style38">SPECIAL PROJECTS - MODIFY</div></td>
    </tr>
    <tr>
        <td height="481"><table width="100%" height="517" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
            
            <tr>
                <td height="511" colspan="5" valign="top"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                  <p>&nbsp;</p>
                  <table align="center" cellpadding="2" cellspacing="2" class="style27">
                  <tr valign="baseline">
                    <td width="176" align="left" valign="middle" nowrap="nowrap"><span class="JobText">Project ID</span></td>
                    <td width="357"><?php echo $row_Recordset1['job_key']; ?></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="left" valign="middle" nowrap="nowrap" class="JobText">Project Name</td>
                    <td><input name="job_name" type="text" class="ProjectText" id="job_name" value="<?php echo htmlentities($row_Recordset1['job_name']); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="left" valign="top" nowrap="nowrap" class="ProjectText"><span class="JobText">Project Description</span></td>
                    <td><textarea name="job_description" cols="50" rows="4" class="ProjectText" id="job_description"><?php echo htmlentities($row_Recordset1['job_description']); ?></textarea></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="left" valign="middle" nowrap="nowrap" class="JobText">Sponsor</td>
                    <td><select name="job_sponsor" size="1" class="ProjectText" id="job_sponsor">
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
                    <td align="left" valign="middle" nowrap="nowrap" class="JobText">Leader</td>
                    <td><select name="job_leader" size="1" class="ProjectText" id="job_leader">
                      <?php
do {  
?>
                      <option value="<?php echo $row_pgc_members['NAME']?>"<?php if (!(strcmp($row_pgc_members['NAME'], $row_Recordset1['job_leader']))) {echo "selected=\"selected\"";} ?>><?php echo $row_pgc_members['NAME']?></option>
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
                    <td align="left" valign="top" nowrap="nowrap" class="JobText">Skills / Materials</td>
                    <td><textarea name="job_materials" cols="50" rows="4" class="ProjectText"><?php echo htmlentities($row_Recordset1['job_materials'], ENT_COMPAT, 'iso-8859-1'); ?></textarea></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="left" valign="top" nowrap="nowrap" class="JobText">Comments</td>
                    <td><textarea name="job_comments" cols="50" rows="4" class="ProjectText"><?php echo htmlentities($row_Recordset1['job_comments'], ENT_COMPAT, 'iso-8859-1'); ?></textarea></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="left" valign="middle" nowrap="nowrap" class="JobText">Status</td>
                    <td><select name="job_status" size="1" class="ProjectText" id="job_status">
                      <?php
do {  
?>
                      <option value="<?php echo $row_job_status['job_status']?>"<?php if (!(strcmp($row_job_status['job_status'], $row_Recordset1['job_status']))) {echo "selected=\"selected\"";} ?>><?php echo $row_job_status['job_status']?></option>
                      <?php
} while ($row_job_status = mysql_fetch_assoc($job_status));
  $rows = mysql_num_rows($job_status);
  if($rows > 0) {
      mysql_data_seek($job_status, 0);
	  $row_job_status = mysql_fetch_assoc($job_status);
  }
?>
                    </select></td>
                  </tr>
                  <tr valign="baseline">
                    <td height="49" colspan="2" align="right" valign="middle" nowrap="nowrap"><table width="90%" align="center" cellpadding="4" cellspacing="1">
                      <tr>
                        <td width="36%" align="center"><input type="image" name="submit" value="Update record" src="Graphics/SaveSq.png" style="border:0;" /></td>
                        <td width="31%" align="center"><a href="pgc_jobs_volunteer_add.php"><img src="Graphics/AddSq.png" alt="Volunteer" width="137" height="30" border="0" /></a></td>
                        <td width="31%" align="center"><a href="pgc_jobs_admin.php"><img src="Graphics/ReturnSq.png" alt="Return" width="130" height="30" border="0" /></a></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr valign="baseline">
                    <td height="49" colspan="2" align="left" valign="middle" nowrap="nowrap"><table width="522" align="left" cellpadding="2" cellspacing="2">
                      <tr>
                        <td width="496" bgcolor="#FF0000" class="JobText">Volunteers (Click name for IMMEDIATE deletion)</td>
                      </tr>
                      <?php do { ?>
                      <tr>
                        <td bgcolor="#666666" class="VolunteerRow"><a href="pgc_jobs_volunteer_delete.php?volunteer_key=<?php echo $row_Volunteeers['volunteer_key']; ?>"><?php echo $row_Volunteeers['job_volunteer_name']; ?></a></td>
                      </tr>
                      <?php } while ($row_Volunteeers = mysql_fetch_assoc($Volunteeers)); ?>
                    </table></td>
                  </tr>
                  </table>
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                <p>
                  <input type="hidden" name="MM_update" value="form1" />
                  <input type="hidden" name="job_key" value="<?php echo $row_Recordset1['job_key']; ?>" />
                </p>
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
mysql_free_result($pgc_members);

mysql_free_result($Volunteeers);

mysql_free_result($Recordset1);
?>
