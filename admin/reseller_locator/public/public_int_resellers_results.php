<?php
/*
 * int_resellers_results.php
 */

require('../inc.php');

if (!isset($_REQUEST['region']) || !isset($_REQUEST['territory'])) {
	//if missing something, then send them back to the last page...
	header('location: find_int_resellers.php');
}
$region = $_REQUEST['region'];
$territory = $_REQUEST['territory'];
$product = $_REQUEST['product'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

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

<!--<link href="../css/resellers.css" media="screen" rel="Stylesheet" type="text/css"/>
-->

<script>
	$(document).ready( function() {
		$('#resellerSubNavigationMenuListings').load('/admin/reseller_locator/resellerSubNav.php');
	});
</script>

</head>




<body id="body">

<div class="space"> <a name="top"></a></div>

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


<div class="heading_style">Locate Resellers</div><br />

<div class="subtitle_bold">INTERNATIONAL </div>



<div class="hr"></div>
<div style="float:right;"><i>*note: Resellers are listed in alphabetical order.</i></div>

<a href="public_find_int_resellers.php">< BACK</a>

<div class="hr"></div>

	<?php
	//show listing of all resellers in this territory
	
	if($product != 'all') {
		$sqlGetResellers = "SELECT `resellers`.id, `resellers`.company,  `resellers`.email, `resellers`.contact, `resellers`.address, `resellers`.city, `resellers`.state, `resellers`.zip, `resellers`.phone, `resellers`.fax,`resellers`.specialistDealer "
			."FROM `reseller_territories` JOIN `resellers` ON `reseller_territories`.reseller_id = `resellers`.id "
			."JOIN `reseller_products` ON `reseller_products`.reseller_id = `resellers`.id "
			."JOIN `states` ON `states`.id = `resellers`.state "
			."WHERE territory_id = '".$territory."' AND product_id = '".$product."' "
			."ORDER BY `resellers`.company ASC";
	} else {
		$sqlGetResellers = "SELECT `resellers`.id, `resellers`.company,  `resellers`.email, `resellers`.contact, `resellers`.address, `resellers`.city, `resellers`.state, `resellers`.zip, `resellers`.phone, `resellers`.fax,`resellers`.specialistDealer "
			."FROM `reseller_territories` JOIN `resellers` ON `reseller_territories`.reseller_id = `resellers`.id "
			."JOIN `states` ON `states`.id = `resellers`.state "
			."WHERE territory_id = '".$territory."' "
			."ORDER BY `resellers`.company ASC";
	}
	
//	echo "<br />";
//	var_dump($sqlGetResellers);
//	echo "<br />";
		
	$resultResellers = mysql_query($sqlGetResellers) or die('died getting resellers in this territory: '.mysql_error());
	while($reseller = mysql_fetch_assoc($resultResellers)) {
		
//        echo "<br />";
//        var_dump($reseller);
//        echo "<br />";
        
        ?>
    <div class="reseller_box">
	  	<div class="reseller">
	  		<?php
	  		if($reseller['specialistDealer']) {
				echo '<div style="float:right;"><img class="eliteImage" src="../logo_specialistdealer.jpg" width="101px" height="26px"/></div>';
			}
			?>
	  		
			<div class="subtitle_bold"><?php echo $reseller['company'];?></div><br>
			<?php
			echo $reseller['address'].'<br />';
			echo $reseller['city'].', '.$reseller['state'].' '.$reseller['zip'];
			
			// Google Map Link
			if (!empty($reseller['address']) && isset($reseller['state']) && isset($reseller['zip'])) {
				echo '&nbsp;&nbsp;<a style="font-weight: bold;" href="http://maps.google.com/maps?q='.$reseller['address'].'+,+'.$reseller['state'].'+'.$reseller['zip'].'&iwloc=A&hl=en">Map</a><br />';
			}
			
			if(!empty($reseller['email']) && isset($reseller['contact'])) {
				echo '<br /><a href="mailto:'.$reseller['email'].'">';
					echo '<strong>'.$reseller['contact'].'</strong>';
				echo '</a>';
				
				if(!empty($reseller['contact2']) && !empty($reseller['email2'])) {
					echo ' | <a href="mailto:'.$reseller['email2'].'">';
						echo '<strong>'.$reseller['contact2'].'</strong>';
					echo '</a>';
				}
				
			}
			
			
			if(!empty($reseller['phone'])) {
				echo '<br />Phone: '.$reseller['phone'];
				if(!empty($reseller['phone2'])) {
					echo ' | '.$reseller['phone2'];
				}
			}
			
			if(!empty($reseller['fax'])) {
				echo '<br />Fax: '.$reseller['fax'];
			}
			?>
						
			<br /><br />
	  		<div class="resellerProductListing">
				<div class="">NewTek products sold:</div>
				<?php
				//display the product icons for this reseller
				$sqlGetProducts = "SELECT `products`.name, `products`.website, `products`.logo FROM `products` LEFT JOIN `reseller_products` ON `products`.id = `reseller_products`.product_id  WHERE `reseller_products`.reseller_id = '".$reseller['id']."' ORDER BY `products`.name";
				$resultProducts = mysql_query($sqlGetProducts) or die('died getting all products for this reseller: '.mysql_error()." <br />sql: ".$sqlGetProducts);
				
				if($GLOBALS['debug']) {
					echo "sql: ".$sqlGetProducts."<br />";
					echo 'number of products returned for this reseller: '.mysql_num_rows($resultProducts);
				}
				$productCount = 0;
				while($resellerProduct = mysql_fetch_object($resultProducts)) {
					if ($productCount++ != 0) {
						echo " | ";
					}
					
					echo '<a href="'.$resellerProduct->website.'">'.$resellerProduct->name.'</a>';
				}
				?>
			</div>
		</div>
	</div>
	<div align="right" style="margin-bottom:-15px;margin-top:10px;">
		<a href="#top">
			<img src="http://sandbox.newtek.com/newtek_new/images/top.jpg" alt="top" width="54" height="25" border="0" />
		</a>
	</div>
    <div class="hr"></div>
	<?php
	}
	?>






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