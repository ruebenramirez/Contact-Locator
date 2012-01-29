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

<br />
<a href="find_int_resellers.php">back</a>
<br />
<br />

<i>*note: Resellers are listed in alphabetical order.</i>
<br />


<?php
//show listing of all resellers in this territory

if($product != 'all') {
	$sqlGetResellers = "SELECT * FROM `reseller_territories` JOIN `resellers` ON `reseller_territories`.reseller_id = `resellers`.id "
		."JOIN `reseller_products` ON `reseller_products`.reseller_id = `resellers`.id "
		."JOIN `states` ON `states`.id = `resellers`.state "
		."WHERE territory_id = '".$territory."' AND product_id = '".$product."' "
		."ORDER BY `resellers`.company ASC";
} else {
	$sqlGetResellers = "SELECT * FROM `reseller_territories` JOIN `resellers` ON `reseller_territories`.reseller_id = `resellers`.id "
		."JOIN `states` ON `states`.id = `resellers`.state "
		."WHERE territory_id = '".$territory."' "
		."ORDER BY `resellers`.company ASC";
}
	
$resultResellers = mysql_query($sqlGetResellers) or die('died getting resellers in this territory: '.mysql_error());
while($reseller = mysql_fetch_assoc($resultResellers)) {
	
	if ($GLOBALS['debug']) {
		echo "reseller var dump: <br />";
		var_dump($reseller);
		echo "<br />";
	}
	?>
	<div class="reseller">
		<div class="label">Company: </div>
		<div class="value"><?php echo $reseller['company'];?></div><br />
		
		<div class="label">Contact: </div>
		<div class="value"><?php echo $reseller['contact'];?></div><br />
		
		<div class="label">email: </div>
		<div class="value"><a href="mailto:<?php echo $reseller['email'];?>"><?php echo $reseller['email'];?></a></div><br />
		
		<div class="label">Phone: </div>
		<div class="value"><?php echo $reseller['phone'];?></div><br />
		
		<div class="label">Fax: </div>
		<div class="value"><?php echo $reseller['fax'];?></div><br />
		
		<div class="label">Address:</div>
		<div class="value">
			<?php echo $reseller['address'];?> <br />
			<?php echo $reseller['city'];?>, <?php echo $reseller['state'];?> <?php echo $reseller['zip'];?>
		</div>
		<br />
		
		<div class="resellerProductListing">
				<div class="">NewTek products sold:</div>
				<?php
				//display the product icons for this reseller
				$sqlGetProducts = "SELECT `products`.name, `products`.website, `products`.logo FROM `products` LEFT JOIN `reseller_products` ON `products`.id = `reseller_products`.product_id  WHERE `reseller_products`.reseller_id = '".$reseller['reseller_id']."' ORDER BY `products`.name";
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
	<?php
}
?>





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