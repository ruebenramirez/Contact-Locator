<?php
/*
 * add_region.php
 * add region form
 */
require('../inc.php');

// handle a submission
if (isset($_POST) && !empty($_POST)) {
	
	$sqlCheckPreExistingRegion = "SELECT name FROM regions WHERE name like '".addslashes($_REQUEST['name'])."'";
	$resultExistingRegion = mysql_query($sqlCheckPreExistingRegion) or die('died checking for an existing reseller.. '.mysql_error());
	if (mysql_num_rows($resultExistingRegion) < 1) {
		//save the new region
		$sqlAddRegion = "INSERT INTO regions (name) VALUES('".addslashes($_REQUEST['name'])."');";
		mysql_query($sqlAddRegion) or die('died adding new region: '.mysql_error());
		
		$id = mysql_insert_id();
		
		if(isset($_POST['territories']) && !empty($_POST['territories'])) {
			$sqlClearTerritories = "DELETE FROM territory_regions WHERE region_id = '".$id."'";
			mysql_query($sqlClearTerritories) or die('died clearing out old territories: '.mysql_error());
			
			$thisTerritories = $_REQUEST['territories'];
			foreach($thisTerritories as $territory) {
				//remove duplicates
				$sqlRemoveDuplicates = "DELETE FROM territory_regions WHERE region_id= '".$id."' AND territory_id = '".$territory."'";
				mysql_query($sqlRemoveDuplicates) or die('died removing duplicate territories: '.mysql_error());
				
				//insert new territory region associations
				$sqlAddTerritories = "INSERT INTO territory_regions (region_id, territory_id) VALUES('".$id."', '".$territory."')";
				mysql_query($sqlAddTerritories) or die('died adding a new territory');
			}
		}
		
		header('location: index.php');
	} else {
		$alreadyExists = true;
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
	$("#form_territories").load('assists/territories_form.php', function() {
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



<form method="POST" action="">
<?php
if (isset($alreadyExists) && $alreadyExists) {
 echo '<div class="error">This region already exists, go ahead and try another one.</div>';
}
?>
Region: <input name="name" type="text" value=""/>
<br />
<br />

<div id="form_territories"></div>
<br />

<a id="add_additional_territory" href="">add another territory</a>
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


