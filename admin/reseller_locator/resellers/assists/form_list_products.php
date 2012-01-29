<?php

/*
 * list_products_in_form.php
 */

require('../../inc.php');

$products = null;
if (isset($_REQUEST['products'])){
	$products = $_REQUEST['products'];
}

$sql = "SELECT id, name, logo FROM products ORDER BY name;";
$resultProducts = mysql_query($sql) or die('died getting products: '.mysql_error());
while($product = mysql_fetch_assoc($resultProducts)) {
	?>
	<div class="cb_product">
		<input name="products[]" type="checkbox" value="<?php echo $product['id'];?>" <?php printcheckValue($product['id'], $products);?>/>
		<?php echo $product['name']; ?>
	</div>
	<?php
}

function printcheckValue($id=null,$products=null) {
	if ($products != null) {
		if (in_array($id, $products)) {
			echo 'checked="checked"';
		}
	}
}