<?php
/*
 * insert_countries_as_territories.php
 */

require('../inc.php');
$sqlGetCountries = "SELECT name FROM countries";
$resultCountries = mysql_query($sqlGetCountries) or die('died getting list of countries. error: '.mysql_error());
while($country = mysql_fetch_assoc($resultCountries)) {
	$sqlcheckTerritoryexists = "SELECT name FROM territories WHERE name='".addslashes($country['name'])."'";
	$resultCountryExists = mysql_query($sqlcheckTerritoryexists) or die('died checking if territory already exists. <br />sql: '.$sqlcheckTerritoryexists.'<br />error: '.mysql_error());
	if (mysql_num_rows($resultCountryExists) < 1) {
		$sqlAddTerritory = "INSERT INTO territories (name, us) VALUES('".addslashes($country['name'])."', '0');";
		mysql_query($sqlAddTerritory) or die('died adding the territory: '.mysql_error());
	}
}
?>