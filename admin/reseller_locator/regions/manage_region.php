<?php
/*
 * manage_region.php
 *
 * add or remove territories in a region...
 */
require('../inc.php');

function printjQueryTerritories($region_id) {
	//get all territories for this region
	$region_territories = array();
	$sqlGetTerritories = "SELECT territory_id FROM territory_regions WHERE region_id = '".$region_id."'";
	$resultTerritories = mysql_query($sqlGetTerritories) or die('died getting territories for this region: '.mysql_error());
	while($territoryRow = mysql_fetch_object($resultTerritories)) {
		$region_territories[] = $territoryRow->territory_id;
	}
	
	if (isset($region_territories)) {
		echo ", 'territories[]': [";
		for($i = 0; $i < count($region_territories); $i++) {
			if ($i != count($region_territories)-1) { //output all except for last territory
				echo $region_territories[$i].', ';
			} else { //output the last territory
				echo $region_territories[$i];
			}
		}
		echo "]";
	}
}



if(!isset($_REQUEST['id'])) {
	header('location: index.php');
}

$sqlGetRegionInfo = "SELECT * FROM regions WHERE id = '".$_REQUEST['id']."'";
$resultsRegionInfo = mysql_query($sqlGetRegionInfo) or die('died getting region info: '.mysql_error());
while($region = mysql_fetch_object($resultsRegionInfo)) {
	$id = $region->id;
	$name = $region->name;
}

//save submitted territories
if(isset($_POST['territories']) && !empty($_POST['territories'])) {
	$sqlClearTerritories = "DELETE FROM territory_regions WHERE region_id = '".$id."'";
	
	
	$thisTerritories = $_REQUEST['territories'];
	foreach($thisTerritories as $territory) {
		//remove duplicates
		$sqlRemoveDuplicates = "DELETE FROM territory_regions WHERE region_id= '".$id."' AND territory_id = '".$territory."'";
		mysql_query($sqlRemoveDuplicates) or die('died removing duplicate territories: '.mysql_error());
		
		//insert new territory region associations
		$sqlAddTerritories = "INSERT INTO territory_regions (region_id, territory_id) VALUES('".$id."', '".$territory."')";
		mysql_query($sqlAddTerritories) or die('died adding a new territory');
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

function bindRemoveTerritoryButtons() {
	//remove territory click handler
	$('.removeTerritoryLink').bind('click', function(event) {
		$(this).parent().remove();
		return false;
	});
}

function init() {
	// update territories ddl
	$("#form_territories").load('assists/territories_form.php', {us: 1 <?php printjQueryTerritories($id); ?> }, function() {
		bindRemoveTerritoryButtons();
	});

	// "add territory" click handler
	$('#add_additional_territory').bind('click', function(event) {
		//alert('add additional territory was clicked');
		$.get('assists/territories_form.php', function(data) {
			$("#form_territories").append(data);
			bindRemoveTerritoryButtons();
		});
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

<?php echo $name?>: manage territories

<form method="POST" action="">
<div id="form_territories"></div>
<br />
<a id="add_additional_territory" href="">add another territory</a>
<br />
<div class="submit">
	<input type="submit" name="submit" value="Save" />
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

