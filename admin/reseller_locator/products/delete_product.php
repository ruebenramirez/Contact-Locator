<?php
/*
 * delete_product.php
 */

require('../inc.php');

if (!isset($_REQUEST['id'])) {
	header('location: index.php');
}
$id = $_REQUEST['id'];

$sqlGetProduct = "SELECT * FROM products WHERE id='".$id."'";
$resultProduct = mysql_query($sqlGetProduct) or die('died getting product info: '.mysql_error());
while($product = mysql_fetch_object($resultProduct)) {
	$name = $product->name;
	$logo = $product->logo;
}

//handle form submission
if (!empty($_POST)){
	if(isset($_POST['submitted']) && isset($_POST['confirm']) && $_POST['confirm'] == 1) {
		//process deleting the product
		//echo "<br />deleting product...<br />";
		
		$sqlDeleteResellerProductAssoc = "DELETE FROM reseller_products WHERE product_id = '".$id."'";
		mysql_query($sqlDeleteResellerProductAssoc) or die('died deleting reseller_products records: '.mysql_error());
		
		$sqlDeleteProduct = "DELETE FROM products WHERE id= '".$id."'";
		mysql_query($sqlDeleteProduct) or die('died deleting product: '.mysql_error());
		
		header('location: index.php');
	} else {
		$confirmedNotChecked = '<div class="validation_error">Please check the box to confirm delete product.</div>';
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Delete Product: <?php echo $name;?></title>
<link href="/admin/reseller_locator/css/newtek_nav.css" rel="stylesheet" type="text/css" />
<link href="/admin/reseller_locator/css/tri_subnav.css" rel="stylesheet" type="text/css" />

<link href="/admin/reseller_locator/css/tricaster_main.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/admin/reseller_locator/js/p7popmenu.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/bodyload.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/AC_OETags.js"></script>
<!-- SHADOWTBOX -->
<script type="text/javascript" src="/admin/reseller_locator/js/jquery.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/shadowbox-base.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/shadowbox.js"></script>

<link href="../css/resellers.css" media="screen" rel="Stylesheet" type="text/css"/>
</head>

<body>
<div id="all">
<div class="space"></div>
<div id="head">
<div id="header_content"><a href="http://www.newtek.com"><img
	src="/admin/reseller_locator/images/newtek_logo.jpg" alt="NewTek Home" width="545"
	height="102" border="0" /></a></div>
</div><!-- end #head -->


<div id="newtek_nav"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/admin/inklood/nav2.php'); // not available from the provided zip ?></div>

<!-- END FLASH --> <!-- ---------------------------------------------------------------- -->

<div id="content">

<br />
Delete product:
<br />
Are you sure you want to delete product '<?php echo $name;?>'?

<?php
if (isset($confirmedNotChecked)) {
	echo $confirmedNotChecked;
}
?>

<form method="POST" action="">
<div class="label">&nbsp;</div>
<div class="formInput">
	<input name="confirm" type="checkbox" value="1" /> Confirm delete
</div>
<input name="submitted" type="hidden" value="1" /><br />
<input name="id" type="hidden" value="<?php echo $id; ?>" /><br />
<br />
<input name="submit" type="submit" value="Delete" />
</form>



</div><!-- end #content -->
<div id="leftNav">
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/admin/reseller_locator/subnav.php'); ?>
</div>
<!-- ---------------------------------------------------------------- -->

<div class="clear"></div>

<div id="footer"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php'); ?>
</div>
</div>
<!-- end #all -->
</body>
</html>