<?php
/*
 * regions_form.php
 * output the html form elements for inputting territory region information
 */

// check for previous submission but failed validation
// check for a $_REQUEST['reseller_id']


require('../../inc.php');

if (isset($_REQUEST['regions'])) {
	$regions = $_REQUEST['regions'];
	foreach($regions as $region){
		printRegionDDL($region);
	}
} else {
	printRegionDDL();
}


function printRegionDDL($region_id=null) {
	?>
	<div class="territorySelection">
		<select name="regions[]" id="region_select_input">
			<option value="-1"></option>
			<?php
			$sqlCountries = "SELECT id, name FROM regions ORDER BY name";
			$resultingCountries = mysql_query($sqlCountries) or die('died trying to get all countries: '.mysql_error());
			while ($country = mysql_fetch_assoc($resultingCountries)) {
				echo '<option value="'.$country['id'].'"';
				if (isset($region_id)) {
					if($region_id == $country['id']) {
						echo ' selected="yes"';
					}
				}
				echo '>'.$country['name'].'</option>';
			}
			?>
		</select>
		<a class="removeRegionLink" href="">- remove</a>
	</div>
	<?php
}