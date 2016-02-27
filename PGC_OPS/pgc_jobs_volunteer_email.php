<?php
 $test_to = "kilokilo@verizon.net, klausesser10@gmail.com, klausall@comcast.net";
 $to = $JobMemberEmail . ", ". $JobSponsorEmail .", " . $JobLeaderEmail . ", " . "kilokilo@verizon.net, klausesser10@gmail.com, klausall@comcast.net";
 $subject = "Thanks for Volunteering !";
 $from = "PGCPDP@noreply.com";
 $headers = "From: $from";
 
 $name = $JobMemberName;
 list($Mlname, $Mfname) = split(',', $name,2);
 
 $name = $JobLeader;
 list($Llname, $Lfname) = split(',', $name,2);  
 
 $name = $JobSponsor;
 list($Slname, $Sfname) = split(',', $name,2);  

 $emaillog =  $Mfname . ' '. $Mlname . "\n\n"; 
 
 $emaillog .= "Thanks for volunteering for this PGC Project.  The project leader has also received". "\n"; 
 $emaillog .= "an email to let him / her know that you volunteered.  If you don't hear from the". "\n"; 
 $emaillog .= "project leader soon, feel free to contact them to coordinate efforts.". "\n\n"; 
 $emaillog .= "Also, please feel free to start on this project if you're ready to go.  We don't want". "\n"; 
 $emaillog .= "to stop or slow your progress - simply use the Volunteer app to email progress or issues to the". "\n"; 
 $emaillog .= "leader.". "\n\n"; 
	
 $emaillog .= "Thanks again,". "\n\n"; 
 $emaillog .= "PGC Board of Directors". "\n\n"; 
 $emaillog .= "-----------------------------------------------------------------------------------". "\n\n";
 
 $emaillog .= "Project Name   : " . $JobName . "\n"; 
 $emaillog .= "Project Leader : " . $Lfname . ' '. $Llname . "\n"; 
 $emaillog .= "Project Sponsor: " . $Sfname . ' '. $Slname . "\n\n"; 
 
 $emaillog .= "Project Email List: " . $Prodto . "\n\n";
 
 mail($to,$subject,$emaillog,$headers); 
?>
