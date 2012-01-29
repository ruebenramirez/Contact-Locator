<?php

/*
 * find_us_resellers.php
 *
 */
require('../inc.php');

//var_dump($_REQUEST);

if (isset($_REQUEST['submitted']) && $_REQUEST['submitted'] == 1) {
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>US & Canadian Resellers</title>

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

<link rel="stylesheet" type="text/css" href="../css/resellers.css" />

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

<?php
	if (isset($_REQUEST['zip']) && !empty($_REQUEST['zip'])) {
		if (validateZipCode($_REQUEST['zip'])) {
			returnResellersForZip($_REQUEST['zip'], $_REQUEST['product']);
		} else {
			printZipEntryForm(false);
		}
	} else {
		printZipEntryForm(false);
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
	<?php

} else {

	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Find local resellers</title>

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

<link rel="stylesheet" type="text/css" href="../css/resellers.css" />

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

	<?php printZipEntryForm(); ?>
	
	
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
	<?php
}

function returnResellersForZip($zip=null, $product=null) {
	global $debug;
	//process the submitted zip
	$authorized_resellers = getCloseUSResellers($zip, $product);
	$elite_partners = getCloseUSResellers($zip, $product, true);
	?>
<a href="">back</a>
<br />
<br />
	<?php
	if ($debug) var_dump($elite_partners);
	foreach($elite_partners as $ePartner) {
		printReseller($ePartner, true);
	}

	if ($debug) var_dump($authorized_resellers);
	foreach($authorized_resellers as $authReseller) {
		printReseller($authReseller);
	}
}


function printZipEntryForm($validZip=true) {
	?>
	<br />
	<form method="POST" action="">
	<?php
	if (!$validZip) {
		echo '<div class="not_valid">Please enter a valid zip code.</div>';
	}
	?>
	
	Zip: <input type="text" name="zip"></input> <br />
	
	Product:
	<select name="product">
		<option value="all">All Products</option>
		<?php
			$sqlGetProducts = "SELECT id, name FROM products";
			$resultProducts = mysql_query($sqlGetProducts) or die('died getting products: '.mysql_error());
			while($product = mysql_fetch_object($resultProducts)) {
				echo '<option value="'.$product->id.'">'.$product->name.'</option>';
			}
		?>
	</select>
	<br />
	
	<input type="hidden" value="1" name="submitted"/>
	<input type="submit" value="search"/>
	</form>
	 <?php
}

function printReseller($id=null, $elite=false) {
	if (!isset($id)) {
		return false;
	}

	$sql = "SELECT `resellers`.elite, `resellers`.website, `resellers`.company, `resellers`.email, `resellers`.contact, `resellers`.phone, `resellers`.fax, `resellers`.address, `resellers`.city, `states`.state, `resellers`.zip "
	." FROM resellers JOIN `states` ON `resellers`.state = `states`.id WHERE `resellers`.id = '$id'";
	$results = mysql_query($sql) or die('died trying to get this resellers info: '.mysql_error());
	while($row=mysql_fetch_assoc($results)) {
		?>
<div class="reseller <?php if($elite) echo "elite";?>">
	<?php
		if($elite) {
			echo '<img class="eliteImage" src="../elite_logo.jpg" /><br /><br /><br />';
		}
	?>

	<div class="label">Company: </div> <a href="<?php echo $row['url'];?>"><?php echo $row['company'];?></a><br />
	<div class="label">Contact: </div>
	<div class="value"><a href="mailto:<?php echo $row['email'];?>"><?php echo $row['contact'];?></a></div><br />
	
	<div class="label">Phone: </div>
	<div class="value"><?php echo $row['phone'];?></div><br />
	
	<div class="label">Fax: </div>
	<div class="value"><?php echo $row['fax'];?></div><br />
	
	<div class="label">Address:</div>
	<div class="value">
		<?php echo $row['address'];?> <br />
		<?php echo $row['city'];?>, <?php echo $row['state'];?> <?php echo $row['zip'];?>
	</div>
	
	<div class="resellerProductListing">
				<div class="">NewTek products sold:</div>
				<?php
				//display the product icons for this reseller
				$sqlGetProducts = "SELECT `products`.name, `products`.website, `products`.logo FROM `products` LEFT JOIN `reseller_products` ON `products`.id = `reseller_products`.product_id  WHERE `reseller_products`.reseller_id = '".$id."' ORDER BY `products`.name";
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
	<br />
</div>
		<?php
	}
}