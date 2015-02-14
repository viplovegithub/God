<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?><?php 
/* EAM asset management tool: Graham Fisk - 2011 - http://BigSmallWeb.com */
session_start();
if(!session_is_registered("MM_Username")){
header("location:login.php");
} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<!-- Page titles are set per page with pageTitle variable -->
<title>BigSmallWeb - Enterprise Asset Management - <?php echo $pageTitle; ?> </title>

<!-- Fav icon silliness brought to use by Internut Exploder where it never seems to work -->
<link rel="shortcut icon" href="http://www.gfisk.com/eam/favicon.ico" type="image/x-icon" />
<link rel="icon" href="http://www.gfisk.com/eam/favicon.ico" type="image/x-icon" />

<!-- Global style sheet -->
<link href="includes/eam_main.css" rel="stylesheet" type="text/css" media="all" />

<!-- Enable to use SCW Calendar widget - http://www.garrett.nildram.co.uk/calendar/scw.htm
<script type='text/JavaScript' src='includes/scw.js'></script> 
-->

<!-- Calendar pop up - http://www.mattkruse.com/javascript/calendarpopup/source.html  -->
<script language="JavaScript" src="includes/CalendarPopup.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
	var cal = new CalendarPopup();
</script>

</head>
<body>

<!-- Main container box - change via width and padding via eam_main.css -->
<div id="container">

<!-- Header bar and logo -->
<div id="header"><a href="index.php" title=""><img src="images/corp_logo1.gif" alt="" /></a>  </div>

<!-- Navigation bar - change via eam_main.css -->
<div id="navcontainer">
  <ul id="navlist">
    <li><a href="index.php" title="">Home</a></li>
    <li><a href="#" title=""> - </a></li>     
    <li><a href="HardwareAdd.php" title="">Add Hardware</a></li>
    <li><a href="SoftwareAdd.php">Add Software</a></li>
	<li><a href="#" title="">- </a></li>
    <li><a href="search.php" title="">Search</a></li>         
    <li><a href="HardwareList.php" title="">View All Hardware</a></li>
    <li><a href="SoftwareList.php">View All Software</a></li>
    <li><a href="#" title="">- </a></li> 
    <li><a href="Admin.php" title="">Admin</a></li>    
    <li><a href="logout.php" title="">Logout</a></li>   
  </ul>
</div>

<!-- Main content box - change via /includes/eam_main.css -->
<div id="mainContent">