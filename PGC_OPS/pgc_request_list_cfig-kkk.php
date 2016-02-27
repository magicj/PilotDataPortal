<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['last_r_query'] = "http://" .  $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING']; 
$session_pilotname = $_SESSION['MM_PilotName'];
$session_email = $_SESSION['MM_Username']; 
?>
<?php
$maxRows_Requests = 10;
$pageNum_Requests = 0;
if (isset($_GET['pageNum_Requests'])) {
  $pageNum_Requests = $_GET['pageNum_Requests'];
}
$startRow_Requests = $pageNum_Requests * $maxRows_Requests;

mysql_select_db($database_PGC, $PGC);
$query_Requests = "SELECT request_key, entry_date, member_id, member_name, Date_format(request_date,'%W, %M %e') as mydate,  request_time, request_type, request_cfig, request_notes, accept_cfig, accept_date, accept_notes FROM pgc_request WHERE request_date >= curdate() ORDER BY request_date ASC, request_cfig ASC  ";
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

$queryString_Requests = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Requests") == false && 
        stristr($param, "totalRows_Requests") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Requests = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Requests = sprintf("&totalRows_Requests=%d%s", $totalRows_Requests, $queryString_Requests);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CFIG View - List Requests</title>
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
</style>
</head>
<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
  <tr>
    <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="374" bgcolor="#666666"><table width="900" height="316" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
        <tr>
          <td width="1562" height="56" bgcolor="#4F5359"><div align="center" class="style2">
              <table width="60%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><div align="center">CFIG VIEW - STUDENT  INSTRUCTION REQUESTS - LIST ALL BY DATE REQUESTED </div></td>
                </tr>
                <tr>
                  <td><div align="center"></div></td>
                </tr>
              </table>
              <?php echo $_SESSION[MM_request_id]?> </div></td>
        </tr>
        <tr>
          <td height="215" align="center" valign="top" bgcolor="#4F5359"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#36373A">
              <tr>
                <td width="10" bgcolor="#35415B" class="style25"><div align="center">EDIT</div></td>
                <td width="159" bgcolor="#35415B" class="style25"><div align="center">MEMBER</div></td>
                <td width="120" bgcolor="#35415B" class="style25"><div align="center">DATE REQUESTED </div></td>
                <td width="143" bgcolor="#35415B" class="style25"><div align="center">CFIG REQUESTED</div></td>
                <td width="10" bgcolor="#35415B" class="style25"><div align="center">AUTO</div></td>
                <td width="140" bgcolor="#35415B" class="style25"><div align="center">CFIG ASSIGNED</div></td>
              </tr>
              <?php do { ?>
                <tr>
                  <td bgcolor="#35415B"><div align="center"><a href="pgc_request_modify_cfig.php?request_id=<?php echo $row_Requests['request_key']; ?>"><?php echo $row_Requests['request_key']; ?></a></div></td>
                  <td bgcolor="#35415B"><?php echo $row_Requests['member_name']; ?></td>
                  <td bgcolor="#35415B"><div align="left"><?php echo $row_Requests['mydate']; ?></div></td>
                  <td bgcolor="#35415B"><?php echo $row_Requests['request_cfig']; ?></td>
                  <td bgcolor="#35415B"><div align="center"><a href="pgc_request_modify_cfig_auto.php?request_id=<?php echo $row_Requests['request_key']; ?>"><?php echo $row_Requests['request_key'];$_SESSION['MM_request_key'] = $row_Requests['request_key']; ?></a></div></td>
                  <td bgcolor="#35415B"><?php echo $row_Requests['accept_cfig']; ?></td>
                </tr>
                <?php } while ($row_Requests = mysql_fetch_assoc($Requests)); ?>
            </table>
            <table width="50%" border="0" align="center" bgcolor="#CCCCCC">
              <tr>
                <td width="23%" align="center"><?php if ($pageNum_Requests > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Requests=%d%s", $currentPage, 0, $queryString_Requests); ?>"><img src="First.gif" border="0" /></a>
                    <?php } // Show if not first page ?>
                </td>
                <td width="31%" align="center"><?php if ($pageNum_Requests > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Requests=%d%s", $currentPage, max(0, $pageNum_Requests - 1), $queryString_Requests); ?>"><img src="Previous.gif" border="0" /></a>
                    <?php } // Show if not first page ?>
                </td>
                <td width="23%" align="center"><?php if ($pageNum_Requests < $totalPages_Requests) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Requests=%d%s", $currentPage, min($totalPages_Requests, $pageNum_Requests + 1), $queryString_Requests); ?>"><img src="Next.gif" border="0" /></a>
                    <?php } // Show if not last page ?>
                </td>
                <td width="23%" align="center"><?php if ($pageNum_Requests < $totalPages_Requests) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Requests=%d%s", $currentPage, $totalPages_Requests, $queryString_Requests); ?>"><img src="Last.gif" border="0" /></a>
                    <?php } // Show if not last page ?>
                </td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="30" bgcolor="#4F5359" class="style16"><div align="center"><a href="../07_members_only_pw.php" class="style17">BACK TO MEMBERS PAGE</a></div></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Requests);

?>
