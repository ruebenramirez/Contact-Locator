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
	<title>NewTek.com - Locate Resellers - US Resellers</title>
	
	<script type="text/javascript" src="/admin/reseller_locator/js/jquery.1.3.2.js"></script>
	<link href="/newtek_new/css/newtek_main.css" rel="stylesheet" type="text/css" />
	<link href="/newtek_new/p7epm/epm50/p7EPM50.css" rel="stylesheet" type="text/css" media="all" />
	<script type="text/javascript" src="/newtek_new/p7epm/p7EPMscripts.js"></script>
	<script type="text/javascript" src="/newtek_new/js/p7uberlink.js"></script>


	

	<script>
		$(document).ready( function() {
			$('#resellerSubNavigationMenuListings').load('/admin/reseller_locator/resellerSubNav.php');
		});
	</script>

	</head>

<body id="body" onload="P7_Uberlink('uberlink','subnav_list')">


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

<div class="subtitle_bold">U.S.</div>


<br />
	
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
		<?php

} else {

	?>
    
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	
	<title>NewTek.com - Locate Resellers - US Resellers</title>
	
	<script type="text/javascript" src="/admin/reseller_locator/js/jquery.1.3.2.js"></script>
	<link href="/newtek_new/css/newtek_main.css" rel="stylesheet" type="text/css" />
	<link href="/newtek_new/p7epm/epm50/p7EPM50.css" rel="stylesheet" type="text/css" media="all" />
	<script type="text/javascript" src="/newtek_new/p7epm/p7EPMscripts.js"></script>
	<script type="text/javascript" src="/newtek_new/js/p7uberlink.js"></script>

	<script>
		$(document).ready( function() {
			$('#resellerSubNavigationMenuListings').load('/admin/reseller_locator/resellerSubNav.php');
		});
	</script>

	</head>
	<body id="body" onload="P7_Uberlink('uberlink','subnav_list')">

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

<div class="subtitle_bold">U.S.</div>
<div class="hr"></div>


	
		<?php printZipEntryForm(); ?>
		
		
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
	<?php
}

function returnResellersForZip($zip=null, $product=null) {
	global $debug;
	//process the submitted zip
	$authorized_resellers = getCloseUSResellers($zip, $product);
	$elite_partners = getCloseUSResellers($zip, $product, true);
	?>
    <div class="hr"></div>
<a href="">< BACK</a>
<div class="hr"></div>

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
	
	<form method="POST" action="">
	<?php
	if (!$validZip) {
		echo '<div class="hr"></div><div class="not_valid">Please enter a valid zip code.</div><div class="hr"></div>';
	}
	?>
	
	<br />Zip<br>
 <input type="text" name="zip"></input> <br /><br>

	
	Product<br>

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
	<br /><br>

	
	<input type="hidden" value="1" name="submitted"/>
	<input type="submit" value="search"/>
	</form>
	 <?php
}

function printReseller($id=null, $elite=false) {
	if (!isset($id)) {
		return false;
	}

	$sql = "SELECT `resellers`.elite, `resellers`.website, `resellers`.company, "
	."`resellers`.email, `resellers`.contact, `resellers`.phone, `resellers`.fax, "
	."`resellers`.contact2, `resellers`.email2, `resellers`.phone2, "
	."`resellers`.address, `resellers`.city, `states`.state, `resellers`.zip "
	." FROM resellers JOIN `states` ON `resellers`.state = `states`.id WHERE `resellers`.id = '$id'";
	$results = mysql_query($sql) or die('died trying to get this resellers info: '.mysql_error());
	while($row=mysql_fetch_assoc($results)) {
		?>
		 <div class="reseller_box">
		<div class="reseller <?php if($elite) echo "elite";?>">
			<?php
			if($elite) {
				echo '<div style="float:right;"><img class="eliteImage" src="../elite_logo.jpg" width="101px" height="26px"/></div>';
			}
			
			//company name
			if(!empty($row['company'])) {
				echo '<div class="subtitle_bold">'.$row['company'].'</div><br />';
			}
			
			//company address
			if(!empty($row['address'])) {
				echo $row['address'];
				echo '<br />';
				echo $row['city'].', '.$row['state'].' '.$row['zip'].'&nbsp;&nbsp;';
			}
			//display the google map link
			if(!empty($row['address']) && isset($row['state']) && isset($row['zip'])) {
				echo '<a style="font-weight: bold;" href="http://maps.google.com/maps?q='.$row['address'].'+,+'.$row['state'].'+'.$row['zip'].'&iwloc=A&hl=en">Map</a><br />';
			}

			//primary contact information
			if(!empty($row['email']) && isset($row['contact'])) {
				echo '<br /><div class="value"><a href="mailto:'.$row['email'].'"><strong>'.$row['contact'].'</strong></a>';
				
				if(!empty($row['contact2']) && isset($row['email2'])) {
					echo ' | <a href="mailto:'.$row['email2'].'"><strong>'.$row['contact2'].'</strong></a>';
				}
				
				echo '</div>';
			}
			//phone 1
			if(!empty($row['phone'])) {
				echo 'Phone: '.$row['phone'];
				// phone 2
				if(!empty($row['phone2'])){
					echo '  |  '.$row['phone2'];
				}
			}
			
			//fax 1
			if(!empty($row['fax'])) {
				echo '<br />Fax: '.$row['fax'];
			}
			
			?>
			<br /><br />
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
		
		</div></div>
        
         <div align="right" style="margin-bottom:-15px;margin-top:10px;"><a href="#top"><img src="http://sandbox.newtek.com/newtek_new/images/top.jpg" alt="top" width="54" height="25" border="0" /></a></div>
    <div class="hr"></div>

		<?php
	}
}
