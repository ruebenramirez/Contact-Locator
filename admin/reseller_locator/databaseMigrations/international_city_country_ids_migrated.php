<?php
/*
 * international_city_country_ids_migrated.php
 * replace the id's of city listings in the international_cities table with actual country id's for foreign key lookup.
 */

require('../inc.php');

$sqlCities = "SELECT cc1 FROM international_cities WHERE country_id = '0' GROUP BY cc1";
$cityResults = mysql_query($sqlCities) or die('died getting list of cities: '.mysql_error());
while($city = mysql_fetch_assoc($cityResults)) {
	echo 'Country '.$city['cc1'].'<br />';
	$sqlCountry = "SELECT id FROM countries WHERE short_name = '".$city['cc1']."'";
	$countryResult = mysql_query($sqlCountry) or die('died trying to lookup this citys country '.mysql_error());
	while ($country = mysql_fetch_assoc($countryResult)) {
		$sqlForeignKeySet = "UPDATE international_cities SET country_id = '".$country['id']."' WHERE cc1 = '".$city['cc1']."';";
		mysql_query($sqlForeignKeySet) or die('died trying to update the country ids in the international_cities table: '.mysql_error());
		echo 'Updated international_cities table: set cc1: '.$city['cc1'].' -> country_id: '.$country['id'].' <br />';
	}
}

?>