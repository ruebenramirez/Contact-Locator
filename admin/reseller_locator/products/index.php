<?php
/*
 * reseller_products.php
 *
 * list products that resellers will be able to sell
 */

require('../inc.php');
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Reseller Product listings</title>

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

<!--<div id="nav">-->
<!--	<ul>-->
<!--		<li><a href="../index.php">resellers</a></li>-->
<!--		<li><a href="../territories/index.php">territories</a></li>-->
<!--	</ul>-->
<!--</div>-->

<?php
if (!empty($_REQUEST['message'])) {
	if ($_REQUEST['message'] == 'notexist') {
		echo '<div class="error">This product no longer exists.</div>';
	}
}
?>

<br />


Products:<!--  - <a href="add_product.php">add new product</a> -->

<?php
$sql = "SELECT * FROM products ORDER BY name;";
$results = mysql_query($sql) or die('Died trying to get reseller products: '.mysql_error());
while($row = mysql_fetch_assoc($results)) {
	?>
	<div class="product_listing">
		<div class="product_name"><?php echo $row['name']; ?></div>
<!--		<div class="column"><img alt="no logo" src="/admin/reseller_locator/products/product_images/<?php echo $row['logo']?>" /></div>-->
		<div class="product_edit"><a href="edit_product.php?id=<?php echo $row['id']; ?>">edit</a></div>
		<div class="product_delete"><a href="delete_product.php?id=<?php echo $row['id']; ?>">delete</a></div>
	</div><!-- end .product_listing -->
	<?php
}


?>


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
