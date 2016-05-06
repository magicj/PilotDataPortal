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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pgc_jobs (job_sponsor, job_leader, job_name, job_description, job_materials, job_volunteers, job_comments, job_status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['job_sponsor'], "text"),
                       GetSQLValueString($_POST['job_leader'], "text"),
                       GetSQLValueString($_POST['job_name'], "text"),
                       GetSQLValueString($_POST['job_description'], "text"),
                       GetSQLValueString($_POST['job_materials'], "text"),
                       GetSQLValueString($_POST['job_volunteers'], "text"),
					   GetSQLValueString($_POST['job_comments'], "text"),
                       GetSQLValueString($_POST['job_status'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "pgc_jobs_admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
        <td bgcolor="#004080"><div align="center" class="style38">SPECIAL PROJECTS - ENTER</div></td>
    </tr>
    <tr>
        <td height="481"><table width="100%" height="517" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
            
            <tr>
                <td height="511" colspan="5" valign="top"><p>&nbsp;</p>
                  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                    <table align="center" class="style27">
                      <tr valign="baseline">
                        <td width="141" align="left" valign="middle" nowrap="nowrap" class="JobText"><span class="JobText"><span class="JobText">Project Name</span></span></td>
                        <td width="228"><input type="text" name="job_name" value="" size="32" /></td>
                      </tr>
                      <tr valign="baseline">
                        <td align="left" valign="top" nowrap="nowrap" class="JobText">Project Description</td>
                        <td><textarea name="job_description" cols="50" rows="4"></textarea></td>
                      </tr>
                      <tr valign="baseline">
                        <td align="left" valign="middle" nowrap="nowrap" class="JobText">Sponsor</td>
                        <td><label for="job_sponsor2"></label>
                          <select name="job_sponsor" size="1" id="job_sponsor">
                            <?php
do {  
?>
                            <option value="<?php echo $row_pgc_members['NAME']?>"<?php if (!(strcmp($row_pgc_members['NAME'], $row_pgc_members['NAME']))) {echo "selected=\"selected\"";} ?>><?php echo $row_pgc_members['NAME']?></option>
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
                        <td><select name="job_leader" size="1" id="job_leader">
                          <?php
do {  
?>
                          <option value="<?php echo $row_pgc_members['NAME']?>"<?php if (!(strcmp($row_pgc_members['NAME'], $row_pgc_members['NAME']))) {echo "selected=\"selected\"";} ?>><?php echo $row_pgc_members['NAME']?></option>
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
                        <td><textarea name="job_materials" cols="50" rows="4"></textarea></td>
                      </tr>
                      <tr valign="baseline">
                        <td align="left" valign="top" nowrap="nowrap" class="JobText">Volunteers</td>
                        <td valign="top">*** Enter in Project Modify ***</td>
                      </tr>
                      <tr valign="baseline">
                        <td align="left" valign="top" nowrap="nowrap" class="JobText">Comments</td>
                        <td><textarea name="job_comments" cols="50" rows="4" id="job_comments"></textarea></td>
                      </tr>
                      <tr valign="baseline">
                        <td align="left" valign="top" nowrap="nowrap" class="JobText">Status</td>
                        <td valign="middle"><p>
                          <label for="job_status"></label>
                          <select name="job_status" size="1" id="job_status">
                            <?php
do {  
?>
                            <option value="<?php echo $row_job_status['job_status']?>"><?php echo $row_job_status['job_status']?></option>
                            <?php
} while ($row_job_status = mysql_fetch_assoc($job_status));
  $rows = mysql_num_rows($job_status);
  if($rows > 0) {
      mysql_data_seek($job_status, 0);
	  $row_job_status = mysql_fetch_assoc($job_status);
  }
?>
                          </select>
                        </p>
                        <p>&nbsp; </p></td>
                      </tr>
                      <tr valign="baseline">
                        <td colspan="2" align="center" nowrap="nowrap"><table width="90%" cellspacing="1" cellpadding="4">
                          <tr>
                            <td width="47%" align="center"><input type="image" name="submit" value="Input record" src="Graphics/SaveSq.png" style="border:0;" /></td>
                            <td width="53%" align="center"><a href="pgc_jobs_admin.php"><img src="Graphics/ReturnSq.png" alt="Return" width="130" height="30" border="0" /></a></td>
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
mysql_free_result($pgc_members);

mysql_free_result($job_status);
?>
