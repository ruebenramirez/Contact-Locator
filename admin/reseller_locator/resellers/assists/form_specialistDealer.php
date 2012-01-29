<?php
/*
 * form_specialistDealer.php
 *
 */

if(isset($_REQUEST['us']) && $_REQUEST['us'] == 1) {
	printforUS();
} else {
	if (isset($_REQUEST['specialistDealer']) && $_REQUEST['specialistDealer'] != 0) {
		$specialistDealer = 1;
	}
	printforInt($specialistDealer);
}

function printforUS() {
	?>
	<input name="specialistDealer" type="hidden" value="0" />
	<?php
}

function printforInt($specialistDealer=null) {
	?>
	<div class="label">Specialist Dealer: </div>
	<div class="formInput">
		<input name="specialistDealer" type="checkbox" value="1" <?php if(isset($specialistDealer)) echo 'checked="checked"'; ?>></input>
	</div>
	<br /><br />
	
	<?php
}
