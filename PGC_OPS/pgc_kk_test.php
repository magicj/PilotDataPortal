<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PGC TEST TEMPLATE - KK</title>
<style type="text/css">
<!--

/* ~~the header is not given a width. It will extend the full width of your layout. It contains an image placeholder that should be replaced with your own linked logo~~ */
.header {
	background-color: #0066CC;
	color: #FFF;
	font-size: 300%;
	font-family: Arial, Helvetica, sans-serif;
	font-style: italic;
	padding: 0px;
	background-image: url(../KenTest/Gradient3.jpg);
	background-repeat: repeat;
	height: 100px;
	background-position: left;
}
body {
	font: 100%/1.4 Verdana, Arial, Helvetica, sans-serif;
	background: #4E5869;
	margin: 0;
	padding: 0;
	color: #000;
	background-color: #FFFFFF;
}

.centerphoto {
    display: block;
    margin-left: auto;
    margin-right: auto }
/* ~~ Element/tag selectors ~~ */
ul, ol, dl { /* Due to variations between browsers, it's best practices to zero padding and margin on lists. For consistency, you can either specify the amounts you want here, or on the list items (LI, DT, DD) they contain. Remember that what you do here will cascade to the .nav list unless you write a more specific selector. */
	padding: 0;
	margin: 0;
}
h1, h2, h3, h4, h5, h6, p {
	margin-top: 0;	 /* removing the top margin gets around an issue where margins can escape from their containing div. The remaining bottom margin will hold it away from any elements that follow. */
	padding-right: 15px;
	padding-left: 15px; /* adding the padding to the sides of the elements within the divs, instead of the divs themselves, gets rid of any box model math. A nested div with side padding can also be used as an alternate method. */
}
a img { /* this selector removes the default blue border displayed in some browsers around an image when it is surrounded by a link */
	border: none;
}

/* ~~ Styling for your site's links must remain in this order - including the group of selectors that create the hover effect. ~~ */
a:link {
	color:#414958;
	text-decoration: underline; /* unless you style your links to look extremely unique, it's best to provide underlines for quick visual identification */
}
a:visited {
	color: #4E5869;
	text-decoration: underline;
}
a:hover, a:active, a:focus { /* this group of selectors will give a keyboard navigator the same hover experience as the person using a mouse. */
	text-decoration: none;
}

/* ~~ this container surrounds all other divs giving them their percentage-based width ~~ */
.container {
	width: 80%;
	max-width: 1260px;/* a max-width may be desirable to keep this layout from getting too wide on a large monitor. This keeps line length more readable. IE6 does not respect this declaration. */
	min-width: 780px;/* a min-width may be desirable to keep this layout from getting too narrow. This keeps line length more readable in the side columns. IE6 does not respect this declaration. */
	background: #FFF;
	margin: 0 auto; /* the auto value on the sides, coupled with the width, centers the layout. It is not needed if you set the .container's width to 100%. */
}

/* ~~ These are the columns for the layout. ~~ 

1) Padding is only placed on the top and/or bottom of the divs. The elements within these divs have padding on their sides. This saves you from any "box model math". Keep in mind, if you add any side padding or border to the div itself, it will be added to the width you define to create the *total* width. You may also choose to remove the padding on the element in the div and place a second div within it with no width and the padding necessary for your design.

2) No margin has been given to the columns since they are all floated. If you must add margin, avoid placing it on the side you're floating toward (for example: a right margin on a div set to float right). Many times, padding can be used instead. For divs where this rule must be broken, you should add a "display:inline" declaration to the div's rule to tame a bug where some versions of Internet Explorer double the margin.

3) Since classes can be used multiple times in a document (and an element can also have multiple classes applied), the columns have been assigned class names instead of IDs. For example, two sidebar divs could be stacked if necessary. These can very easily be changed to IDs if that's your preference, as long as you'll only be using them once per document.

4) If you prefer your nav on the left instead of the right, simply float these columns the opposite direction (all left instead of all right) and they'll render in reverse order. There's no need to move the divs around in the HTML source.

*/
.sidebar1 {
	float: right;
	width: 30%;
	padding-bottom: 10px;
	background-color: #FFFFFF;
}
.content {
	width: 70%;
	float: right;
	padding-top: 10px;
	padding-right: 0;
	padding-bottom: 10px;
	padding-left: 0;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 100;
}

/* ~~ This grouped selector gives the lists in the .content area space ~~ */
.content ul, .content ol { 
	padding: 0 15px 15px 40px; /* this padding mirrors the right padding in the headings and paragraph rule above. Padding was placed on the bottom for space between other elements on the lists and on the left to create the indention. These may be adjusted as you wish. */
}

/* ~~ The navigation list styles (can be removed if you choose to use a premade flyout menu like Spry) ~~ */
ul.nav {
	list-style: none; /* this removes the list marker */
	border-top: 1px solid #666; /* this creates the top border for the links - all others are placed using a bottom border on the LI */
	margin-bottom: 15px; /* this creates the space between the navigation on the content below */
}
ul.nav li {
	border-bottom: 1px solid #666; /* this creates the button separation */
}
ul.nav a, ul.nav a:visited { /* grouping these selectors makes sure that your links retain their button look even after being visited */
	padding: 5px 5px 5px 15px;
	display: block; /* this gives the link block properties causing it to fill the whole LI containing it. This causes the entire area to react to a mouse click. */
	text-decoration: none;
	background: #8090AB;
	color: #000;
}
ul.nav a:hover, ul.nav a:active, ul.nav a:focus { /* this changes the background and text color for both mouse and keyboard navigators */
	background: #6F7D94;
	color: #FFF;
}

/* ~~ The footer ~~ */
.footer {
	padding: 4px;
	position: relative;/* this gives IE6 hasLayout to properly clear */
	clear: both; /* this clear property forces the .container to understand where the columns end and contain them */
	background-color: #6F93FF;
	background-image: url(../KenTest/GradientFooter.jpg);
	font-family: Arial, Helvetica, sans-serif;
	font-size: 100%;
	color: #CCC;
}
.footertext {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
}

/* ~~ miscellaneous float/clear classes ~~ */
.fltrt {  /* this class can be used to float an element right in your page. The floated element must precede the element it should be next to on the page. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* this class can be used to float an element left in your page. The floated element must precede the element it should be next to on the page. */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* this class can be placed on a <br /> or empty div as the final element following the last floated div (within the #container) if the #footer is removed or taken out of the #container */
	clear:both;
	height:0;
	font-size: 1px;
	line-height: 0px;
}
.header1 {	background-color: #0066CC;
	color: #FFF;
	font-size: 300%;
	font-family: Arial, Helvetica, sans-serif;
	font-style: italic;
	padding: 5px;
	background-image: url(file:///E|/Programs/xampp/htdocs/KenTest/Gradient.jpg);
	background-repeat: repeat;
}
-->
</style><!--[if lte IE 7]>
<style>
.content { margin-right: -1px; } /* this 1px negative margin can be placed on any of the columns in this layout with the same corrective effect. */
ul.nav a { zoom: 1; }  /* the zoom property gives IE the hasLayout trigger it needs to correct extra whiltespace between the links */
</style>
<![endif]-->
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.style279 {color: #CCCCCC; font-size: 10pt; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
.style297 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #FFFFCC; font-weight: bold; }
.style313 {font-size: 14px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;}
</style>
</head>

<body>

<div class="container">
  <div class="header"></div>
  <div class="sidebar1">
    <p>&nbsp;</p>
    <p><img src="../2013/Banquet/PGCbanquet2.jpg" alt="NASA" width="200" height="134" class="centerphoto" /> </p>
    <p><a href="../07_Album_Menu.html"><img src="../2012/WomansDayPGC/WomensDayBanner copy.jpg" alt="WD" width="200" height="179" class="centerphoto" /></a></p>
       <p>&nbsp;</p>
       <div id="webview"  align="center"><a href="http://www.pgcsoaring.org/webcam/pgc_00001.jpg"
				target="_blank" onclick="loadMovie(this.parentNode.id,this.href,'320','272');
				return false"><img src="http://www.pgcsoaring.org/webcam/pgc_00001.jpg" alt="Click to Play"  width="200" height="200" border="0" id="campicture"/></a></div>
       <p>&nbsp;</p>
  <!-- end .sidebar1 --></div>
  <div class="content">
    <ul id="MenuBar1" class="MenuBarHorizontal">
      <li><a class="MenuBarItemSubmenu" href="#">History</a>
        <ul>
          <li><a href="#">Club History</a></li>
          <li><a href="#">Lew Hull</a></li>
</ul>
      </li>
      <li><a href="#">Join PGC</a></li>
      <li><a class="MenuBarItemSubmenu" href="#">Training</a>
        <ul>
          <li><a class="MenuBarItemSubmenu" href="#">Basic Instruction</a>
            <ul>
              <li><a href="#">Item 3.1.1</a></li>
              <li><a href="#">Item 3.1.2</a></li>
            </ul>
          </li>
          <li><a href="#">Advanced XC</a></li>
</ul>
      </li>
      <li><a href="#" class="MenuBarItemSubmenu">Aircraft</a>
        <ul>
          <li><a href="#">Duo Discus</a></li>
          <li><a href="#">Grob 103</a></li>
        </ul>
      </li>
    </ul>
    <h1>&nbsp;</h1>
    <p align="justify" ><img src="../Photos/HP1.jpg" alt="PGC sign" width="155" height="116" hspace="7" vspace="0" border="0" align="left" /></span>The Philadelphia Glider Council (PGC) is one of the premier soaring clubs in North America. Founded in 1941, this unique aviation organization is located just north of the Philadelphia metro area in <a href="../07_Location.html">Hilltown</a>, Pennsylvania - serving glider pilots and the general public in the surrounding tri-state region.</p>
    <p align="justify" >PGC members range from beginning students to highly experienced glider pilots; and our soaring activities vary to meet the needs of individual pilots – From basic flight training to post-license training, just-for-fun local flying, and high performance cross-country soaring and competitive flying.</p>
    <p align="justify" >Inexpensive student flight training is a central part of the PGC mission -  all student instruction and equipment usage is free - students just pay yearly membership dues and tow fees. Each season, PGC's dedicated cadre of instructors provides basic flight instruction for a new group of student pilots. When their training is complete these students take the required FAA tests and earn their wings! Younger students are also eligible for PGC's Youth <a href="../Forms/Youth Scholarship Application - 2012.pdf">Scholarship</a> Program that subsidizes a portion of membership and flight costs. </p>
    <p align="justify" > In addition to basic training, PGC also hosts advanced cross-country soaring camps conducted by national and world soaring champions. PGC racing pilots also participate in <a href="http://www.ssa.org/" >SSA</a> regional and national championships,  the inter-club <a href="http://www.pgcsoaring.org/PGC_OPS/gc_home.php" >Governor's Cup</a> competition, and the world On-Line Contest (<a href="http://www.onlinecontest.org/olc-2.0/gliding/getScoring.html?clubId=3509&amp;scoringId=201">OLC</a>). </p>
    <p align="left">PGC owns the 138 acre turf airport, eight modern   sailplanes for basic and advanced training, two towplanes, a two-drum winch,   hangers for equipment, club house a with flight simulator training facilities,   and a picnic and play area for visiting family members.</p>
    <p align="justify">Flight operations are scheduled on weekends and   some weekdays (depending on weather) between April and October. We also operate   on select days throughout the winter as conditions allow. Check our live webcams to watch flightline   operations or verify flight activity if you want to visit and join the fun.</p>
<p align="justify">PGC offers Aeronautical   Orientation Flights for those who would like to experience the thrill of   soaring or who have thought about becoming a pilot. See the contact information   to the right, or click on the <a href="07_learn.html">Learn To Fly</a> PGC menu   to inquire about an aeronautical orientation flight or <a href="07_join.html">Join</a> for club membership.</p>
    <p align="justify">For insight into the sights and sounds of glider   flight watch the <a href="vidio clips/grob_103.wmv">Soaring Video</a> (may   require a high speed connection). Please come visit and watch the beauty of   gliders in flight, take an Aeronautical Orientation Flight, or buy a Gift   Certificate and treat a special someone to a great aviation experience.<span class="footertext">eee.e.</span></p>
    <p>&nbsp;</p>
    <p align="justify" >&nbsp;</p>
    <p align="justify" >&nbsp; </p>
    <p align="justify" class="style279">&nbsp;</p>
  <!-- end .content --></div>
  <div class="footer">
    <p class="footertext">Copyright PGC 2013. All rights reserved.</p>
  </div>
<!-- end .container --></div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>