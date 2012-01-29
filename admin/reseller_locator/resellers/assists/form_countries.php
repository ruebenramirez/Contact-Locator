<?php

/*
 * form_countries.php
 * display the appropriate form input fields based on reseller location
 */

require('../../inc.php');


$country = null;
if(isset($_REQUEST['country'])) {
	$country = $_REQUEST['country'];
}

//check if is us
if (isset($_REQUEST['us']) && $_REQUEST['us'] == 1) {
	printUSCountryField();
} else {
	printIntCountryField($country);
}
?>


<?php

//handle international stuff
function printIntCountryField($countryAbbr=null) {
	?>
	
	<div class="label">Country:</div>
	<div class="formInput">
		<select name="country" id="country_select_input">
			<option value=""></option>
			<?php
			$sqlCountries = "SELECT short_name, name FROM countries ORDER BY name";
			$resultingCountries = mysql_query($sqlCountries) or die('died trying to get all countries: '.mysql_error());
			while ($country = mysql_fetch_assoc($resultingCountries)) {
				echo '<option value="'.$country['short_name'].'"';
				if(isset($countryAbbr) && $countryAbbr == $country['short_name']) {
					echo ' selected="yes"';
				}
				echo '>'.$country['name'].'</option>';
			}
			?>
		</select>
	</div>
	<br />
	<br />
	<?php
}

function printUSCountryField() {
	// fill the country_id listing with the United States id
	$sqlUSCountryCode ="SELECT id FROM countries WHERE name='United States';";
	$resultsCountryID = mysql_query($sqlUSCountryCode) or die('died getting US country id: '. mysql_error());
	while($country = mysql_fetch_assoc($resultsCountryID)) {
		echo '<input name="country" type="hidden" value="'.$country['id'].'"></input>';
	}
}
?>