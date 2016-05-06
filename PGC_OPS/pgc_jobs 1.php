<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT job_key, post_date, post_id, job_sponsor, job_leader, job_name, job_description,job_materials, job_volunteers_required, job_volunteers, job_comments, job_status, job_completed FROM pgc_jobs";
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
-->
</style>
</head>

<body>
<table width="1200" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
    <tr>
        <td bgcolor="#00406A"><div align="center" class="style38"><span class="JobBanner">SPECIAL  PROJECTS VOLUNTEER APP</span></div></td>
    </tr>
    <tr>
      <td height="481"><table width="100%" height="447" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
            
            <tr>
              <td height="373" colspan="5" valign="top"><p>
                                <!--<form action="somewhere.php" method="post">
*/</form>

<p>&nbsp;</p>
-->
                    </p>
                <table width="98%" align="center" cellpadding="3" cellspacing="2" bgcolor="#330066" class="JobGrid">
                    <tr class="JobHeader">
                      <td bgcolor="#00406A">ID</td>
                      <td bgcolor="#00406A">Name</td>
                      <td bgcolor="#00406A">Description</td>
                      <td bgcolor="#00406A">Skills/Materials</td>
                      <td bgcolor="#00406A">Sponsor</td>
                      <td bgcolor="#00406A">Leader</td>
                      <td bgcolor="#00406A">Volunteers</td>
                      <td bgcolor="#00406A">Comments</td>
                      <td bgcolor="#00406A">Status</td>
                    </tr>
                    <?php do { ?>
                      <tr class="JobLine">
                        <td width="10" bgcolor="#004879"><?php echo $row_Recordset1['job_key']; ?></td>
                        <td width="75" bgcolor="#004879"><?php echo $row_Recordset1['job_name']; ?></td>
                        <td bgcolor="#004879"><?php echo $row_Recordset1['job_description']; ?></td>
                        <td bgcolor="#004879"><?php echo $row_Recordset1['job_materials']; ?></td>
                        <td width="75" bgcolor="#004879"><?php echo $row_Recordset1['job_sponsor']; ?></td>
                        <td width="75" bgcolor="#004879"><?php echo $row_Recordset1['job_leader']; ?></td>
                        <td bgcolor="#004879"><?php echo $row_Recordset1['job_volunteers']; ?></td>
                        <td bgcolor="#004879"><?php echo $row_Recordset1['job_comments']; ?></td>
                        <td width="75" bgcolor="#004879"><?php echo $row_Recordset1['job_status']; ?></td>
                      </tr>
                      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                </table>
              <p class="JobHeader">&nbsp;</p></td>
            </tr>
            
        </table>
       <a href="pgc_jobs_menu.php" class="JobHeader">Jobs Main Menu</a></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
