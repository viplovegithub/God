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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO assets_software (asset, vendor, version, date_purchase, license_type, status, `user`, division, comments, platform, location) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
                       GetSQLValueString($_POST['location'], "text"));

  mysql_select_db($database_eam, $eam);
  $Result1 = mysql_query($insertSQL, $eam) or die(mysql_error());

  $insertGoTo = "SoftwareList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_eam, $eam);
$query_rsSoftwareLicenseType = "SELECT * FROM assets_software_license";
$rsSoftwareLicenseType = mysql_query($query_rsSoftwareLicenseType, $eam) or die(mysql_error());
$row_rsSoftwareLicenseType = mysql_fetch_assoc($rsSoftwareLicenseType);
$totalRows_rsSoftwareLicenseType = mysql_num_rows($rsSoftwareLicenseType);

mysql_select_db($database_eam, $eam);
$query_rsSoftwareVendors = "SELECT * FROM vendors_software";
$rsSoftwareVendors = mysql_query($query_rsSoftwareVendors, $eam) or die(mysql_error());
$row_rsSoftwareVendors = mysql_fetch_assoc($rsSoftwareVendors);
$totalRows_rsSoftwareVendors = mysql_num_rows($rsSoftwareVendors);

mysql_select_db($database_eam, $eam);
$query_rsDivision = "SELECT * FROM division";
$rsDivision = mysql_query($query_rsDivision, $eam) or die(mysql_error());
$row_rsDivision = mysql_fetch_assoc($rsDivision);
$totalRows_rsDivision = mysql_num_rows($rsDivision);

mysql_select_db($database_eam, $eam);
$query_rsLocation = "SELECT * FROM location";
$rsLocation = mysql_query($query_rsLocation, $eam) or die(mysql_error());
$row_rsLocation = mysql_fetch_assoc($rsLocation);
$totalRows_rsLocation = mysql_num_rows($rsLocation);

mysql_select_db($database_eam, $eam);
$query_rsSoftwarePlatform = "SELECT * FROM assets_software_platform";
$rsSoftwarePlatform = mysql_query($query_rsSoftwarePlatform, $eam) or die(mysql_error());
$row_rsSoftwarePlatform = mysql_fetch_assoc($rsSoftwarePlatform);
$totalRows_rsSoftwarePlatform = mysql_num_rows($rsSoftwarePlatform);
 ?>
<?php $pageTitle="Add Software";  ?>
<?php include('includes/header.php'); ?>

    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <fieldset>
      <legend> Add Software</legend>
      <p>
        <label for="Software Name">Software Name</label>
        <input name="asset" type="text" size="32" maxlength="100" />
      </p>
      <p>
        <label for="Version">Version</label>
        <input name="version" type="text" size="10" maxlength="20" />
      </p>
      <p>
        <label for="Platform">Platform</label>
        <select name="platform">
          <option value="">Choose</option>
          <?php
			do {  
			?>
					  <option value="<?php echo $row_rsSoftwarePlatform['assets_software_type']?>"><?php echo $row_rsSoftwarePlatform['assets_software_type']?></option>
					  <?php
			} while ($row_rsSoftwarePlatform = mysql_fetch_assoc($rsSoftwarePlatform));
			  $rows = mysql_num_rows($rsSoftwarePlatform);
			  if($rows > 0) {
				  mysql_data_seek($rsSoftwarePlatform, 0);
				  $row_rsSoftwarePlatform = mysql_fetch_assoc($rsSoftwarePlatform);
			  }
			?>
        </select>
      </p>
      <p>
        <label for="Vendor">Vendor</label>
        <select name="vendor">
          <option value="">Choose</option>
          <?php
			do {  
			?>
			<option value="<?php echo $row_rsSoftwareVendors['vendor']?>"><?php echo $row_rsSoftwareVendors['vendor']?></option>
					  <?php
			} while ($row_rsSoftwareVendors = mysql_fetch_assoc($rsSoftwareVendors));
			  $rows = mysql_num_rows($rsSoftwareVendors);
			  if($rows > 0) {
				  mysql_data_seek($rsSoftwareVendors, 0);
				  $row_rsSoftwareVendors = mysql_fetch_assoc($rsSoftwareVendors);
			  }
			?>
        </select>
      </p>
      <p>
        <label for="License type">License type</label>
        <select name="license_type">
          <option value="">Choose</option>
          <?php
			do {  
			?>
			<option value="<?php echo $row_rsSoftwareLicenseType['assets_software_license']?>"><?php echo $row_rsSoftwareLicenseType['assets_software_license']?></option>
					  <?php
			} while ($row_rsSoftwareLicenseType = mysql_fetch_assoc($rsSoftwareLicenseType));
			  $rows = mysql_num_rows($rsSoftwareLicenseType);
			  if($rows > 0) {
				  mysql_data_seek($rsSoftwareLicenseType, 0);
				  $row_rsSoftwareLicenseType = mysql_fetch_assoc($rsSoftwareLicenseType);
			  }
			?>
        </select>
      </p>
      <p>
        <label for="Seats #">Seats #</label>
        <input name="seats" type="text" size="10" maxlength="12" />
      </p>
      <p>
        <label for="Date purchased">Date purchased</label>

        <input type="text" name="date_purchase" value="" size="8" />
        <img src='images/scw.gif' title='Click Here' alt='Click Here' onclick="cal.select(document.forms['form1'].date_purchase,'anchor2','MM/dd/yyyy'); return false;" name="anchor2" id="anchor2" style="cursor:hand" />		
		<hr />
      <p>
        <label for="Status">Status</label>
        <input name="status" type="text" size="32" maxlength="50" />
      </p>
      <p>
        <label for="User / Owner">User / Owner </label>
        <input name="user" type="text" size="32" maxlength="50" />
      </p>
      <p>
        <label for="Division">Division</label>
        <select name="division">
          <option value="">Choose</option>
          <?php
			do {  
			?>
			<option value="<?php echo $row_rsDivision['division']?>"><?php echo $row_rsDivision['division']?></option>
			<?php
			} while ($row_rsDivision = mysql_fetch_assoc($rsDivision));
			  $rows = mysql_num_rows($rsDivision);
			  if($rows > 0) {
				  mysql_data_seek($rsDivision, 0);
				  $row_rsDivision = mysql_fetch_assoc($rsDivision);
			  }
			?>
        </select>
      </p>
      <p>
        <label for="Location">Location</label>
        <select name="location">
          <option value="">Choose</option>
          <?php
			do {  
			?>
          <option value="<?php echo $row_rsLocation['location']?>"><?php echo $row_rsLocation['location']?></option>
          <?php
			} while ($row_rsLocation = mysql_fetch_assoc($rsLocation));
			  $rows = mysql_num_rows($rsLocation);
			  if($rows > 0) {
				  mysql_data_seek($rsLocation, 0);
				  $row_rsLocation = mysql_fetch_assoc($rsLocation);
			  }
			?>
        </select>
      </p>
      <p>
        <label for="Status">Comments</label>
        <textarea name="comments" cols="30"></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="Insert record">
      </p>
      </fieldset>
      <input type="hidden" name="MM_insert" value="form1">
    </form>
   
<?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsSoftwareLicenseType);
mysql_free_result($rsSoftwareVendors);
mysql_free_result($rsDivision);
mysql_free_result($rsLocation);
mysql_free_result($rsSoftwarePlatform);
?>
