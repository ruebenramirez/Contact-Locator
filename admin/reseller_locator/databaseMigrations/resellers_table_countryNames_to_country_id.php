<?php
/*
 * resellers_table_countryNames_to_country_id.php
 * migrate all country names to country id's for the existing 'resellers' table
 */

require('../inc.php');

$sqlCountry = "SELECT country FROM resellers GROUP BY country;";
$resultsCountry = mysql_query($sqlCountry) or die('died trying to get countries: '.mysql_error());
while($resellerCountry = mysql_fetch_assoc($resultsCountry)) {
	//get the foreign key id for this country
	$sqlGetCountryID = "SELECT id FROM countries WHERE name = '".$resellerCountry['country']."';";
	$resultsCountryID = mysql_query($sqlGetCountryID);
	while($country = mysql_fetch_assoc($resultsCountryID)){
		// update the resellers table with the foreign key id
		$sqlUpdatewithCountryID = "UPDATE resellers SET country_id = '".$country['id']."' WHERE country = '".$resellerCountry['country']."'";
		mysql_query($sqlUpdatewithCountryID) or die('died trying to set country id: '.mysql_error());
	}
}