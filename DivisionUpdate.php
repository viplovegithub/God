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
  $updateSQL = sprintf("UPDATE division SET division=%s, comments=%s WHERE id=%s",
                       GetSQLValueString($_POST['division'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_eam, $eam);
  $Result1 = mysql_query($updateSQL, $eam) or die(mysql_error());

  $updateGoTo = "DivisionList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsDivisionUpdate = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsDivisionUpdate = (get_magic_quotes_gpc()) ? $_GET['recordID'] : addslashes($_GET['recordID']);
}
mysql_select_db($database_eam, $eam);
$query_rsDivisionUpdate = sprintf("SELECT * FROM division WHERE id = %s", $colname_rsDivisionUpdate);
$rsDivisionUpdate = mysql_query($query_rsDivisionUpdate, $eam) or die(mysql_error());
$row_rsDivisionUpdate = mysql_fetch_assoc($rsDivisionUpdate);
$totalRows_rsDivisionUpdate = mysql_num_rows($rsDivisionUpdate);
?>
<?php $pageTitle="Update Division"; ?>
<?php include('includes/header.php'); ?>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <fieldset>
      <legend>Update Division</legend>
      <p>
        <label for="Vendor ID">Division ID</label>
        <?php echo $row_rsDivisionUpdate['id']; ?></p>
      <p>
        <label for="Vendor">Division</label>
        <input type="text" name="division" value="<?php echo $row_rsDivisionUpdate['division']; ?>" size="32" />
      </p>
      <p>
        <label for="Comments">Comments</label>
        <textarea name="comments" cols="30" rows="3"><?php echo $row_rsDivisionUpdate['comments']; ?></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="Update record">
      </p>
      </fieldset>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="id" value="<?php echo $row_rsDivisionUpdate['id']; ?>">
    </form>
    <?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsDivisionUpdate);
?>
