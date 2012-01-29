<?php
/*
 * edit_territory.php
 */
require('../inc.php');

$sqlGetTerritory = "SELECT name, us, id FROM territories WHERE id = '".$_REQUEST['id']."'";
$resultTerritory = mysql_query($sqlGetTerritory) or die('died getting territory info: '.mysql_error());
while($territory = mysql_fetch_object($resultTerritory)) {
	$name = $territory->name;
	$us = $territory->us;
	$id = $territory->id;
}

function printjQueryRegions($id) {
	//get list of regions for this territory
	$intregions = array();
	$sqlGetRegions = "SELECT region_id FROM territory_regions WHERE territory_id = '".$id."'";
	$resultRegions = mysql_query($sqlGetRegions) or die('died getting regions for this territory: '.mysql_error());
	while ($regionrow = mysql_fetch_object($resultRegions)) {
		$intregions[]= $regionrow->region_id;
	}
	
	if (isset($intregions)) {
		echo "'regions[]': [";
		for($i = 0; $i < count($intregions); $i++) {
			if ($i != count($intregions)-1) { //output all except for last territory
				echo $intregions[$i].', ';
			} else { //output the last territory
				echo $intregions[$i];
			}
		}
		echo "]";
	}
}

if (!isset($_REQUEST['id'])) {
	header('location: index.php');
}

if (isset($_POST) && !empty($_POST)){
	if (!empty($_POST['regions'])) {
		//remove old territory_region associations
		$sqlRemoveOldRegions = "DELETE FROM territory_regions WHERE territory_id = '".$id."'";
		mysql_query($sqlRemoveOldRegions) or die('died removing old regions for this territory: '.mysql_error());
		
		//update this territory record
		if(isset($_REQUEST['name'])) {
			$sqlUpdateTerritory = "UPDATE territories SET name='".addslashes($_REQUEST['name'])."' WHERE id='".$id."'";
			mysql_query($sqlUpdateTerritory) or die('died updating territory: '.mysql_error());
		}
		
		
		//save this territories regional associations
		$regions = $_POST['regions'];
		foreach($regions as $region) {
			//make sure that only unique territory_regions record added
			$sqlRemoveDuplicates = "DELETE FROM territory_regions WHERE territory_id = '".$id."' AND region_id = '".$region."'";
			mysql_query($sqlRemoveDuplicates) or die('died deleting duplicate records: '.mysql_error());
			
			$sqlSaveRegions = "INSERT INTO territory_regions (territory_id, region_id) VALUES('".$id."', '".$region."')";
			mysql_query($sqlSaveRegions) or die('died saving new region to this territory association: '.mysql_error());
		}
	}
	header('location: index.php');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="/admin/reseller_locator/js/jquery.1.3.2.js"></script>
<link href="/admin/reseller_locator/css/newtek_nav.css" rel="stylesheet" type="text/css" />
<link href="/admin/reseller_locator/css/tri_subnav.css" rel="stylesheet" type="text/css" />

<link href="/admin/reseller_locator/css/tricaster_main.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/admin/reseller_locator/js/p7popmenu.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/bodyload.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/AC_OETags.js"></script>
<!-- SHADOWTBOX -->
<script type="text/javascript" src="/admin/reseller_locator/js/shadowbox-base.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/shadowbox.js"></script>

<link href="../css/resellers.css" media="screen" rel="Stylesheet" type="text/css"/>

<script type="text/javascript">

function bindRemoveRegionButtons() {
	//remove region click handler
	$('.removeRegionLink').bind('click', function(event) {
		$(this).parent().remove();
		return false;
	});
}

function init() {
	if ( <?php echo $us;?> == 0 ) {
		// update territories ddl
		$("#regionInputs").load('assists/regions_form.php', { <?php printjQueryRegions($id); ?> }, function() {
			bindRemoveRegionButtons();
		});
	} else {
		// update territories ddl
		$("#regionInputs").load('assists/regions_form.php', { <?php printjQueryRegions($id); ?> }, function() {
			bindRemoveRegionButtons();
		});
	}

	// "add territory" click handler
	//$('#add_additional_region').unbind();
	$('#add_additional_region').bind('click', function(event) {
		//alert('add additional region was clicked');
		if( <?php echo $us;?> == 0) {
			$.get('assists/regions_form.php', function(data) {
				$("#regionInputs").append(data);
				bindRemoveRegionButtons();
			});
		} else {
			$.get('assists/regions_form.php', function(data) {
				$("#regionInputs").append(data);
				bindRemoveRegionButtons();
			});
		}
		return false;
	});
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



Territory:
<?php echo $name?>
<br />
<form method="POST" action="">

<input name="name" type="text" value="<?php echo $name?>" />

<div id="regionInputs"></div>
<a id="add_additional_region" href="">+ add another region</a>
<br />
<br />

<input name="us" type="checkbox" value="1" <?php
if ($us == 1) {
	echo 'checked="checked"';
}
?>/> US territory
<br />

<br />
<div class="submit">
	<input name="submit" type="submit" value="submit" />
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
