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
  $updateSQL = sprintf("UPDATE location SET location=%s, comments=%s WHERE id=%s",
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_eam, $eam);
  $Result1 = mysql_query($updateSQL, $eam) or die(mysql_error());

  $updateGoTo = "LocationList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsLocationList = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsLocationList = (get_magic_quotes_gpc()) ? $_GET['recordID'] : addslashes($_GET['recordID']);
}
mysql_select_db($database_eam, $eam);
$query_rsLocationList = sprintf("SELECT * FROM location WHERE id = %s", $colname_rsLocationList);
$rsLocationList = mysql_query($query_rsLocationList, $eam) or die(mysql_error());
$row_rsLocationList = mysql_fetch_assoc($rsLocationList);
$totalRows_rsLocationList = mysql_num_rows($rsLocationList);
 ?>
<?php $pageTitle="Update Location"; ?>
<?php include('includes/header.php'); ?>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <fieldset>
      <legend>Update Location</legend>
      <p>
        <label for="Vendor ID">Location ID</label>
        <?php echo $row_rsLocationList['id']; ?></p>
      <p>
        <label for="Vendor">Location</label>
        <input type="text" name="location" value="<?php echo $row_rsLocationList['location']; ?>" size="32">
      </p>
      <p>
        <label for="Comments">Comments</label>
        <textarea name="comments" cols="30" rows="3"><?php echo $row_rsLocationList['comments']; ?></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="Update record">
      </p>
      </fieldset>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="id" value="<?php echo $row_rsLocationList['id']; ?>">
    </form>
    <?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsLocationList);
?>
