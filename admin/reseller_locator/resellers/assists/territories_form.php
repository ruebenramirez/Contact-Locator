<?php
/*
 * territories_form.php
 * output the html form elements for inputting reseller territory information
 */

// check for previous submission but failed validation
// check for a $_REQUEST['reseller_id']


require('../../inc.php');

//check if is us
$us = 0;
if (isset($_REQUEST['us']) && $_REQUEST['us'] == 1) {
	$us = 1;
}

if (isset($_REQUEST['territories'])) {
	$territories = $_REQUEST['territories'];
	foreach($territories as $territory){
		printTerritoryDDL($us, $territory);
	}
} else {
	printTerritoryDDL($us);
}


function printTerritoryDDL($us=null, $territory_id=null) {
	?>
	<div class="territorySelection">
		<select name="territories[]" id="country_select_input">
			<option value="-1"></option>
			<?php
			$sqlCountries = "SELECT id, name FROM territories WHERE us = '".$us."' ORDER BY name";
			$resultingCountries = mysql_query($sqlCountries) or die('died trying to get all countries: '.mysql_error());
			while ($country = mysql_fetch_assoc($resultingCountries)) {
				echo '<option value="'.$country['id'].'"';
				if (isset($territory_id)) {
					if($territory_id == $country['id']) {
						echo ' selected="yes"';
					}
				}
				echo '>'.$country['name'].'</option>';
			}
			?>
		</select>
		<a class="removeTerritoryLink" href="">- remove</a>
	</div>
	<?php
}