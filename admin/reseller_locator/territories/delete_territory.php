<?php

/*
 * delete_territory.php
 *
 */
require('../inc.php');

if(!isset($_REQUEST['id'])) {
	header('location: index.php');
}

if (isset($_POST['submitted']) && isset($_POST['confirm']) && $_POST['confirm'] == 1) {
	//delete the territory_region associations
	$sqlDeleteTerritoryRegionAssoc = "DELETE FROM territory_regions WHERE territory_id = '".$_REQUEST['id']."'";
	mysql_query($sqlDeleteTerritoryRegionAssoc) or die('died removing territory_region associations: '.mysql_error());
	
	//delete this territory
	$sqlDeleteTerritory = "DELETE FROM territories WHERE id='".$_REQUEST['id']."'";
	mysql_query($sqlDeleteTerritory) or die('died deleting territory: '.mysql_error());
	
	//redirect to index.php
	header('location: index.php');
}
if(isset($_POST['submitted']) && !isset($_POST['confirm'])) {
	$submittedError = '<div class="validation_error">Please check the "confirm delete" checkbox in order to delete this territory.</div>';
}

if (isset($_REQUEST['id'])) {
	$sqlGetTerritoryInfo = "SELECT * FROM territories WHERE id = '".$_REQUEST['id']."'";
	$resultTerritoryInfo = mysql_query($sqlGetTerritoryInfo) or die('died getting territory info: '.mysql_error());
	while($territory = mysql_fetch_object($resultTerritoryInfo)) {
		$id = $territory->id;
		$name = $territory->name;
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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

Are you sure you want to delete territory '<?php echo $name;?>'?

<?php
if (isset($submittedError)) {
	echo $submittedError;
}
?>
<form method="POST" action="">
	<input name="confirm" type="checkbox" value="1" /> confirm delete
	<input name="id" type="hidden" value="<?php echo $id?>" />
	<input name="submitted" type="hidden" value="1" />
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
