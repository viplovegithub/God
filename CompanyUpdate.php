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
  $updateSQL = sprintf("UPDATE company SET company_name=%s WHERE company_id=%s",
                       GetSQLValueString($_POST['company_name'], "text"),
                       GetSQLValueString($_POST['company_id'], "int"));

  mysql_select_db($database_eam, $eam);
  $Result1 = mysql_query($updateSQL, $eam) or die(mysql_error());

  $updateGoTo = "Admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_eam, $eam);
$query_rsCompanyUpdate = "SELECT * FROM company";
$rsCompanyUpdate = mysql_query($query_rsCompanyUpdate, $eam) or die(mysql_error());
$row_rsCompanyUpdate = mysql_fetch_assoc($rsCompanyUpdate);
$totalRows_rsCompanyUpdate = mysql_num_rows($rsCompanyUpdate);
?>
<?php include('includes/header.php'); ?>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <fieldset>
      <legend>Company Name - Update</legend>

      <p>
        <label for="Company Name">Company Name:</label>
        <input name="company_name" type="text" value="<?php echo htmlentities($row_rsCompanyUpdate['company_name'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" maxlength="200" />
      <p class="submit">
        <input type="submit" value="Update record" />
      </p>
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="company_id" value="<?php echo $row_rsCompanyUpdate['company_id']; ?>" />


      <p>&nbsp;</p>
      <p>&nbsp;</p>
      </fieldset>
    </form>
    <?php include('includes/footer.php'); ?>
<?php
mysql_free_result($rsCompanyUpdate);
?>
