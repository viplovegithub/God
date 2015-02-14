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
  $updateSQL = sprintf("UPDATE assets_hardware_platform SET platform=%s, comments=%s WHERE platform_id=%s",
                       GetSQLValueString($_POST['platform'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['platform_id'], "int"));

  mysql_select_db($database_eam, $eam);
  $Result1 = mysql_query($updateSQL, $eam) or die(mysql_error());

  $updateGoTo = "PlatformList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsPlatformUpdate = "-1";
if (isset($_GET['platform_id'])) {
  $colname_rsPlatformUpdate = $_GET['platform_id'];
}
mysql_select_db($database_eam, $eam);
$query_rsPlatformUpdate = sprintf("SELECT * FROM assets_hardware_platform WHERE platform_id = %s", GetSQLValueString($colname_rsPlatformUpdate, "int"));
$rsPlatformUpdate = mysql_query($query_rsPlatformUpdate, $eam) or die(mysql_error());
$row_rsPlatformUpdate = mysql_fetch_assoc($rsPlatformUpdate);
$totalRows_rsPlatformUpdate = mysql_num_rows($rsPlatformUpdate);
?>
<?php $pageTitle="Update Platform"; ?>
<?php include('includes/header.php'); ?>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <fieldset>
      <legend>Update Platform</legend>
      <p>
        <label for="Vendor ID">Platform id</label>
        <?php echo $row_rsPlatformUpdate['platform_id']; ?></p>
      <p>
        <label for="Vendor">Platform</label>
        <input type="text" name="platform" value="<?php echo $row_rsPlatformUpdate['platform']; ?>" size="32">
      </p>
      <p>
        <label for="Comments">Comments</label>
        <textarea name="comments" cols="30" rows="3" id="comments"><?php echo $row_rsPlatformUpdate['comments']; ?></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="Update record">
      </p>
      </fieldset>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="platform_id" value="<?php echo $row_rsPlatformUpdate['platform_id']; ?>">
    </form>
    <?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsPlatformUpdate);
?>
