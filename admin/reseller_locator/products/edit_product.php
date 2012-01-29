<?php

/*
 * edit.php
 * edit products
 */

require('../inc.php');

if(isset($_REQUEST['id'])) {
	//check is passed product_id exists
	$sql = "SELECT id FROM products WHERE id = '".$_REQUEST['id']."';";
	$results = mysql_query($sql) or die('trying to look up this product_id for an edit form populate: Error in sql: '.$sql);
	if (mysql_num_rows($results) < 1) {
		//this product id doesn't exist
		header('Location: '.resellerLocatorBaseWebAddress().'/products/index.php?message=notexist');
	}
	
	$product = new Product($_REQUEST['id']);
}

// check for form submission  (if empty form submission then print the form..)
if (!empty($_POST)){
	$product->updateProduct();
}

/***********************************************************************************/
//No data was submitted or validation failed
//	...so print the form for user to fill out and submit
/***********************************************************************************/
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Edit Reseller Product</title>
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
	
	<script type="text/javascript">

	function init() {
		ieRadioButtonCheck();
		logoRadioSelect();
		checkRBLogoSwitch();
	}

	function logoRadioSelect() {
		$("#product_upload_image").hide();
		
		$("input:radio[name=rb_keep_old_logo]").bind('change', function (event) {
			checkRBLogoSwitch();
		});
	}

	function checkRBLogoSwitch() {
		var showImage = $("input:radio[name=rb_keep_old_logo]:checked").val();
		if (showImage == 0) {
			$("#product_upload_image").hide();
			$("#product_logo_image").show();
		} else {
			$("#product_logo_image").hide();
			$("#product_upload_image").show();
		}
	}
	

	function ieRadioButtonCheck() {
		// This is the hack for IE  source: http://stackoverflow.com/questions/208471/getting-jquery-to-recognise-change-in-ie
		if ($.browser.msie) {
		  $("input:radio[name=rb_keep_old_logo]").click(function() {
		    this.blur();
		    this.focus();
		  });
		}
	}
	
	$(document).ready( function(){
		init();
	});
	</script>
	
	
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
	<div id="title">Edit product: <?php echo $product->name; ?></div>
	
	<form method="post" action="" enctype="multipart/form-data">
		
		<?php
		if(isset($product->nValid_message['name'])) {
			echo $product->nValid_message['name'];
		}
		?>
		<div class="label">Product name:</div>
		<div class="formInput"><input name="name" type="text" value="<?php echo $product->name; ?>"/></div>
		<br />
		<br />
		
		<?php
		if(isset($product->nValid_message['website'])) {
			echo $product->nValid_message['website'];
		}
		?>
		<div class="label">Product website:</div>
		<div class="formInput"><input name="website" type="text" value="<?php echo $product->website; ?>"/></div>
		<br />
		<br />
		<!--
		<?php
		if(isset($product->nValid_message['logo'])) {
			echo $product->nValid_message['logo'];
		}
		?>
		<div class="label">Product Logo:</div>
		<br />
		
		<div class="label"></div>
		<div class="formInput">
			<input id="rb_keep_old_logo" name="rb_keep_old_logo" type="radio" value="0"
			<?php
				if (!isset($product->nValid_message['logo'])) {
					echo 'checked="checked"';
				}
			?>
			></input> keep old file
			<input id="rb_keep_old_logo" name="rb_keep_old_logo" type="radio"
			<?php
				if (isset($product->nValid_message['logo'])) {
					echo 'checked="checked"';
				}
			?>
			value="1"></input> upload a new file
		</div>
		<br />
		<br />
		 
		<div id="product_logo_image">
			<img id="logo" src="product_images/<?php echo $product->logo; ?>" />
			<br />
			<br />
		</div>
		
		<div id="product_upload_image">
			<div class="label"></div>
			<div class="formInput"><input name="logo" type="file" value=""/></div>
			<br />
			<br />
		</div>
		
		-->
		<input name="submit" type="submit" value="submit"></input> <a href="index.php">cancel</a>
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


