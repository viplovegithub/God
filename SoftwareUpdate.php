<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE assets_software SET asset=%s, vendor=%s, version=%s, date_purchase=%s, license_type=%s, status=%s, `user`=%s, division=%s, comments=%s, platform=%s, location=%s, seats=%s WHERE asset_software_id=%s",
                       GetSQLValueString($_POST['asset'], "text"),
                       GetSQLValueString($_POST['vendor'], "text"),
                       GetSQLValueString($_POST['version'], "text"),
                       GetSQLValueString($_POST['date_purchase'], "text"),
                       GetSQLValueString($_POST['license_type'], "text"),
                       GetSQLValueString($_POST['status'], "int"),
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['division'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['platform'], "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['seats'], "int"),
                       GetSQLValueString($_POST['asset_software_id'], "int"));

  mysql_select_db($database_eam, $eam);
  $Result1 = mysql_query($updateSQL, $eam) or die(mysql_error());

  $updateGoTo = "SoftwareList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsSoftwareUpdate = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsSoftwareUpdate = (get_magic_quotes_gpc()) ? $_GET['recordID'] : addslashes($_GET['recordID']);
}
mysql_select_db($database_eam, $eam);
$query_rsSoftwareUpdate = sprintf("SELECT * FROM assets_software WHERE asset_software_id = %s", $colname_rsSoftwareUpdate);
$rsSoftwareUpdate = mysql_query($query_rsSoftwareUpdate, $eam) or die(mysql_error());
$row_rsSoftwareUpdate = mysql_fetch_assoc($rsSoftwareUpdate);
$totalRows_rsSoftwareUpdate = mysql_num_rows($rsSoftwareUpdate);

mysql_select_db($database_eam, $eam);
$query_rsVendors = "SELECT * FROM vendors_software";
$rsVendors = mysql_query($query_rsVendors, $eam) or die(mysql_error());
$row_rsVendors = mysql_fetch_assoc($rsVendors);
$totalRows_rsVendors = mysql_num_rows($rsVendors);

mysql_select_db($database_eam, $eam);
$query_rsLocation = "SELECT * FROM location";
$rsLocation = mysql_query($query_rsLocation, $eam) or die(mysql_error());
$row_rsLocation = mysql_fetch_assoc($rsLocation);
$totalRows_rsLocation = mysql_num_rows($rsLocation);

mysql_select_db($database_eam, $eam);
$query_rsDivision = "SELECT * FROM division";
$rsDivision = mysql_query($query_rsDivision, $eam) or die(mysql_error());
$row_rsDivision = mysql_fetch_assoc($rsDivision);
$totalRows_rsDivision = mysql_num_rows($rsDivision);

mysql_select_db($database_eam, $eam);
$query_rsSoftwarePlatform = "SELECT * FROM assets_software_platform";
$rsSoftwarePlatform = mysql_query($query_rsSoftwarePlatform, $eam) or die(mysql_error());
$row_rsSoftwarePlatform = mysql_fetch_assoc($rsSoftwarePlatform);
$totalRows_rsSoftwarePlatform = mysql_num_rows($rsSoftwarePlatform);

mysql_select_db($database_eam, $eam);
$query_rsSoftwareLicense = "SELECT * FROM assets_software_license";
$rsSoftwareLicense = mysql_query($query_rsSoftwareLicense, $eam) or die(mysql_error());
$row_rsSoftwareLicense = mysql_fetch_assoc($rsSoftwareLicense);
$totalRows_rsSoftwareLicense = mysql_num_rows($rsSoftwareLicense);
 
$pageTitle="Update Software Asset"; ?>
<?php include('includes/header.php'); ?>	
  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <fieldset>
     <legend>Software Update</legend>	
    <p>
      <label for="Asset Id">Asset Id</label>
      <?php echo $row_rsSoftwareUpdate['asset_software_id']; ?>
    </p>
	 <p>
      <label for="Software Name">Software Name</label>
      <input type="text" name="asset" value="<?php echo $row_rsSoftwareUpdate['asset']; ?>" size="32">
    </p>
	 <p>
      <label for="Version">Version</label>
      <input type="text" name="version" value="<?php echo $row_rsSoftwareUpdate['version']; ?>" size="32" />
    </p>
	 <p>
      <label for="Platform">Platform</label>
      <select name="platform">
            <?php 
do {  
?>
            <option value="<?php echo $row_rsSoftwarePlatform['assets_software_type']?>" <?php if (!(strcmp($row_rsSoftwarePlatform['assets_software_type'], $row_rsSoftwareUpdate['platform']))) {echo "SELECTED";} ?>><?php echo $row_rsSoftwarePlatform['assets_software_type']?></option>
            <?php
} while ($row_rsSoftwarePlatform = mysql_fetch_assoc($rsSoftwarePlatform));
?>
        </select>
    </p>
	 <p>
      <label for="Vendor">Vendor</label>
	  <select name="vendor">
		<?php 
do {  
?>
		<option value="<?php echo $row_rsVendors['vendor']?>" <?php if (!(strcmp($row_rsVendors['vendor'], $row_rsSoftwareUpdate['vendor']))) {echo "SELECTED";} ?>><?php echo $row_rsVendors['vendor']?></option>
		<?php
} while ($row_rsVendors = mysql_fetch_assoc($rsVendors));
?>
	  </select>
    </p>
	 <p>
      <label for="License type">License type</label>
	  <select name="license_type">
		<?php 
do {  
?>
		<option value="<?php echo $row_rsSoftwareLicense['assets_software_license']?>" <?php if (!(strcmp($row_rsSoftwareLicense['assets_software_license'], $row_rsSoftwareUpdate['license_type']))) {echo "SELECTED";} ?>><?php echo $row_rsSoftwareLicense['assets_software_license']?></option>
		<?php
} while ($row_rsSoftwareLicense = mysql_fetch_assoc($rsSoftwareLicense));
?>
	  </select>
    </p>
	 <p>
      <label for="Seats #">Seats #</label>
      <input type="text" name="seats" value="<?php echo $row_rsSoftwareUpdate['seats']; ?>" size="10" />
    </p>
	 <p>
      <label for="Date purchased">Date purchased</label>
      <input type="text" name="date_purchase" value="<?php echo $row_rsSoftwareUpdate['date_purchase']; ?>" size="8">
		<img src='images/scw.gif' title='Click Here' alt='Click Here'onclick="cal.select(document.forms['form1'].date_purchase,'anchor3','MM/dd/yyyy'); return false;" name="anchor3" id="anchor3" style="cursor:hand" />

    </p>
	
	<hr />
	
	 <p>
      <label for="Status">Status</label>
      <input type="text" name="status" value="<?php echo $row_rsSoftwareUpdate['status']; ?>" size="32">
    </p>
	 <p>
      <label for="User / Owner">User / Owner</label>
      <input type="text" name="user" value="<?php echo $row_rsSoftwareUpdate['user']; ?>" size="32">
    </p>
	 <p>
      <label for="Location">Location</label>
      <select name="location">
            <?php 
do {  
?>
            <option value="<?php echo $row_rsLocation['location']?>" <?php if (!(strcmp($row_rsLocation['location'], $row_rsSoftwareUpdate['location']))) {echo "SELECTED";} ?>><?php echo $row_rsLocation['location']?></option>
            <?php
} while ($row_rsLocation = mysql_fetch_assoc($rsLocation));
?>
       </select>
    </p>
	 <p>
      <label for="Division">Division</label>
      <select name="division">
            <?php 
do {  
?>
            <option value="<?php echo $row_rsDivision['division']?>" <?php if (!(strcmp($row_rsDivision['division'], $row_rsSoftwareUpdate['division']))) {echo "SELECTED";} ?>><?php echo $row_rsDivision['division']?></option>
            <?php
} while ($row_rsDivision = mysql_fetch_assoc($rsDivision));
?>
      </select>
    </p>
	 <p>
      <label for="Model">Comments</label>
      <textarea name="comments" cols="30" rows="3"><?php echo $row_rsSoftwareUpdate['comments']; ?></textarea>
    </p>
    <p class="submit">
 
	  <input type="submit" value="Update record" />
    </p>
    </fieldset>  

    <input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="asset_software_id" value="<?php echo $row_rsSoftwareUpdate['asset_software_id']; ?>">
  </form>
  <?php include('includes/footer.php'); ?><?php
mysql_free_result($rsSoftwareUpdate);

mysql_free_result($rsVendors);

mysql_free_result($rsLocation);

mysql_free_result($rsDivision);

mysql_free_result($rsSoftwarePlatform);

mysql_free_result($rsSoftwareLicense);
?>
