<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2013 // 
mysql_select_db($database_eam, $eam);
$query_rsVendors = "SELECT * FROM vendors ORDER BY vendor ASC";
$rsVendors = mysql_query($query_rsVendors, $eam) or die(mysql_error());
$row_rsVendors = mysql_fetch_assoc($rsVendors);
$totalRows_rsVendors = mysql_num_rows($rsVendors);

mysql_select_db($database_eam, $eam);
$query_rsPlatforms = "SELECT * FROM assets_hardware_platform ORDER BY platform ASC";
$rsPlatforms = mysql_query($query_rsPlatforms, $eam) or die(mysql_error());
$row_rsPlatforms = mysql_fetch_assoc($rsPlatforms);
$totalRows_rsPlatforms = mysql_num_rows($rsPlatforms);

mysql_select_db($database_eam, $eam);
$query_rsHardwareType = "SELECT * FROM assets_hardware_type";
$rsHardwareType = mysql_query($query_rsHardwareType, $eam) or die(mysql_error());
$row_rsHardwareType = mysql_fetch_assoc($rsHardwareType);
$totalRows_rsHardwareType = mysql_num_rows($rsHardwareType);

mysql_select_db($database_eam, $eam);
$query_rsAssets = "SELECT DISTINCT model FROM assets_hardware ORDER BY model ASC";
$rsAssets = mysql_query($query_rsAssets, $eam) or die(mysql_error());
$row_rsAssets = mysql_fetch_assoc($rsAssets);
$totalRows_rsAssets = mysql_num_rows($rsAssets);
$pageTitle="Search"; ?>
<?php include('includes/header.php'); ?>
<fieldset>
<legend>Search Assets</legend>
<form id="searchAssets" name="searchAssets" method="post" action="searchResults.php">
  <table class="tableSearch">
	<tr>
	  <th>Purchase Order</th>
	  <td><input type="text" name="purchase_order" /></td>
	  <td><input type="submit" name="Submit" value="Search" /></td>
	  </tr>
	<tr>
	  <th>Asset Tag</th>
	  <td><input type="text" name="asset_tag" /></td>
	  <td><input type="submit" name="Submit" value="Search" /></td>
	  </tr>
	<tr>
	  <th>Serial Number</th>
	  <td>
	    <input type="text" name="serialnumber" />	  </td>
	  <td>
	    <input type="submit" name="Submit" value="Search" />	  </td>
	</tr>
	<tr>
      <th>Vendor</th>
	  <td>
        <select name="vendor" id="vendor">
          <option value="value">Select Vendor</option>
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
        </select></td>
	  <td>
        <input type="submit" name="Submit" value="Search" />      </td>
	  </tr>
	<tr>
	  <th>Model </th>
	  <td>
	    <select name="model" id="model">
		<option value="value">Select Model</option>
	      <?php
do {  
?>
	      <option value="<?php echo $row_rsAssets['model']?>"><?php echo $row_rsAssets['model']?></option>
	      <?php
} while ($row_rsAssets = mysql_fetch_assoc($rsAssets));
  $rows = mysql_num_rows($rsAssets);
  if($rows > 0) {
      mysql_data_seek($rsAssets, 0);
	  $row_rsAssets = mysql_fetch_assoc($rsAssets);
  }
?>
	      </select></td>
	  <td>
	    <input type="submit" name="Submit" value="Search" /></td>
	  </tr>
	<tr>
	  <th>Platform</th>
	  <td>
	    <select name="platform" id="platform">
		  <option value="">Select Platform</option>
		  <?php
do {  
?>
		  <option value="<?php echo $row_rsPlatforms['platform']?>"><?php echo $row_rsPlatforms['platform']?></option>
		  <?php
} while ($row_rsPlatforms = mysql_fetch_assoc($rsPlatforms));
$rows = mysql_num_rows($rsPlatforms);
if($rows > 0) {
  mysql_data_seek($rsPlatforms, 0);
  $row_rsPlatforms = mysql_fetch_assoc($rsPlatforms);
}
?>
		  </select>	  </td>
	  <td>
	    <input type="submit" name="Submit" value="Search" />	  </td>
	</tr>
	<tr>
	  <th>Hardware Type</th>
	  <td>
	    <select name="asset_type" id="asset_type">
		  <option value="">Select Hardware </option>
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
		  </select>	</td>
	  <td>
	    <input type="submit" name="Submit" value="Search" />	  </td>
	</tr>
	<tr>
      <th>Full Name </th>
	  <td>
        <input type="text" name="user" />      </td>
	  <td>
        <input type="submit" name="Submit" value="Search" />      </td>
	  </tr>
	<tr>
      <th>Domain Account </th>
	  <td>
        <input type="text" name="user_account" />      </td>
	  <td>
        <input type="submit" name="Submit" value="Search" />      </td>
	  </tr>
	<tr>
	  <th>Location </th>
	  <td>
	    <input name="location" type="text" id="location" />	  </td>
	  <td>
	    <input type="submit" name="Submit" value="Search" />	  </td>
	  </tr>
  </table>
</form>
</fieldset>
<?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsVendors);
mysql_free_result($rsPlatforms);
mysql_free_result($rsHardwareType);
mysql_free_result($rsAssets);
?>
