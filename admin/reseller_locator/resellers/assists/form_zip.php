<?php

/*
 * zip_form.php
 * output form elements for zip html form input field
 */

$zipCode = null;
if (isset($_REQUEST['zip'])) {
	$zipCode = $_REQUEST['zip'];
}


if (isset($_REQUEST['us']) && $_REQUEST['us'] == 1) {
	printForUS($zipCode);
} else {
	printForInt();
}

function printForUS($zip=null) {
	?>
	<div class="label">Zip:</div>
	<div class="formInput">
		<input id="zip" name="zip" type="text" value="
		<?php
		if(isset($zip)) {
			echo $zip;
		}
		?>
		"></input>
	</div>
	<br />
	<br />
	<br />
	<?php
}

function printForInt() {
	?>
	<input id="zip" name="zip" type="hidden" value="-1"></input>
	<?php
}