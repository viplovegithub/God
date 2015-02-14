<?php require_once('Connections/eam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
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

if ((isset($_POST['vendor_id'])) && ($_POST['vendor_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM vendors WHERE vendor_id=%s",
                       GetSQLValueString($_POST['vendor_id'], "int"));

  mysql_select_db($database_eam, $eam);
  $Result1 = mysql_query($deleteSQL, $eam) or die(mysql_error());

  $deleteGoTo = "VendorList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_eam, $eam);
$query_rsVendorList = "SELECT * FROM vendors ORDER BY vendor ASC";
$rsVendorList = mysql_query($query_rsVendorList, $eam) or die(mysql_error());
$row_rsVendorList = mysql_fetch_assoc($rsVendorList);
$totalRows_rsVendorList = mysql_num_rows($rsVendorList);
?>
<?php $pageTitle="Vendor List"; ?>
<?php include('includes/header.php'); ?>
    <h3>Vendor List </h3>
    <table width="600" class="table1">
      <tr>
        <th>Vendor</th>
        <th>Comments</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_rsVendorList['vendor']; ?></td>
          <td><?php echo $row_rsVendorList['comments']; ?></td>
          <td><a href="VendorUpdate.php?vendor_id=<?php echo $row_rsVendorList['vendor_id']; ?>">Update</a></td>
          <td> <form id="delRecord" name="delRecord" method="post" action="VendorDelete.php?recordID=<?php echo $row_rsVendorList['vendor_id']; ?>">
                  <input name="Submit" type="submit" class="red" value="Delete This Record" />
                </form></td>
        </tr>
      <?php } while ($row_rsVendorList = mysql_fetch_assoc($rsVendorList)); ?>
    </table>
    <table class="pagination">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>      
<?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsVendorList);
?>
