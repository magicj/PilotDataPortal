<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal</title>
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
.style16 {
	color: #FFFFFF;
	font-size: 16px;
}
a:link {
	color: #E6E3DF;
}
a:visited {
	color: #E6E3DF;
}
a:active {
	color: #FFFFCC;
}
.style19 {color: #CCCCCC; font-style: italic; font-weight: bold; }
.style20 {	font-size: 16px;
	font-weight: bold;
	color: #FFCCCC;
}
.style24 {
	font-size: 16px;
	font-weight: bold;
	color: #FFFFFF;
}
.style28 {font-size: 12px}
.style23 {font-size: 16px; font-weight: bold; color: #FFCCCC; font-style: italic; }
.style44 {color: #999999;
	font-weight: bold;
}
.style32 {font-weight: bold; color: #000000; }
.style43 {font-size: 16px; }
#form1 table tr .style20
{
	color: #FFF;
}
-->
</style></head>

<body>
<p>&nbsp;</p>
<table width="800" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td width="1002"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="190" bgcolor="#3E3E5E"><table width="99%" height="186" border="0" align="center" cellpadding="5" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="25"><div align="center">
            <table width="99%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                      <td bgcolor="#333366"><div align="center"><span class="style24">FIELD DUTY - SETUP DIRECTIONS</span></div></td>
                </tr>
                </table>
            </div></td>
      </tr>
      
      <tr>
        <td height="108" align="center" valign="top"><table width="725" border="1" align="center" cellpadding="5" cellspacing="2" bgcolor="#6666FF">
              <tr>
                          <td width="381" height="470" valign="middle" bgcolor="#273F61" class="style32"><p class="style24">1. Make a backup - then clear the pgc_field_duty table. </p>
<p class="style24">2. Make a backup - then clear the pgc_field_duty_selections table.</p>
                                <p class="style24">3. Make a backup - then clear the pgc_field_duty_selections_audit table.</p>
                                <p class="style24">These steps prepare the system for start of season activity. (An app will be developed to perform these tasks.)</p>
                                <p class="style24">4. Perform Admin - Field Duty Role functions to identify the FM and AFM populations.</p>
                                <p class="style24">5. Perform Admin - Session Control Setup. Enter session dates and turn all sessions to inactive status.</p>
<p class="style24">6. Perform - Admin Generate Weekend FD Dates ... this populates the pgc_field_duty table with weekend and holidy duty dates for each session identified in the control table. This table is the master data source for  field duty assignments for all roles (fm, afm, tp and cfig) ... and it is read by other apps to identify season duty days. Never clear this table once the season is setup and starts.</p>
                                <p class="style24">7. Perform - Admin Refresh FD Selection Table - this populates the pgc_field_duty_selections table with empty FM and AFM records for all session dates in the pgc_field_duty table for all FM and AFM members based on their roles.  Running this during the season will insert new active members - it will not delete members who have gone inactive.</p>
                                <p class="style24">8. Perform Admin - Session Control Setup and turn Session 1 to Active Status ... this allows the members to select Session 1 Dates using the Member - Session Date Selection App.</p>
                                <p class="style24">9. Close the active  session to prevent additional member changes and uses the Admin - Member Selection View to assign final duty dates for the FMs and AFMs.  Try to give everyone their first choices ... 1, 2, or 3 in that order. The app will count the times a date is assigned ... so you can see if you have assigned a date more then three times in a session for AFMs ... or more than once for the FMs. If all of the member choices are filled - you can OVERride the member choices  and assign any date in the session.</p>
                                <p class="style24">10. Print out excel copies of the member selections to keep an external record of the data - if required. This is basically the worksheet Bill Hamilton prepared and used for field duty setup and  control process. </p>
                                <p class="style24">11. When you have completed all assignments for the session ... transfer the final selections for the session to the pgc_field_duty table. (Do this manually - as the app still has to be  developed. ) Make a backup copy of the table.</p>
                                <p class="style24">12. For the next session - perform all steps starting at step 4.</p>
                                <p class="style24">13. The old field duty apps that update the pgc_field_duty table can be used to directly edit that table - which displays in the member section and on the main page. Backup  the pgc_field _duty_table often as it is the master schedule for all sessions.</p>
                                <p class="style24">12/8/2014 ... this is still a work in progress - everything developed so far seems to work ... kk</p></td>
                    </tr>
  </table>
              <p class="style16">&nbsp;</p> </td>
      </tr>
      <tr>
        <td height="33"><div align="center" class="style20">
            <p><a href="pgc_fd_menu.php" class="style16">BACK TO FD MENU</a></p>
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
 
