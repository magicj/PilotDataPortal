<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
$maxRows_Requests = 10;
$pageNum_Requests = 0;
if (isset($_GET['pageNum_Requests'])) {
  $pageNum_Requests = $_GET['pageNum_Requests'];
}
$startRow_Requests = $pageNum_Requests * $maxRows_Requests;

mysql_select_db($database_PGC, $PGC);
$query_Requests = "SELECT * FROM pgc_request ORDER BY request_date ASC";
$query_limit_Requests = sprintf("%s LIMIT %d, %d", $query_Requests, $startRow_Requests, $maxRows_Requests);
$Requests = mysql_query($query_limit_Requests, $PGC) or die(mysql_error());
$row_Requests = mysql_fetch_assoc($Requests);

if (isset($_GET['totalRows_Requests'])) {
  $totalRows_Requests = $_GET['totalRows_Requests'];
} else {
  $all_Requests = mysql_query($query_Requests);
  $totalRows_Requests = mysql_num_rows($all_Requests);
}
$totalPages_Requests = ceil($totalRows_Requests/$maxRows_Requests)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Member Roster</title>
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
.style2 {
	font-size: 14px;
	font-weight: bold;
}
.style16 {color: #CCCCCC; }
a:link {
	color: #CCCCCC;
}
a:visited {
	color: #CCCCCC;
}
.style17 {
	color: #CCCCCC;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
.style25 {font-weight: bold; color: #A7B5CE;}
.style27 {font-size: 10}
.style30 {font-size: 12px}
-->
</style></head>

<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
  <tr>
    <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="440" bgcolor="#666666"><table width="900" height="556" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
        <tr>
            <td width="1562" height="47" bgcolor="#4F5359"><div align="center" class="style2">
                <table width="60%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><div align="center">PGC INSTRUCTION REQUESTS - ALL ITEMS BY DATE</div></td>
                    </tr>
                    <tr>
                        <td><div align="center"><span class="style30">Use the Request Instruction Function  in the Members Section to  enter or change your request. </span></div></td>
                    </tr>
                </table>
          </div></td>
        </tr>
        <tr>
            <td height="465" align="center" valign="top" bgcolor="#4F5359"><table width="90%" border="1" align="center">
              <tr>
                <td class="style25"><div align="center">DATE ENTERED </div></td>
                <td class="style25"><div align="center">MEMBER</div></td>
                <td class="style25"><div align="center">DATE REQUESTED </div></td>
                <td class="style25"><div align="center">TIME REQUESTED </div></td>
                <td class="style25"><div align="center">TYPE</div></td>
                <td class="style25"><div align="center">CFIG REQUESTED</div></td>
                <td class="style25"><div align="center">REQUEST NOTES</div></td>
                <td class="style25"><div align="center">CFIG ASSIGNED</div></td>
                <td class="style25"><div align="center">ASSIGNEDD DATE</div></td>
                <td class="style25"><div align="center">ASSIGNED NOTES</div></td>
              </tr>
              <?php do { ?>
              <tr>
                <td><?php echo $row_Requests['entry_date']; ?></td>
                <td><?php echo $row_Requests['member_name']; ?></td>
                <td><?php echo $row_Requests['request_date']; ?></td>
                <td><?php echo $row_Requests['request_time']; ?></td>
                <td><?php echo $row_Requests['request_type']; ?></td>
                <td><?php echo $row_Requests['request_cfig']; ?></td>
                <td><?php echo $row_Requests['request_notes']; ?></td>
                <td><?php echo $row_Requests['accept_cfig']; ?></td>
                <td><?php echo $row_Requests['accept_date']; ?></td>
                <td><?php echo $row_Requests['accept_notes']; ?></td>
              </tr>
              <?php } while ($row_Requests = mysql_fetch_assoc($Requests)); ?>
            </table>
            </p></td>
        </tr>
        <tr>
            <td height="30" bgcolor="#4F5359" class="style16"><div align="center"><a href="../07_members_only_pw.php" class="style17">BACK TO MEMBERS PAGE </a></div></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
 