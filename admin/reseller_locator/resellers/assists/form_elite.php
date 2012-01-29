<?php

/*
 * form_elite.php
 *
 */

if(isset($_REQUEST['us']) && $_REQUEST['us'] == 1) {
	if (isset($_REQUEST['elite']) && $_REQUEST['elite'] != 0) {
		$elite = 1;
	}
	printforUS($elite);
} else {
	printforInt();
}

function printforUS($elite=null) {
	?>
	<div class="label">Elite Partner:</div>
	<div class="formInput">
		<input name="elite" type="checkbox" value="1" <?php if(isset($elite) && $elite == 1) echo 'checked="checked"'; ?>></input>
	</div>
	<br /><br />
	<?php
}

function printforInt() {
	?>
	<input name="elite" type="hidden" value="0" />
	<?php
}
