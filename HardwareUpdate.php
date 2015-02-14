<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2013 // 
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE assets_hardware SET asset_type=%s, vendor=%s, model=%s, serialnumber=%s, location=%s, date_purchase=%s, date_decomission=%s, status=%s, `user`=%s, division=%s, platform=%s, comments=%s, monitor_size=%s, warranty=%s, `cube`=%s, field_address=%s, user_account=%s, asset_tag=%s, purchase_order=%s WHERE asset_hardware_id=%s",
                       GetSQLValueString($_POST['asset_type'], "text"),
                       GetSQLValueString($_POST['vendor'], "text"),
                       GetSQLValueString($_POST['model'], "text"),
                       GetSQLValueString($_POST['serialnumber'], "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['date_purchase'], "text"),
                       GetSQLValueString($_POST['date_decomission'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['division'], "text"),
                       GetSQLValueString($_POST['platform'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['monitor_size'], "int"),
                       GetSQLValueString($_POST['warranty'], "text"),
                       GetSQLValueString($_POST['cube'], "text"),
                       GetSQLValueString($_POST['field_address'], "text"),
                       GetSQLValueString($_POST['user_account'], "text"),
                       GetSQLValueString($_POST['asset_tag'], "text"),
                       GetSQLValueString($_POST['purchase_order'], "text"),
                       GetSQLValueString($_POST['asset_hardware_id'], "int"));

  mysql_select_db($database_eam, $eam);
  $Result1 = mysql_query($updateSQL, $eam) or die(mysql_error());

  $updateGoTo = "HardwareList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsHardwareUpdate = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsHardwareUpdate = $_GET['recordID'];
}
mysql_select_db($database_eam, $eam);
$query_rsHardwareUpdate = sprintf("SELECT * FROM assets_hardware WHERE asset_hardware_id = %s", GetSQLValueString($colname_rsHardwareUpdate, "int"));
$rsHardwareUpdate = mysql_query($query_rsHardwareUpdate, $eam) or die(mysql_error());
$row_rsHardwareUpdate = mysql_fetch_assoc($rsHardwareUpdate);
$totalRows_rsHardwareUpdate = mysql_num_rows($rsHardwareUpdate);

mysql_select_db($database_eam, $eam);
$query_rsVendors = "SELECT * FROM vendors ORDER BY vendor ASC";
$rsVendors = mysql_query($query_rsVendors, $eam) or die(mysql_error());
$row_rsVendors = mysql_fetch_assoc($rsVendors);
$totalRows_rsVendors = mysql_num_rows($rsVendors);

mysql_select_db($database_eam, $eam);
$query_rsHardwarePlatform = "SELECT * FROM assets_hardware_platform ORDER BY platform ASC";
$rsHardwarePlatform = mysql_query($query_rsHardwarePlatform, $eam) or die(mysql_error());
$row_rsHardwarePlatform = mysql_fetch_assoc($rsHardwarePlatform);
$totalRows_rsHardwarePlatform = mysql_num_rows($rsHardwarePlatform);

mysql_select_db($database_eam, $eam);
$query_rsHardwareType = "SELECT * FROM assets_hardware_type ORDER BY assets_hardware_type ASC";
$rsHardwareType = mysql_query($query_rsHardwareType, $eam) or die(mysql_error());
$row_rsHardwareType = mysql_fetch_assoc($rsHardwareType);
$totalRows_rsHardwareType = mysql_num_rows($rsHardwareType);

mysql_select_db($database_eam, $eam);
$query_rsDivision = "SELECT * FROM division ORDER BY division ASC";
$rsDivision = mysql_query($query_rsDivision, $eam) or die(mysql_error());
$row_rsDivision = mysql_fetch_assoc($rsDivision);
$totalRows_rsDivision = mysql_num_rows($rsDivision);

mysql_select_db($database_eam, $eam);
$query_rsLocation = "SELECT * FROM location ORDER BY location ASC";
$rsLocation = mysql_query($query_rsLocation, $eam) or die(mysql_error());
$row_rsLocation = mysql_fetch_assoc($rsLocation);
$totalRows_rsLocation = mysql_num_rows($rsLocation);

mysql_select_db($database_eam, $eam);
$query_rsHardwareStatus = "SELECT * FROM assets_hardware_status ORDER BY assets_hardware_status ASC";
$rsHardwareStatus = mysql_query($query_rsHardwareStatus, $eam) or die(mysql_error());
$row_rsHardwareStatus = mysql_fetch_assoc($rsHardwareStatus);
$totalRows_rsHardwareStatus = mysql_num_rows($rsHardwareStatus);

mysql_select_db($database_eam, $eam);
$query_rsMonitorSize = "SELECT * FROM assets_hardware_monitor_size";
$rsMonitorSize = mysql_query($query_rsMonitorSize, $eam) or die(mysql_error());
$row_rsMonitorSize = mysql_fetch_assoc($rsMonitorSize);
$totalRows_rsMonitorSize = mysql_num_rows($rsMonitorSize);
?>
<?php $pageTitle="Update Hardware Asset"; ?>
<?php include('includes/header.php'); ?>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <fieldset>
      <legend>Hardware - Update</legend>
      <!--	<p>
	<label for="Asset Id ">Asset Id </label>
	<?php echo $row_rsHardwareUpdate['asset_hardware_id']; ?>
	</p> -->
      <p>
        <label for="Asset Type">Asset Type</label>
        <select name="asset_type">
          <?php 
		do {  
		?>
          <option value="<?php echo $row_rsHardwareType['assets_hardware_type']?>" <?php if (!(strcmp($row_rsHardwareType['assets_hardware_type'], $row_rsHardwareUpdate['asset_type']))) {echo "SELECTED";} ?>><?php echo $row_rsHardwareType['assets_hardware_type']?></option>
          <?php
} while ($row_rsHardwareType = mysql_fetch_assoc($rsHardwareType));
?>
        </select>
      </p>
	  
<!-- Conditional for Monitors -->	
	<?php if ($row_rsHardwareUpdate['asset_type'] == "Monitor") 
		{
		?> 	  
      <p>
        <label for="Monitor size">Monitor size</label>
        <select name="monitor_size">
          <option value="0" <?php if (!(strcmp(0, $row_rsHardwareUpdate['monitor_size']))) {echo "selected=\"selected\"";} ?>>None</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rsMonitorSize['size']?>"<?php if (!(strcmp($row_rsMonitorSize['size'], $row_rsHardwareUpdate['monitor_size']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsMonitorSize['size']?></option>
          <?php
} while ($row_rsMonitorSize = mysql_fetch_assoc($rsMonitorSize));
  $rows = mysql_num_rows($rsMonitorSize);
  if($rows > 0) {
      mysql_data_seek($rsMonitorSize, 0);
	  $row_rsMonitorSize = mysql_fetch_assoc($rsMonitorSize);
  }
?>
        </select>
        </p>
	<?php 
	  } 
	  ?>
		
      <p>
        <label for="Platform">Platform</label>
        <select name="platform">
          <?php 
do {  
?>
          <option value="<?php echo $row_rsHardwarePlatform['platform']?>" <?php if (!(strcmp($row_rsHardwarePlatform['platform'], $row_rsHardwareUpdate['platform']))) {echo "SELECTED";} ?>><?php echo $row_rsHardwarePlatform['platform']?></option>
          <?php
} while ($row_rsHardwarePlatform = mysql_fetch_assoc($rsHardwarePlatform));
?>
        </select>
      </p>
      <p>
        <label for="Vendor">Make</label>
        <select name="vendor">
          <?php 
do {  
?>
          <option value="<?php echo $row_rsVendors['vendor']?>" <?php if (!(strcmp($row_rsVendors['vendor'], $row_rsHardwareUpdate['vendor']))) {echo "SELECTED";} ?>><?php echo $row_rsVendors['vendor']?></option>
          <?php
} while ($row_rsVendors = mysql_fetch_assoc($rsVendors));
?>
        </select>
      </p>
      <p>
        <label for="Model">Model</label>
        <input name="model" type="text" value="<?php echo $row_rsHardwareUpdate['model']; ?>" size="8" maxlength="30" /> 
		<span class="tiny"> D610, GX620, MacPro, MBP...</span> 
      </p>
      <p>
        <label for="Serial number">Serial number</label>
        <input name="serialnumber" type="text" value="<?php echo $row_rsHardwareUpdate['serialnumber']; ?>" size="12" maxlength="30" />
      </p>
      <p>
        <label for="Asset Tag">Asset Tag</label>
        <input name="asset_tag" type="text" value="<?php echo $row_rsHardwareUpdate['asset_tag']; ?>" size="12" maxlength="30" />
      </p>
      <p>
        <label for="Asset Tag">Purchse Order</label>
        <input name="purchase_order" type="text" value="<?php echo $row_rsHardwareUpdate['purchase_order']; ?>" size="12" maxlength="30" />
      </p>           
      <hr />
      <p>
        <label for="Status">Status</label>
        <select name="status">
          <?php 
do {  
?>
          <option value="<?php echo $row_rsHardwareStatus['assets_hardware_status']?>" <?php if (!(strcmp($row_rsHardwareStatus['assets_hardware_status'], $row_rsHardwareUpdate['status']))) {echo "SELECTED";} ?>><?php echo $row_rsHardwareStatus['assets_hardware_status']?></option>
          <?php
} while ($row_rsHardwareStatus = mysql_fetch_assoc($rsHardwareStatus));
?>
        </select>
      </p>
      <p>
        <label for="Date purchased">Date purchased</label>
        <input type="text" name="date_purchase" value="<?php echo $row_rsHardwareUpdate['date_purchase']; ?>" size="8" />
        <img src='images/scw.gif' title='Click Here' alt='Click Here' onclick="cal.select(document.forms['form1'].date_purchase,'anchor2','MM/dd/yyyy'); return false;" name="anchor2" id="anchor2" style="cursor:hand" /> </p>
      <p>
        <label for="Warrant Date ">Warranty Date </label>
        <input type="text" name="warranty" value="<?php echo $row_rsHardwareUpdate['warranty']; ?>" size="8" />
        <img src='images/scw.gif' title='Click Here' alt='Click Here' onclick="cal.select(document.forms['form1'].warranty,'anchor1','MM/dd/yyyy'); return false;" name="anchor1" id="anchor1" style="cursor:hand" /> </p>
      <p>
        <label for="Division">Date decomissioned</label>
        <input type="text" name="date_decomission" value="<?php echo $row_rsHardwareUpdate['date_decomission']; ?>" size="8" />
        <img src='images/scw.gif' title='Click Here' alt='Click Here' onclick="cal.select(document.forms['form1'].date_decomission,'anchor3','MM/dd/yyyy'); return false;" name="anchor3" id="anchor3" style="cursor:hand" /> </p>
      <hr />
      <p>
        <label for="User">User</label>
        <input name="user" type="text" value="<?php echo $row_rsHardwareUpdate['user']; ?>" size="32" maxlength="50" />
        <span class="tiny">Full name</span> </p>
      <p>
        <label for="User">User Account</label>
        <input name="user_account" type="text" value="<?php echo $row_rsHardwareUpdate['user_account']; ?>" size="12" maxlength="12" />
        <span class="tiny">AD account</span> </p>
      <p>
        <label for="Division">Division</label>
        <select name="division">
          <?php 
do {  
?>
          <option value="<?php echo $row_rsDivision['division']?>" <?php if (!(strcmp($row_rsDivision['division'], $row_rsHardwareUpdate['division']))) {echo "SELECTED";} ?>><?php echo $row_rsDivision['division']?></option>
          <?php
} while ($row_rsDivision = mysql_fetch_assoc($rsDivision));
?>
        </select
	>
      </p>
      <p>
        <label for="Location">Location</label>
        <select name="location">
          <?php 
do {  
?>
          <option value="<?php echo $row_rsLocation['location']?>" <?php if (!(strcmp($row_rsLocation['location'], $row_rsHardwareUpdate['location']))) {echo "SELECTED";} ?>><?php echo $row_rsLocation['location']?></option>
          <?php
} while ($row_rsLocation = mysql_fetch_assoc($rsLocation));
?>
        </select>
      </p>
      <p>
        <label for="User">Cube</label>
        <input name="cube" type="text" value="<?php echo $row_rsHardwareUpdate['cube']; ?>" size="10" maxlength="10" />
      </p>
      <p>
        <label for="Division">Field Address</label>
        <textarea name="field_address" cols="20" rows="3" wrap="physical"><?php echo $row_rsHardwareUpdate['field_address']; ?></textarea>
        <span class="tiny">Field address + phone</span> </p>
      <p>
        <label for="Division">Comments</label>
        <textarea name="comments" cols="30" rows="3"><?php echo $row_rsHardwareUpdate['comments']; ?></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="Update record" />
      </p>
      </fieldset>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="asset_hardware_id" value="<?php echo $row_rsHardwareUpdate['asset_hardware_id']; ?>">
    </form>
    <?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsHardwareUpdate);

mysql_free_result($rsVendors);

mysql_free_result($rsHardwarePlatform);

mysql_free_result($rsHardwareType);

mysql_free_result($rsDivision);

mysql_free_result($rsLocation);

mysql_free_result($rsHardwareStatus);

mysql_free_result($rsMonitorSize);
?>
