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

if(isset($_REQUEST['regionid']) && !empty($_REQUEST['regionid'])){
	$regionId = $_REQUEST['regionid'];
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>NewTek.com - Locate Resellers - International</title>
<!--
<link rel="stylesheet" type="text/css" href="css/resellers.css"/>
-->

<script type="text/javascript" src="/admin/reseller_locator/js/jquery.1.3.2.js"></script>

<!--
<link href="/admin/reseller_locator/css/newtek_nav.css" rel="stylesheet" type="text/css" />
<link href="/admin/reseller_locator/css/tri_subnav.css" rel="stylesheet" type="text/css" />
<link href="/admin/reseller_locator/css/tricaster_main.css" rel="stylesheet" type="text/css" />
-->


<link href="/newtek_new/css/newtek_main.css" rel="stylesheet" type="text/css" />
<link href="/newtek_new/p7epm/epm50/p7EPM50.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="/newtek_new/p7epm/p7EPMscripts.js"></script>
    

<script type="text/javascript" src="/admin/reseller_locator/js/p7popmenu.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/bodyload.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/AC_OETags.js"></script>
<!-- SHADOWTBOX -->
<!--<script type="text/javascript" src="/admin/reseller_locator/js/jquery.js"></script>-->
<script type="text/javascript" src="/admin/reseller_locator/js/shadowbox-base.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/shadowbox.js"></script>


<script type="text/javascript">
	function handleSubmit() {
		$('#territory').change(function() {
			//alert('territory was selected');
			if ($('#region').val() != null && $('#territory').val() !=null) {
				//on territory selected, redirect user to a results page
				window.location.replace("public_int_resellers_results.php?region=" + $('#region').val() + "&territory=" + $('#territory').val() + "&product=" + $('#product').val());
			}
		});
	}

	function populateTerritories() {
		$('#territoryFormInputs').load('assists/ddl_territories.php', { region: $('#region').val() }, function() {
			handleSubmit();
		});
		return false;
	}

	$(document).ready( function(){
		if ($('#region').val() != null) {
			//base the first region form name on the $_REQUEST[]
			$('#RegionNameArea').load('assists/form_regionName.php'<?php if(isset($regionId)) echo ", {regionid: ".$regionId."}";?>);
			
			populateTerritories();
		}

		$('#region').change(function() {
			//base subsequent new region name for the form on the drop down list value
			$('#RegionNameArea').load('assists/form_regionName.php', {regionid: $('#region').val()});
			
			populateTerritories();
		});

		$('#resellerSubNavigationMenuListings').load('/admin/reseller_locator/resellerSubNav.php');
	});
</script>



</head>

<body id="body">

<div class="space"> </div>

<div id="all">

<div id="head">

<div id="header_content"><a href="http://www.newtek.com"><img src="http://sandbox.newtek.com/newtek_new/images/newtek_logo.jpg" alt="NewTek Home" width="545" height="102" border="0" /></a></div>

</div>
<!-- end #head -->

  <div id="newtek_nav">
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/inklood/main_menu.php'); ?>
  </div>





 <!-- START RIGHT_COL -->
  <div id="right_col">
    <div class="pagetitle_resellers">RESELLERS</div>
    <div id="pagenav">
       <!-- reseller navigation items -->
    	<div id="resellerSubNavigationMenuListings"></div>
    </div>
    <div class="hr"> </div>
    <div class="clear"> </div>
     <?php require_once($_SERVER['DOCUMENT_ROOT'].'/newtek_new/inc/right_col.php'); ?>
  </div>
  <!-- END RIGHT COL -->




<div class="eventbox">


<div class="heading_style">Locate International Resellers</div><br />

<div id="RegionNameArea" class="subtitle_bold"></div>

<br />



<form>
<div class="label">Region: </div>
<div class="formInput">
	<select id="region" name="region">
		<option value="">-Select a region-</option>
	<?php
		$sqlGetRegions = "SELECT * FROM regions ORDER BY name;";
		$resultRegions = mysql_query($sqlGetRegions) or die('died grabbing regions: '.mysql_error());
		while($region = mysql_fetch_object($resultRegions)) {
			echo '<option ';
			if(isset($regionId)) {
				if($region->id == $regionId) {
					echo 'selected="selected"';
				}
			}
			echo 'value="'.$region->id.'">'.$region->name.'</option>';
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



 <div class="clear"> </div>
  <!-- START FOOT LINKS -->
  <div id="footbox">
    <?php include($_SERVER['DOCUMENT_ROOT'].'/newtek_new/inc/footlinks.php'); ?>
  </div>
  <!-- END FOOT LINKS -->
  <div class="clear"></div>
  <!-- START FOOTER -->
  <div id="footer">
    <?php include($_SERVER['DOCUMENT_ROOT'].'/newtek_new/inc/footer.php'); ?>
    </div>




</div>
<!-- end #all -->
</body>
</html>

