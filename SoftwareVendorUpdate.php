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
  $updateSQL = sprintf("UPDATE vendors_software SET vendor=%s, comments=%s WHERE vendor_id=%s",
                       GetSQLValueString($_POST['vendor'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['vendor_id'], "int"));

  mysql_select_db($database_eam, $eam);
  $Result1 = mysql_query($updateSQL, $eam) or die(mysql_error());

  $updateGoTo = "SoftwareVendorList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsSoftwareVendor = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsSoftwareVendor = (get_magic_quotes_gpc()) ? $_GET['recordID'] : addslashes($_GET['recordID']);
}
mysql_select_db($database_eam, $eam);
$query_rsSoftwareVendor = sprintf("SELECT * FROM vendors_software WHERE vendor_id = %s", $colname_rsSoftwareVendor);
$rsSoftwareVendor = mysql_query($query_rsSoftwareVendor, $eam) or die(mysql_error());
$row_rsSoftwareVendor = mysql_fetch_assoc($rsSoftwareVendor);
$totalRows_rsSoftwareVendor = mysql_num_rows($rsSoftwareVendor);
 
$pageTitle="Software Vendor Update"; ?>
<?php include('includes/header.php'); ?>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <fieldset>
      <legend>Update Software Vendor</legend>
      <p>
        <label for="Vendor ID">Vendor id</label>
        <?php echo $row_rsSoftwareVendor['vendor_id']; ?></p>
      <p>
        <label for="Vendor">Vendor</label>
        <input type="text" name="vendor" value="<?php echo $row_rsSoftwareVendor['vendor']; ?>" size="32">
      </p>
      <p>
        <label for="Comments">Comments</label>
        <textarea name="comments" cols="30" rows="3"><?php echo $row_rsSoftwareVendor['comments']; ?></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="Update record">
      </p>
      </fieldset>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="vendor_id" value="<?php echo $row_rsSoftwareVendor['vendor_id']; ?>">
    </form>    

    <?php include('includes/footer.php'); ?><?php
mysql_free_result($rsSoftwareVendor);
?>
