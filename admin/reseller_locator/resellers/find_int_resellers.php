<?php
/*
 * find_int_resellers.php
 *
 * http://docs.jquery.com/Plugins/Autocomplete
 * http://view.jquery.com/trunk/plugins/autocomplete/demo/
 *
 *
 * show a ddl of regions
 * -after a region is selected, show a ddl of countries for that region
 */
require('../inc.php');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>US & Canadian Resellers</title>
<link rel="stylesheet" type="text/css" href="css/resellers.css"/>
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

<script type="text/javascript">
	function handleSubmit() {
		$('#territory').change(function() {
			//alert('territory was selected');
			if ($('#region').val() != null && $('#territory').val() !=null) {
				//on territory selected, redirect user to a results page
				window.location.replace("int_resellers_results.php?region=" + $('#region').val() + "&territory=" + $('#territory').val() + "&product=" + $('#product').val());
			}
		});
	}

	$(document).ready( function(){
		$('#region').change(function() {
			$('#territoryFormInputs').load('assists/ddl_territories.php', { region: $('#region').val() }, function() {
				handleSubmit();
			});
			return false;
		});
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


Locate International Resellers:<br /><br />

<form>
<div class="label">Region: </div>
<div class="formInput">
	<select id="region" name="region">
		<option value="">-Select a region-</option>
	<?php
		$sqlGetRegions = "SELECT * FROM regions ORDER BY name;";
		$resultRegions = mysql_query($sqlGetRegions) or die('died grabbing regions: '.mysql_error());
		while($region = mysql_fetch_object($resultRegions)) {
			echo '<option value="'.$region->id.'">'.$region->name.'</option>';
		}
	?>
	</select>
</div>

<div class="label">Products</div>
<div class="formInput">
	<select id="product" name="product">
		<option value="all">All products</option>
		<?php
			$sqlGetAllProducts = "SELECT id, name FROM products";
			$resultAllProducts = mysql_query($sqlGetAllProducts) or die('died getting all products: '.mysql_error());
			while($product = mysql_fetch_object($resultAllProducts)) {
				echo '<option value="'.$product->id.'">'.$product->name.'</option>';
			}
		?>
	
	</select>
</div>

<div id="territoryFormInputs"></div>

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

