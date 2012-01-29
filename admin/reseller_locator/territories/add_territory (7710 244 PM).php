<?php
/*
 * add_territory.php
 *
 */
require('../inc.php');

function territoryExists($name=null) {
	if (!isset($name)) {
		return false;
	}
	$sqlTerritoryExists = "SELECT id FROM territories WHERE name LIKE '%".addslashes($name)."%'";
	$resultTerritryExists = mysql_query($sqlTerritoryExists) or die('died checking if territory exists: '.mysql_error());
	if (mysql_num_rows($resultTerritryExists) > 0) {
		return true;
	}
	return false;
}

if(isset($_POST) && !empty($_POST)) {
	if ($GLOBALS['debug']) {
		echo "POSTS: ";
		var_dump($_POST);
		echo "<br />";
	}
	
	if (isset($_POST['name']) && !empty($_POST['name']) && !territoryExists($_POST['name'])) {
		//save the new territory
		$sqlSaveNewTerritory = "INSERT INTO territories (name";
		
		if (isset($_POST['us']) && !empty($_POST['us']) && $_POST['us'] == 1) {
			$sqlSaveNewTerritory .= ", us";
		}
		
		$sqlSaveNewTerritory .= ") VALUES('".addslashes($_POST['name'])."'";
		
		if (isset($_POST['us']) && !empty($_POST['us']) && $_POST['us'] == 1) {
			$sqlSaveNewTerritory .= ", '".$_POST['us']."'";
		}
		
		$sqlSaveNewTerritory .= ")";
		mysql_query($sqlSaveNewTerritory) or die('died trying to save new territory: '.mysql_error());
		
		$id = mysql_insert_id();
		
		//save new regions for this territory
		if(isset($_POST['regions']) && !empty($_POST['regions'])) {
			//save this territories regional associations
			$regions = $_POST['regions'];
			foreach($regions as $region) {
				$sqlSaveRegions = "INSERT INTO territory_regions (territory_id, region_id) VALUES('".$id."', '".$region."')";
				mysql_query($sqlSaveRegions) or die('died saving new region to this territory association: '.mysql_error());
			}
		}
		
		header('location: index.php');
		
	} else {
		$nameInvalid = '<div class="validation_error"></div>';
	}
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
<!--<script type="text/javascript" src="/admin/reseller_locator/js/jquery.js"></script>-->
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
	// update territories ddl
	$("#regionInputs").load('assists/regions_form.php', function() {
		bindRemoveRegionButtons();
	});

	// "add territory" click handler
	//$('#add_additional_region').unbind();
	$('#add_additional_region').bind('click', function(event) {
		//alert('add additional region was clicked');
		$.get('assists/regions_form.php', function(data) {
			$("#regionInputs").append(data);
			bindRemoveRegionButtons();
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
<div id="header_content"><a href="http://www.newtek.com"><img src="/admin/reseller_locator/images/newtek_logo.jpg" alt="NewTek Home" width="545" height="102" border="0" /></a></div>
</div><!-- end #head -->


<div id="newtek_nav"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/admin/inklood/nav2.php'); // not available from the provided zip ?></div>

<!-- END FLASH --> <!-- ---------------------------------------------------------------- -->

<div id="content">




Add a new territory:

<form method="POST" action="">

	Name: <input name="name" type="text" value="<?php if (isset($_REQUEST['name'])) echo $_REQUEST['name']; ?>" />
	<br />
	<br />
	
	<div id="regionInputs"></div>
	<a id="add_additional_region" href="">+ add another region</a>
	<br />
	<br />
	<br />
	
	<input name="us" type="checkbox" value="1" /> US territory?
	<br />
	<br />
	
	<input name="submit" type="submit" value="Save" />

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