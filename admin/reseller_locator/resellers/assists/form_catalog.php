<?php

/*
 * form_catalog.php
 *
 */


if (isset($_REQUEST['catalog']) && $_REQUEST['catalog'] != 0) {
	$catalog = 1;
}
printCatalog($catalog);

function printCatalog($catalog=null) {
	//echo 'catalog: '.$catalog.'<br />';
	?>
	
	<div class="label">Catalog Partner:</div>
	<div class="formInput">
		<input name="catalog" type="checkbox" value="1" <?php if(isset($catalog) && $catalog == 1) echo 'checked="checked"'; ?>></input>
	</div>
	<br /><br />
	<?php
}

