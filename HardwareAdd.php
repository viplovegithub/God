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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO assets_hardware (asset_type, vendor, model, serialnumber, location, date_purchase, status, `user`, division, platform, comments, monitor_size, warranty, `cube`, field_address, user_account, asset_tag, purchase_order) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['assets_hardware_type'], "text"),
                       GetSQLValueString($_POST['vendor'], "text"),
                       GetSQLValueString($_POST['model'], "text"),
                       GetSQLValueString($_POST['serialnumber'], "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['date_purchase'], "date"),
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
                       GetSQLValueString($_POST['purchase_order'], "text"));

  mysql_select_db($database_eam, $eam);
  $Result1 = mysql_query($insertSQL, $eam) or die(mysql_error());

  $insertGoTo = "HardwareList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_eam, $eam);
$query_rsVendors = "SELECT * FROM vendors ORDER BY vendor ASC";
$rsVendors = mysql_query($query_rsVendors, $eam) or die(mysql_error());
$row_rsVendors = mysql_fetch_assoc($rsVendors);
$totalRows_rsVendors = mysql_num_rows($rsVendors);

mysql_select_db($database_eam, $eam);
$query_rsPlatform = "SELECT * FROM assets_hardware_platform ORDER BY platform ASC";
$rsPlatform = mysql_query($query_rsPlatform, $eam) or die(mysql_error());
$row_rsPlatform = mysql_fetch_assoc($rsPlatform);
$totalRows_rsPlatform = mysql_num_rows($rsPlatform);

mysql_select_db($database_eam, $eam);
$query_rsHardwareType = "SELECT * FROM assets_hardware_type";
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
<?php $pageTitle="Add Hardware"; ?>
<?php include('includes/header.php'); ?>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1">
      <fieldset>
      <legend> Add Hardware</legend>
<!-- Conditional for Monitors -->	
	<?php if ($row_Recordset1['assets_hardware_type'] == "Monitor") 
		{
		?> 
		<p>
        <label for="Monitor Size">Monitor Size</label>
        <select name="monitor_size">
          <option value="0"> - </option>
          <option value="0">None</option>
          <?php
			do {  
			?>
          <option value="<?php echo $row_rsMonitorSize['size']?>"><?php echo $row_rsMonitorSize['size']?></option>
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
      <p><label for="Platform">Hardware Type:</label><select name="assets_hardware_type">
        <option value="">-</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsHardwareType['assets_hardware_type']?>"><?php echo $row_rsHardwareType['assets_hardware_type']?></option>
        <?php
} while ($row_rsHardwareType = mysql_fetch_assoc($rsHardwareType));
  $rows = mysql_num_rows($rsHardwareType);
  if($rows > 0) {
      mysql_data_seek($rsHardwareType, 0);
	  $row_rsHardwareType = mysql_fetch_assoc($rsHardwareType);
  }
?>
      </select> </p>
	  <p>
        <label for="Platform">Platform</label>
        <select name="platform">
          <option value=""> - </option>
          <?php
			do {  
			?>
          <option value="<?php echo $row_rsPlatform['platform']?>"><?php echo $row_rsPlatform['platform']?></option>
          <?php
			} while ($row_rsPlatform = mysql_fetch_assoc($rsPlatform));
			  $rows = mysql_num_rows($rsPlatform);
			  if($rows > 0) {
				  mysql_data_seek($rsPlatform, 0);
				  $row_rsPlatform = mysql_fetch_assoc($rsPlatform);
			  }
			?>
        </select>
      </p>
      <p>
        <label for="Vendor">Make</label>
        <select name="vendor">
          <option value=""> - </option>
          <?php
do {  
?>
          <option value="<?php echo $row_rsVendors['vendor']?>"><?php echo $row_rsVendors['vendor']?></option>
          <?php
} while ($row_rsVendors = mysql_fetch_assoc($rsVendors));
  $rows = mysql_num_rows($rsVendors);
  if($rows > 0) {
      mysql_data_seek($rsVendors, 0);
	  $row_rsVendors = mysql_fetch_assoc($rsVendors);
  }
?>
        </select>
      </p>
      <p>
        <label for="Model">Model</label>
        <input name="model" type="text" size="8" maxlength="30" />
        <span class="tiny">D610, GX620, MacPro, MBP...</span> </p>
      <p>
        <label for="Serial Number">Serial Number</label>
        <input name="serialnumber" type="text" size="12" maxlength="30" />
      </p>
      <p>
        <label for="Asset Tag">Asset Tag</label>
        <input name="asset_tag" type="text" size="12" maxlength="30" />
      </p>
      <p>
        <label for="Purchase Order">Purchase Order</label>
        <input name="purchase_order" type="text" size="12" maxlength="30" />
      </p>        
      <hr />
      <p>
        <label for="Date Purchased">Date Purchased</label>
        <input type="text" name="date_purchase" value="" size="8" />
        <img src='images/scw.gif' title='Click Here' alt='Click Here' onclick="cal.select(document.forms['form1'].date_purchase,'anchor2','MM/dd/yyyy'); return false;" name="anchor2" id="anchor2" style="cursor:hand" /> </p>
      <p>
        <label for="Warranty Date">Warranty Date</label>
        <input type="text" name="warranty" value="" size="8" />
        <img src='images/scw.gif' title='Click Here' alt='Click Here' onclick="cal.select(document.forms['form1'].warranty,'anchor1','MM/dd/yyyy'); return false;"
   name="anchor1" id="anchor1" style="cursor:hand" /></p>
      <p>
        <label for="Status">Status</label>
        <select name="status">
          <option value=""> - </option>
          <?php
			do {  
			?>
          <option value="<?php echo $row_rsHardwareStatus['assets_hardware_status']?>"><?php echo $row_rsHardwareStatus['assets_hardware_status']?></option>
          <?php
			} while ($row_rsHardwareStatus = mysql_fetch_assoc($rsHardwareStatus));
			  $rows = mysql_num_rows($rsHardwareStatus);
			  if($rows > 0) {
				  mysql_data_seek($rsHardwareStatus, 0);
				  $row_rsHardwareStatus = mysql_fetch_assoc($rsHardwareStatus);
			  }
			?>
        </select>
      </p>
 <hr />	  
      <p>
        <label for="User">User</label>
        <input name="user" type="text" size="32" maxlength="50" />
        <span class="tiny">Full name</span> </p>
      <p>
        <label for="User">User Account</label>
        <input name="user_account" type="text" size="12" maxlength="12" />
        <span class="tiny">AD account</span> </p>
      <p>	  
        <label for="Division">Division</label>
        <select name="division">
          <option value=""> - </option>
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
          <option value=""> - </option>
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
        <label for="Comments">Cube</label>
        <input name="cube" type="text" size="12" maxlength="12" />
      </p>		  
	  <p>
        <label for="Comments">Field User Address</label>
        <textarea name="field_address" cols="20" rows="" wrap="virtual"></textarea><span class="tiny">Field address + phone</span>      </p>
      <p>
        <label for="Comments">Comments</label>
        <textarea name="comments" cols="32"></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="    Add Asset    " />
      </p>
      <input type="hidden" name="MM_insert" value="form1" />
      </fieldset>
    </form>
<?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsVendors);
mysql_free_result($rsPlatform);
mysql_free_result($rsHardwareType);
mysql_free_result($rsDivision);
mysql_free_result($rsLocation);
mysql_free_result($rsHardwareStatus);
mysql_free_result($rsMonitorSize);
?>
