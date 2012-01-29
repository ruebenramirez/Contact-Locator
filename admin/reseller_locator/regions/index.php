<?php

/*
 * index.php
 * list all regions
 */
require('../inc.php');

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

<table id="mytable" cellspacing="0" summary="Admin product management interface">
	<tr>
		<th scope="col" abbr="">Region</th>
		<th scope="col" abbr=""></th> <!-- edit -->
		<th scope="col" abbr=""></th> <!-- delete -->
<!--		<th scope="col" abbr=""></th>  manage territories -->
		<th scope="col" abbr=""></th> <!-- territory count -->
	</tr>
<?php
$sqlGetRegions = "SELECT `regions`.id, `regions`.name FROM regions ORDER BY `regions`.name ASC";
$resultRegions = mysql_query($sqlGetRegions) or die('died getting regions: '.mysql_error());
while($region = mysql_fetch_assoc($resultRegions)) {
	?>
	<tr>
		<td class="leftCol"><?php echo $region['name'];?></td>
		<td><a href="edit_region.php?id=<?php echo $region['id'];?>">edit</a></td>
		<td><a href="delete_region.php?id=<?php echo $region['id'];?>">delete</a></td>
<!--		<td><a href="manage_region.php?id=<?php echo $region['id'];?>">manage territories</a></td>-->
		<td>
		<?php
			$sqlCountTerritories = "SELECT COUNT(territory_id) AS terCount FROM territory_regions WHERE region_id='".$region['id']."'";
			$resultCountTerritories = mysql_query($sqlCountTerritories) or die('died counting territories: '.mysql_error());
			while($territory = mysql_fetch_object($resultCountTerritories)) {
				echo $territory->terCount;
			}
		
		?> territories</td>
	</tr>
	<?php
}
?>
</table>

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