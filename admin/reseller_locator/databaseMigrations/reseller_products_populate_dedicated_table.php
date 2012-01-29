<?php

/*
 * reseller_products_populate_dedicated_table.php
 * populate the resellers to products associative table.  (...replacing the old flags in the resellers table structure.)
 */

require('../inc.php');

$sqlGetresellers = "SELECT * FROM resellers;";
$resultResellers = mysql_query($sqlGetresellers) or die ('died getting resellers: '.mysql_error());
while($reseller = mysql_fetch_assoc($resultResellers)) {
	checkAndInsertProductAssoc($reseller, 'lightwave', 1);
	checkAndInsertProductAssoc($reseller, 'tricaster', 3);
	checkAndInsertProductAssoc($reseller, 'vt', 2);
	checkAndInsertProductAssoc($reseller, 'speededit', 4);
	checkAndInsertProductAssoc($reseller, 'darsenal', 5);

}

function checkAndInsertProductAssoc($reseller=null, $productName=null, $product_id=null) {
	if($reseller[$productName] == 1) {
		$sqlCheck = "SELECT * FROM reseller_products WHERE reseller_id = '".$reseller['id']."' AND product_id = '".$product_id."';";
		$resultsCheck = mysql_query($sqlCheck) or die ('died checking for '.$productName.' assoc: '.mysql_error());
		if (mysql_num_rows($resultsCheck) < 1) {
			$sqlInsert = "INSERT INTO reseller_products (reseller_id, product_id) VALUES('".$reseller['id']."', '".$product_id."');";
			mysql_query($sqlInsert) or die('died trying to insert tricaster record: '.mysql_error());
		}
	}
}