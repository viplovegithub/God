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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE assets_hardware_type SET assets_hardware_type=%s, comments=%s WHERE id=%s",
                       GetSQLValueString($_POST['assets_hardware_type'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_eam, $eam);
  $Result1 = mysql_query($updateSQL, $eam) or die(mysql_error());

  $updateGoTo = "HardwareTypeList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsHardwareType = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsHardwareType = $_GET['recordID'];
}
mysql_select_db($database_eam, $eam);
$query_rsHardwareType = sprintf("SELECT * FROM assets_hardware_type WHERE id = %s", GetSQLValueString($colname_rsHardwareType, "int"));
$rsHardwareType = mysql_query($query_rsHardwareType, $eam) or die(mysql_error());
$row_rsHardwareType = mysql_fetch_assoc($rsHardwareType);
$totalRows_rsHardwareType = mysql_num_rows($rsHardwareType);
 
$pageTitle="Update Hardware Type"; ?>
<?php include('includes/header.php'); ?>

    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <fieldset>
      <legend>Update Hardware Type </legend>
      <p>
        <label for="Vendor ID">Hardware Type ID</label>
        <?php echo $row_rsHardwareType['id']; ?></p>
      <p>
        <label for="Vendor">Hardware Type</label>
        <input type="text" name="assets_hardware_type" value="<?php echo $row_rsHardwareType['assets_hardware_type']; ?>" size="32">
      </p>
      <p>
        <label for="Comments">Comments</label>
        <textarea name="comments" cols="30" rows="3"><?php echo $row_rsHardwareType['comments']; ?></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="Update record">
      </p>
      </fieldset>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="id" value="<?php echo $row_rsHardwareType['id']; ?>">
    </form>

    <?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsHardwareType);
?>
