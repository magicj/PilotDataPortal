<?php require_once('../Connections/PGC.php'); ?>
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
	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	$insertSQL = sprintf("INSERT INTO pgc_request ( request_date) VALUES ( %s)",
						   
						   GetSQLValueString($_POST['date1'], "date"));
	
	  mysql_select_db($database_PGC, $PGC);
	  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
	  $_SESSION['MM_S_Message'] = "Record Saved - Enter Additional Or Exit";
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="../java/javascripts.js" type="text/javascript"></script>
<script src="../java/CalendarPopup.js" type="text/javascript"></script>
<script src="../java/zxml.js" type="text/javascript"></script>
<script src="../java/workingjs.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript" ID="js1">
		var cal = new CalendarPopup();
	 </SCRIPT>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Instruction Request</title>
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
.style31 {color: #000000}
.style32 {font-weight: bold; color: #000000; }
.style33 {font-size: 14px}
.style34 {
	color: #FFFF66;
	font-size: 16px;
}
.style36 {font-weight: bold; color: #A7B5CE; font-size: 14; }
.style37 {color: #F8BD6D}
.style38 {font-weight: bold; color: #6666FF; font-size: 14px; }
.style39 {color: #BAB3FF}
.style41 {font-size: 18px}
.style43 {font-size: 16px; }
-->
</style>
</head>
<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
  <tr>
    <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="398" bgcolor="#666666"><table width="900" height="481" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
        <tr>
          <td width="1562" height="40" bgcolor="#4F5359"><div align="center" class="style2">
              <table width="60%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><div align="center" class="style33">PGC STUDENT INSTRUCTION REQUEST</div></td>
                </tr>
              </table>
            </div></td>
        </tr>
        <tr>
          <td height="277" align="center" valign="top" bgcolor="#4F5359"><form action="<?php echo $editFormAction; ?>" method="post" name="new_flight" id="new_flight">
              <p><span class="style25 style34 style37"><?php echo "Requests only accepted for dates up to: " . $date_limit; ?>&nbsp;</span></p>
              <table width="380" align="center" cellpadding="5" cellspacing="2" bgcolor="#666666">
                <tr valign="baseline">
                  <td height="48" colspan="2" align="right" valign="middle" nowrap bgcolor="#6666FF" class="style25"><table width="380" border="0" cellpadding="2" cellspacing="2" bgcolor="#6666FF">
                      <tr>
                        <td width="214" height="30" valign="middle" bgcolor="#6666FF" class="style32"><div align="center" class="style43"><?php echo $_SESSION['MM_PilotName']; ?></div></td>
                        <td width="214" valign="middle" bgcolor="#6666FF" class="style32"><div align="center" class="style43"><?php echo $_SESSION['MM_Username']; ?></div></td>
                      </tr>
                    </table></td>
                </tr>
                <tr valign="baseline">
                  <td width="140" height="32" align="right" valign="middle" nowrap bgcolor="#6666FF" class="style25"><div align="left" class="style31">INSTRUCTION DATE: </div></td>
                  <td width="215" height="32" valign="middle" bgcolor="#6666FF"><div align="left">
                      <input type="text" name="date1" size="10" value="<?php echo "$date1" ?>" />
                      <a href="#"
					   name="anchor2" class="style32" id="anchor2" onclick="cal.select(document.forms['new_flight'].date1,'anchor2','yyyy-MM-dd'); return false;"> Calendar</a></div></td>
                </tr>
                <tr valign="baseline">
                  <td height="32" colspan="2" align="right" valign="middle" nowrap bgcolor="#6666FF"><div align="center">
                      <input type="submit" value="SAVE">
                    </div></td>
                </tr>
              </table>
              <span class="style36">
              <input type="hidden" name="MM_insert" value="form1" />
              </span>
            </form>
            <p class="style38 style39"><span class="style41"><?php echo $_SESSION['MM_S_Message']; ?></span>&nbsp;</p>
            </p></td>
        </tr>
        <tr>
          <td height="30" bgcolor="#4F5359" class="style16"><div align="center"><a href="pgc_request_list_member.php" class="style17">BACK TO MEMBER REQUEST LIST </a></div></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
