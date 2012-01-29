<?php

/*
 * form_distributor.php
 *
 */

if(isset($_REQUEST['us']) && $_REQUEST['us'] == 1) {
	printforUS();
} else {
	if (isset($_REQUEST['distributor']) && $_REQUEST['distributor'] != 0) {
		$distributor = 1;
	}
	printforInt($distributor);
}

function printforUS() {
	?>
	<input name="distributor" type="hidden" value="0" />
	<?php
}

function printforInt($distributor=null) {
	?>
	<div class="label">Distributor: </div>
	<div class="formInput">
		<input name="distributor" type="checkbox" value="1" <?php if(isset($distributor)) echo 'checked="checked"'; ?>></input>
	</div>
	<br /><br />
	
	<?php
}
