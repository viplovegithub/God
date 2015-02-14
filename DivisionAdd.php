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
  $insertSQL = sprintf("INSERT INTO division (division, comments) VALUES (%s, %s)",
                       GetSQLValueString($_POST['division'], "text"),
                       GetSQLValueString($_POST['comments'], "text"));

  mysql_select_db($database_eam, $eam);
  $Result1 = mysql_query($insertSQL, $eam) or die(mysql_error());

  $insertGoTo = "DivisionList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<?php $pageTitle="Add Division"; ?>
<?php include('includes/header.php'); ?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
<fieldset>
<legend>Add Division</legend>
<p>
 <label for="Division">Division</label> 
 <input type="text" name="division" value="" size="32">
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

<?php include('includes/footer.php'); ?>