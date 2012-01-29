<?php
/*
 * form_states.php
 * display the correct state form input fields depending on location
 */


require('../../inc.php');

$state = null;
if (isset($_REQUEST['state'])) {
	$state = $_REQUEST['state'];
}

if (isset($_REQUEST['us_reseller']) && $_REQUEST['us_reseller'] == 1) {
	$us_reseller = true;
} else {
	$us_reseller = false;
}

if (isset($_REQUEST['us']) && $_REQUEST['us'] == 1) {
	printUSStates($state, $us_reseller);
} else {
	printForInt($state, $us_reseller);
}

function printUSStates($state_id=null, $us_reseller=null) {
	?>
	<div class="label">State:</div>
	<div class="formInput">
		<select id="state" name="state">
			<!-- fill this from the states table -->
			<option value=""></option>
			<?php
			$sqlStates = "SELECT * FROM states ORDER BY state;";
			$resultStates = mysql_query($sqlStates) or die('died trying to get state listings: '.mysql_error());
			while($state = mysql_fetch_assoc($resultStates)) {
				echo '<option value="'.$state['id'].'"';
				if (isset($state_id) && $state_id == $state['id'] && $us_reseller) {
					echo ' selected="yes"';
				}
				echo '>'.$state['state'].'</option>';
			}
			?>
		</select>
	</div>
	<br />
	<br />
	<?php
}

function printForInt($state=null, $us_reseller=null) {
	?>
	<div class="label">State/Province:</div>
	<div class="formInput">
		<input id="state" type="text" name="state" value="
		<?php
			if(isset($state) && !$us_reseller) {
				echo $state;
			}
		?>
		"></input>
	</div>
	<br />
	<br />
	<?php
}

