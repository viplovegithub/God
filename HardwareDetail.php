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
 // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
$colname_rsHardwareAsset = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsHardwareAsset = $_GET['recordID'];
}
mysql_select_db($database_eam, $eam);
$query_rsHardwareAsset = sprintf("SELECT * FROM assets_hardware WHERE asset_hardware_id = %s", GetSQLValueString($colname_rsHardwareAsset, "int"));
$rsHardwareAsset = mysql_query($query_rsHardwareAsset, $eam) or die(mysql_error());
$row_rsHardwareAsset = mysql_fetch_assoc($rsHardwareAsset);
$totalRows_rsHardwareAsset = mysql_num_rows($rsHardwareAsset);
 
$pageTitle="Hardware Detail"; ?>
<?php include('includes/header.php'); ?>
    <table border="0" align="center" cellspacing="0" class="tableDetails1" style"margin:0 auto;width 600px;">
      <tr>
        <td style="font-size:100%">
          <fieldset>
          <legend>Hardware Detail</legend>
          <table class="tableDetails">
            <tr>
              <th><span style="font-weight: bold">Asset ID</span></th>
              <td><?php echo $row_rsHardwareAsset['asset_hardware_id']; ?></td>
            </tr>
            <tr>
              <th><span style="font-weight: bold">Asset Type</span></th>
              <td><?php echo $row_rsHardwareAsset['asset_type']; ?> &nbsp;</td>
            </tr>
<!-- Conditional for Monitors -->	
	<?php if ($row_rsHardwareAsset['asset_type'] == "Monitor") 
		{
		?>             
            <tr>
              <th><span style="font-weight: bold">Monitor Size</span></th>
              <td><?php echo $row_rsHardwareAsset['monitor_size']; ?> &nbsp;</td>
            </tr>
	<?php 
	  } 
	  ?>            
            <tr>
              <th><span style="font-weight: bold">Status</span></th>
              <td><?php echo $row_rsHardwareAsset['status']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th><span style="font-weight: bold">Platform</span></th>
              <td><?php echo $row_rsHardwareAsset['platform']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th><span style="font-weight: bold">Make</span></th>
              <td><?php echo $row_rsHardwareAsset['vendor']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th><span style="font-weight: bold">Model</span></th>
              <td><?php echo $row_rsHardwareAsset['model']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th><span style="font-weight: bold">Serial number</span></th>
              <td><?php echo $row_rsHardwareAsset['serialnumber']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th>Asset Tag</th>
              <td><?php echo $row_rsHardwareAsset['asset_tag']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th>Purchase Order</th>
              <td><?php echo $row_rsHardwareAsset['purchase_order']; ?> &nbsp;</td>
            </tr>            
          </table>
          <hr />
          <table class="tableDetails">
            <tr>
              <th>Status</th>
              <td><?php echo $row_rsHardwareAsset['status']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th>Date Purchased</th>
              <td><?php echo $row_rsHardwareAsset['date_purchase']; ?>&nbsp;</td>
            </tr>
            <tr>
              <th>Warranty Date</th>
              <td><?php echo $row_rsHardwareAsset['warranty']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th>Date Decomissioned</th>
              <td><?php echo $row_rsHardwareAsset['date_decomission']; ?>&nbsp;</td>
            </tr>
          </table>
          <hr />
          <table class="tableDetails">
            <tr>
              <th>User</th>
              <td><?php echo $row_rsHardwareAsset['user']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th>User Account </th>
              <td><?php echo $row_rsHardwareAsset['user_account']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th>Division</th>
              <td><?php echo $row_rsHardwareAsset['division']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th>Location</th>
              <td><?php echo $row_rsHardwareAsset['location']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th>Cube</th>
              <td><?php echo $row_rsHardwareAsset['cube']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th valign="top">Field Address </th>
              <td>
                <pre><?php echo $row_rsHardwareAsset['field_address']; ?>&nbsp;</pre>
              </td>
            </tr>
            <tr>
              <th valign="top">Comments</th>
              <td><?php echo $row_rsHardwareAsset['comments']; ?> &nbsp;</td>
            </tr>
          </table>
          </fieldset>
        </td>
        <td valign="top" style="font-size:90%;">
          <p>&nbsp;</p>
          <fieldset style="width:180px;text-align:left;">
          <legend>Manage Record</legend>
          <table class="table1">
            <tr>
              <td class="green">
                <form id="upRecord" name="upRecord" method="post" action="HardwareUpdate.php?recordID=<?php echo $row_rsHardwareAsset['asset_hardware_id']; ?>">
                  <input type="submit" name="Submit2" value="Edit This Record" />
                </form>
              </td>
            </tr>
          </table>
          <br />
          <table class="table1">
            <tr>
              <td class="red">
                <form id="delRecord" name="delRecord" method="post" action="HardwareDelete.php?recordID=<?php echo $row_rsHardwareAsset['asset_hardware_id']; ?>">
                  <input name="Submit" type="submit" class="red" value="Delete This Record" />
                </form>
              </td>
            </tr>
          </table>
          </fieldset>
        </td>
      </tr>
    </table>
    <?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsHardwareAsset);
?>
