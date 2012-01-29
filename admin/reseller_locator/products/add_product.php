<?php
/*
 * add.php
 * add product
 */

require('../inc.php');

$product = new Product();

// handle form submission
if (!empty($_POST)){
	//check if product name is already in use..
	$product->saveProduct();
}

/***********************************************************************************/
//No data was submitted or validation failed
//	...so print the form for user to fill out and submit
/***********************************************************************************/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Add Product</title>
<script type="text/javascript" src="/admin/reseller_locator/js/jquery.1.3.2.js"></script>

<link href="/admin/reseller_locator/css/newtek_nav.css" rel="stylesheet" type="text/css" />
<link href="/admin/reseller_locator/css/tri_subnav.css" rel="stylesheet" type="text/css" />

<link href="/admin/reseller_locator/css/tricaster_main.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/admin/reseller_locator/js/p7popmenu.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/bodyload.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/AC_OETags.js"></script>
<!-- SHADOWTBOX -->
<!--<script type="text/javascript" src="/admin/reseller_locator/js/jquery.js"></script>-->
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
	
<form method="POST" action="/admin/reseller_locator/products/add_product.php" enctype="multipart/form-data">
	<div id="title">Add product:</div>
	
	<?php
	if(isset($product->nValid_message['name'])) {
		echo $product->nValid_message['name'];
	}
	?>
	<div class="label">Product Name: </div>
	<div class="formInput">
		<input name="name" type="text" value="
		<?php
		if(isset($product->name)) {
			echo $product->name;
		}
		?>
		" />
	</div>
	<br />
	<br />
	
	<?php
		if(isset($product->nValid_message['website'])) {
			echo $product->nValid_message['website'];
		}
		?>
		<div class="label">Product website:</div>
		<div class="formInput"><input name="website" type="text" value="<?php if(isset($product->website)){ echo $product->website; } else { echo "http://newtek.com/"; } ?>"/></div>
		<br />
		<br />
	<!--
	<?php
	if(isset($product->nValid_message['logo'])) {
		echo $product->nValid_message['logo'];
	}
	?>
	<div class="label">Product Logo:</div>
	<div class="formInput">
		<input name="logo" type="file" value=""/>
	</div>
	<br />
	<br />
	 -->
	 
	<div class="submit">
		<input name="submit" type="submit" value="submit"></input> <a href="index.php">cancel</a>
	</div>
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
