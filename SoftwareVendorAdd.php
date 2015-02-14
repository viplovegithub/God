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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO vendors_software (vendor, comments) VALUES (%s, %s)",
                       GetSQLValueString($_POST['vendor'], "text"),
                       GetSQLValueString($_POST['comments'], "text"));

  mysql_select_db($database_eam, $eam);
  $Result1 = mysql_query($insertSQL, $eam) or die(mysql_error());

  $insertGoTo = "SoftwareVendorList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
 
$pageTitle="Add Software Vendor"; ?>
<?php include('includes/header.php'); ?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <fieldset>
  <legend>Add Software Vendor</legend>
  <p>
    <label for="Vendor">Vendor</label>
    <input type="text" name="vendor" value="" size="32">
  </p>
  <p>
    <label for="Comments">Comments</label>
    <textarea name="comments" cols="30" rows="6" id="comments"></textarea>
  </p>
  <p class="submit">
    <input type="submit" value="Insert record">
  </p>
  </fieldset>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
<?php include('includes/footer.php'); ?>
