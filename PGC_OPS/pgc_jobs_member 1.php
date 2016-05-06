<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php error_reporting(0);
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
$currentPage = $_SERVER["PHP_SELF"];
require_once('pgc_jobs_refresh.php'); 
?>
<?php
$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT job_key, post_date, post_id, job_sponsor, job_sponsor_email, job_leader, job_leader_email, job_name, job_description, job_materials, job_volunteers_required, job_volunteers, job_volunteers_email, job_status, job_comments, job_completed, sort_order FROM pgc_jobs ORDER BY sort_order ASC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT job_key, post_date, post_id, job_sponsor, job_sponsor_email, job_leader, job_leader_email, job_name, job_description, job_materials, job_volunteers_required, job_volunteers, job_volunteers_email, job_status, job_comments, job_completed, sort_order FROM pgc_jobs WHERE job_status <> 'Inactive' ORDER BY sort_order ASC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Projects</title>
<style type="text/css">
<!--
body {
	background-color: #283664;
	background-image: url(../images/Buttons/PGC%20copy.png);
}
a:link {
	color: #FFFF9B;
}
a:visited {
	color: #FFFF9B;
}

.JobHeader {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bolder;
	color: #FFF;
	font-style: italic;
	text-align: center;
}
.JobBanner {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
	color: #FFF;
}
.JobGrid {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #FFF;
	background-color: #666666;
}
.JobLine {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #FFF;
}
.style11 {font-size: 15px;
	font-weight: bold;
	color: #EFEFEF;
}
-->
</style>
</head>

<body>
<table width="1200" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
    <tr>
        <td bgcolor="#00406A"><div align="center" class="style38"><span class="JobBanner">SPECIAL  PROJECTS VOLUNTEER APP - MEMBER VIEW</span></div></td>
    </tr>
    <tr>
      <td height="481" align="center"><table width="100%" height="447" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
            
            <tr>
              <td height="373" colspan="5" align="center" valign="top"><table width="98%" cellspacing="1" cellpadding="1">
                    <tr>
                                <td width="15%"><strong class="style11"><a href="../07_members_only_pw.php"><img src="../images/Buttons/GoMembers.jpg" width="133" height="24" alt="Members" /></a></strong></td>
                                <td width="71%" align="center"><span class="JobHeader">Click on the Green Circle to Volunteer - or email the Sponsor / Leader if you have questions</span></td>
                                <td width="14%">&nbsp;</td>
                          </tr>
              </table>
                    <p>&nbsp;</p>
                <table width="98%" align="center" cellpadding="3" cellspacing="2" bgcolor="#330066" class="JobGrid">
                    <tr class="JobHeader">
                      <td bgcolor="#00406A">Name</td>
                      <td bgcolor="#00406A">Description</td>
                      <td bgcolor="#00406A">Skills/Materials</td>
                      <td bgcolor="#00406A">Sponsor</td>
                      <td bgcolor="#00406A">Leader</td>
                      <td bgcolor="#00406A">Volunteers</td>
                      <td bgcolor="#00406A">YES</td>
                      <td bgcolor="#00406A">Comments</td>
                      <td bgcolor="#00406A">Status</td>
                    </tr>
                    <?php do { ?>
           	  <?php
			  $color =  "#004879"; 
			  if ($row_Recordset1['job_status'] == "Volunteers Needed") {
			  $color = "#562C2C"; 
			  }
			  if ($row_Recordset1['job_status'] == "Project Leader Needed") {
			  $color = "#562C2C"; 
			  }
              ?>
                      <tr class="JobLine">
                        <td width="75" bgcolor="<?php echo $color; ?>"><?php echo $row_Recordset1['job_name']; ?></td>
                        <td bgcolor="<?php echo $color; ?>"><?php echo $row_Recordset1['job_description']; ?></td>
                        <td bgcolor="<?php echo $color; ?>"><?php echo $row_Recordset1['job_materials']; ?></td>
                        <td width="75" bgcolor="<?php echo $color; ?>"><a href="mailto:<?php echo $row_Recordset1['job_sponsor_email']; ?>"><?php echo $row_Recordset1['job_sponsor']; ?></a></a></td>
                        <td width="75" bgcolor="<?php echo $color; ?>"><a href="mailto:<?php echo $row_Recordset1['job_leader_email']; ?>"><?php echo $row_Recordset1['job_leader']; ?></a></td>
                        <td bgcolor="<?php echo $color; ?>"><a href="mailto:<?php echo $row_Recordset1['job_volunteers_email']; ?>"><?php echo $row_Recordset1['job_volunteers']; ?></a></td>
                        <td align="center" bgcolor="<?php echo $color; ?>">
                        <?php if ($row_Recordset1['job_status'] =='Volunteers Needed' ){ ?>
                           <a href="pgc_jobs_volunteer_auto_add.php?job_id=<?php echo $row_Recordset1['job_key']; ?>"><img src="Graphics/GreenCircle copy.png" width="19" height="21" border="0" /></a>
                        <?php } ELSE { ?>
                          <img src="Graphics/RedCircle copy.png" width="19" height="21" border="0" />
                         <?php } ?>
                        </td>
                        <td bgcolor="<?php echo $color; ?>"><?php echo $row_Recordset1['job_comments']; ?></td>
                        <td width="75" bgcolor="<?php echo $color; ?>"><?php echo $row_Recordset1['job_status']; ?></td>
                      </tr>
                      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                </table>
              <p class="JobHeader">&nbsp;              
              <table border="0">
                <tr>
                  <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="First.gif" /></a>
                  <?php } // Show if not first page ?></td>
                  <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="Previous.gif" /></a>
                  <?php } // Show if not first page ?></td>
                  <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="Next.gif" /></a>
                  <?php } // Show if not last page ?></td>
                  <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="Last.gif" /></a>
                  <?php } // Show if not last page ?></td>
                </tr>
              </table>
              </p>
              <p>&nbsp;</p></td>
            </tr>
            
        </table>
       <a href="../07_members_only_pw.php" class="JobHeader"><strong class="style11"><a href="../07_members_only_pw.php"><img src="../images/Buttons/GoMembers.jpg" width="133" height="24" alt="Members" /></a></strong></a></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
