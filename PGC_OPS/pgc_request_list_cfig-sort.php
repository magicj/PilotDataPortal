<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
$_SESSION['last_r_query'] = "http://" .  $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING']; 
$session_pilotname = $_SESSION['MM_PilotName'];
$session_email = $_SESSION['MM_Username']; 

mysql_select_db($database_PGC, $PGC);
$runSQL = "UPDATE pgc_request SET cfig_vacation = 'N'"; 
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

mysql_select_db($database_PGC, $PGC);
$runSQL = "UPDATE pgc_request SET cfig2_vacation = 'N'"; 
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL = "UPDATE pgc_request A, pgc_cfig_vacation B SET A.cfig_vacation = 'Y'
WHERE A.request_cfig = B.cfig_name and (A.request_date >= B.vac_start AND A.request_date <= B.vac_end)"; 
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL = "UPDATE pgc_request A, pgc_cfig_vacation B SET A.cfig2_vacation = 'Y'
WHERE A.accept_cfig = B.cfig_name and (A.request_date >= B.vac_start AND A.request_date <= B.vac_end)"; 
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

?>

<?php
$maxRows_Requests = 15;
$pageNum_Requests = 0;
if (isset($_GET['pageNum_Requests'])) {
  $pageNum_Requests = $_GET['pageNum_Requests'];
}
$startRow_Requests = $pageNum_Requests * $maxRows_Requests;

mysql_select_db($database_PGC, $PGC);
$query_Requests = "SELECT request_key, entry_date, member_id, member_name,member_weight, Date_format(request_date,'%W, %M %e') as mydate,  request_time, request_type, request_cfig,cfig_vacation, cfig_weight, request_notes, accept_cfig, cfig2_vacation, accept_date, accept_notes FROM pgc_request WHERE request_date >= curdate() ORDER BY  request_cfig ASC, request_date ASC  ";
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
.style33 {color: #DD0000}
.style34 {
	color: #333333;
	font-weight: bold;
}
.style35 {color: #993300}
-->
</style>
</head>
<body>
<table width="1000" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
  <tr>
    <td width="1129" align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="374" bgcolor="#666666"><table width="99%" height="316" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
        <tr>
          <td width="1126" height="56" bgcolor="#4F5359"><div align="center" class="style2">
            <table width="98%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="20%" height="25">&nbsp;</td>
                <td width="60%"><div align="center">CFIG VIEW - STUDENT  INSTRUCTION REQUESTS - LIST ALL BY DATE REQUESTED </div></td>
                <td width="20%"><div align="center"><span class="style33">RED = VACATION CONFLICT</span></div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><div align="right" class="style34">
                  <div align="center"><a href="pgc_request_vacation_view.php" class="style35">DISPLAY CFIG VACATIONS</a></div>
                </div></td>
              </tr>
            </table>
          </div></td>
        </tr>
        <tr>
          <td height="215" align="center" valign="top" bgcolor="#4F5359"><table width="100%" border="0" align="center" cellpadding="1" cellspacing="3" bgcolor="#36373A">
              <tr>
                <td bgcolor="#35415B" class="style25"><div align="center">EDIT</div></td>
                <td bgcolor="#35415B" class="style25"><div align="center">MEMBER</div></td>
                <td bgcolor="#35415B" class="style25"><div align="center">WT</div></td>
                <td bgcolor="#35415B" class="style25"><div align="center">DATE REQUESTED </div></td>
                <td bgcolor="#35415B" class="style25"><div align="center">TYPE</div></td>
                <td bgcolor="#35415B" class="style25"><div align="center">REQUEST NOTES</div></td>
                <td bgcolor="#35415B" class="style25"><div align="center">CFIG REQUESTED</div></td>
                <td bgcolor="#35415B" class="style25"><div align="center">AUTO</div></td>
                <td bgcolor="#35415B" class="style25"><div align="center">CFIG ASSIGNED</div></td>
                <td bgcolor="#35415B" class="style25"><div align="center">MAX WT </div></td>
              </tr>
              <?php do { ?>
                <tr>
                  <td bgcolor="#35415B"><div align="center"><a href="pgc_request_modify_cfig.php?request_id=<?php echo $row_Requests['request_key']; ?>"><?php echo $row_Requests['request_key']; ?></a></div></td>
                  <td bgcolor="#35415B"><div align="left"><a href="mailto:<?php echo $row_Requests['member_id']; ?>"><?php echo $row_Requests['member_name']; ?></a></div></td>
                  <td bgcolor="#35415B"><?php echo $row_Requests['member_weight']; ?></td>

                  <td bgcolor="#35415B"><div align="center"><?php echo $row_Requests['mydate']; ?></div></td>
                  <td bgcolor="#35415B"><div align="left"><?php echo $row_Requests['request_type']; ?></div></td>
                  <td bgcolor="#35415B"><div align="left"><?php echo $row_Requests['request_notes']; ?></div></td>


			  <?php
			  $color = "#35415B"; 

 			  if ($row_Requests['cfig_vacation'] == "Y") {
			  $color = "#990000"; 
			  }

			  ?>
				  
                  <td bgcolor="<?php echo $color; ?>"><div align="left"><?php echo $row_Requests['request_cfig']; ?></div></td>
                  <td bgcolor="#35415B"><div align="center"><a href="pgc_request_modify_cfig_auto.php?request_id=<?php echo $row_Requests['request_key']; ?>"><?php echo '>>>';$_SESSION['MM_request_key'] = $row_Requests['request_key']; ?></a></div></td>
				  
				  			  <?php
			  $color = "#35415B"; 

 			  if ($row_Requests['cfig2_vacation'] == "Y")   {
			  $color = "#990000"; 
			  }

			  ?>
				  
                  <td bgcolor="<?php echo $color; ?>"><div align="left"><?php echo $row_Requests['accept_cfig']; ?></div></td>
                  <td bgcolor="#35415B"><?php echo $row_Requests['cfig_weight']; ?></td>
                </tr>
                <?php } while ($row_Requests = mysql_fetch_assoc($Requests)); ?>
            </table>
            <table width="50%" border="0" align="center" bgcolor="#CCCCCC">
              <tr>
                <td width="23%" align="center"><?php if ($pageNum_Requests > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Requests=%d%s", $currentPage, 0, $queryString_Requests); ?>"><img src="First.gif" border="0" /></a>
                    <?php } // Show if not first page ?>                </td>
                <td width="31%" align="center"><?php if ($pageNum_Requests > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Requests=%d%s", $currentPage, max(0, $pageNum_Requests - 1), $queryString_Requests); ?>"><img src="Previous.gif" border="0" /></a>
                    <?php } // Show if not first page ?>                </td>
                <td width="23%" align="center"><?php if ($pageNum_Requests < $totalPages_Requests) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Requests=%d%s", $currentPage, min($totalPages_Requests, $pageNum_Requests + 1), $queryString_Requests); ?>"><img src="Next.gif" border="0" /></a>
                    <?php } // Show if not last page ?>                </td>
                <td width="23%" align="center"><?php if ($pageNum_Requests < $totalPages_Requests) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Requests=%d%s", $currentPage, $totalPages_Requests, $queryString_Requests); ?>"><img src="Last.gif" border="0" /></a>
                    <?php } // Show if not last page ?>                </td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="30" bgcolor="#4F5359" class="style16"><div align="center"><a href="../07_members_only_pw.php" class="style17"></a>
            <table width="84%" height="21" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="36%">&nbsp;</td>
                <td width="32%"><a href="../07_members_only_pw.php" class="style17">BACK TO MEMBERS PAGE</a></td>
                <td width="32%"><div align="right" class="style34"><a href="pgc_request_vacation_view.php" class="style35"></a></div></td>
              </tr>
            </table>
          </div></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Requests);

?>
