<?php
/*
 * index.php
 * admin list of territories
 */
require('../inc.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Reseller territories admin</title>
	<link href="/admin/reseller_locator/css/newtek_nav.css" rel="stylesheet" type="text/css" />
<link href="/admin/reseller_locator/css/tri_subnav.css" rel="stylesheet" type="text/css" />

<link href="/admin/reseller_locator/css/tricaster_main.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/admin/reseller_locator/js/p7popmenu.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/bodyload.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/AC_OETags.js"></script>
<!-- SHADOWTBOX -->
<script type="text/javascript" src="/admin/reseller_locator/js/shadowbox-base.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/shadowbox.js"></script>
	<script type="text/javascript" src="/admin/reseller_locator/js/jquery.1.3.2.js"></script>
	

<link href="../css/resellers.css" media="screen" rel="Stylesheet" type="text/css"/>
	
	
	<script type="text/javascript">

	function locationChange() {
		// This is the hack for IE  source: http://stackoverflow.com/questions/208471/getting-jquery-to-recognise-change-in-ie
		if ($.browser.msie) {
		  $("input:radio[name=rb_location]").click(function() {
		    this.blur();
		    this.focus();
		  });
		}

		//web resource: http://www.techiegyan.com/?p=112
		$("input:radio[name=rb_location]").bind('change', function (event) {
			var reseller_location = $('input:radio[name=rb_location]:checked').val();
			if (reseller_location == 'int') {
//				alert('international territories to be shown');
				$('#listTerritories').load('assists/list_int_territories.php', {}, function() {
					//grabFormInputs();
				});
			} else {
//				alert('US territories to be shown');
				$('#listTerritories').load('assists/list_us_territories.php', {}, function(){
					//grabFormInputs();
				});
			}
			return false;
		});
	}

	function init() {
		$('#listTerritories').load('assists/list_int_territories.php');

		//set the location value
		$("input:radio[name=rb_location]").val();
	}
	$(document).ready(function() {
		init();
		locationChange();
		
		
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

<!--<div id="nav">-->
<!--	<ul>-->
<!--		<li><a href="../index.php">resellers</a></li>-->
<!--		<li><a href="../products/index.php">products</a></li>-->
<!--	</ul>-->
<!--</div>-->

<br />
Territories: <!-- - <a href="add_territory.php">add new territory</a>-->

<br />
	<input name="rb_location" type="radio" value="us"></input> US
	<input name="rb_location" type="radio" value="int" checked="checked"></input> International<br />
	<br />
	
	<div id="listTerritories"></div>

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